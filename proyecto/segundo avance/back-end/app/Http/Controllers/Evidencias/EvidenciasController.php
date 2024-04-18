<?php

namespace App\Http\Controllers\Evidencias;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Http\JsonResponse;
use App\Models\OrdenesDeTrabajo;
use App\Models\ArchivosEvidencias;
use App\Models\CfdisConceptos;
use App\Models\CfdisRecibidos;
use App\Models\OdvctFinanzas;
use App\Models\Proveedores;
use App\Models\Evidencias;
use App\Mail\CorreoRechazoEvidencia;
use Illuminate\Support\Facades\Mail;
use App\Utils\Utils;
use Dflydev\DotAccessData\Util;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class EvidenciasController extends Controller
{


    public function odtEvidenciasCerradas(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $planner = $request->input('planner');
        $idEjecutiva = $request->input('idEjecutiva');
        $listClientes = "";
        if (!empty($idEjecutiva)) {
            $listClientes = $this->clientesEjecutivaList($idEjecutiva);
            // return $listClientes;
        }
        $dateStart = "DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";
        $dateEnd = "CURRENT_DATE";
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $dateStart = $fechaInicio;
            $dateEnd = $fechaFin;
        }

        $registros = OrdenesDeTrabajo::from('odvCT as odt')->select(
            'cu.Nombre AS Ejecutiva',
            'odt.Idauto AS OdT',
            'odt.Planner',
            'odt.Folio',
            'odt.CdDeCarga AS Origen',
            'odt.CdDesCarga AS Destino',
            'c.RazonSocial AS Cliente',
            'p.RazonSocial AS Proveedor',
            'odt.Moneda',
            'odt.Evidencias',
            'odt.Tractor',
            'odt.NumRemolque1',
            'odt.activoCerrado',
            'odt.Cerrado'
        )
            ->join('clientesCT as c', 'c.Id', '=', 'odt.IdCliente')
            ->join('proveedoresCT as p', 'p.Id', '=', 'odt.IdProveedor')
            ->leftJoin('cuentasUSUARIOS as cu', 'cu.Id', '=', 'c.Ejecutiva')
            ->leftJoin('evidenciasCT as e', 'odt.Idauto', '=', 'e.OdT')
            ->selectRaw("
            DATE_FORMAT(odt.timestamp2, '%d/%m/%Y') as Alta,
            COALESCE(DATE_FORMAT(e.tmstAltaEv, '%d/%m/%Y'),'Sin Fecha')  AS AltaEv,
            COALESCE(DATE_FORMAT(e.tmstCerrarEv, '%d/%m/%Y'),'Sin Fecha')  AS FechaCierre
                        ")
            ->where("odt.Cerrado", "=", 1)
            ->where("odt.activoCerrado", "=", 0)

            /**
             * !Condition Planner
             * Si planner Existe  ejecuta planner
             */
            ->when($planner, function ($query, $condition) {
                return $query->where('odt.Planner', "$condition");
            })

            ->when($listClientes, function ($query, $conditionEje) {
                $clienteIds = explode(',', $conditionEje);
                return $query->whereIn('odt.IdCliente', $clienteIds);
            })
            ->whereBetween(DB::raw('DATE(timestamp2)'), [$dateStart, $dateEnd])

            ->get();

            if (!$registros) {
                return sendApiFailure(
                    (object) [],
                    "Registro de odt Cerradas no encontrado",
                    404
                );
            }

            return sendApiSuccess(
                $registros,
                "Consulta de Odt Cerradas para Evidencias Correcta"
            );
    }
    public function odtEvidenciasAbiertas(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $planner = $request->input('planner');
        $idEjecutiva = $request->input('idEjecutiva');
        $listClientes = "";
        if (!empty($idEjecutiva)) {
            $listClientes = $this->clientesEjecutivaList($idEjecutiva);
            // return $listClientes;
        }
        $dateStart = "DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";
        $dateEnd = "CURRENT_DATE";
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $dateStart = $fechaInicio;
            $dateEnd = $fechaFin;
        }

        $registros = OrdenesDeTrabajo::from('odvCT as odt')->select(
            'cu.Nombre AS Ejecutiva',
            'odt.Idauto AS OdT',
            'odt.Planner',
            'odt.Folio',
            'odt.CdDeCarga AS Origen',
            'odt.CdDesCarga AS Destino',
            'c.RazonSocial AS Cliente',
            'p.RazonSocial AS Proveedor',
            'odt.Moneda',
            'odt.Evidencias',
            'odt.Tractor',
            'odt.NumRemolque1',
            'odt.activoCerrado',
            'odt.Cerrado'
        )
            ->join('clientesCT as c', 'c.Id', '=', 'odt.IdCliente')
            ->join('proveedoresCT as p', 'p.Id', '=', 'odt.IdProveedor')
            ->leftJoin('cuentasUSUARIOS as cu', 'cu.Id', '=', 'c.Ejecutiva')
            ->leftJoin('evidenciasCT as e', 'odt.Idauto', '=', 'e.OdT')
            ->selectRaw("
            DATE_FORMAT(odt.timestamp2, '%d/%m/%Y') as Alta,
            COALESCE(DATE_FORMAT(e.tmstAltaEv, '%d/%m/%Y'),'Sin Fecha')  AS AltaEv,
            COALESCE(DATE_FORMAT(e.tmstCerrarEv, '%d/%m/%Y'),'Sin Fecha')  AS FechaCierre
                    ")
            ->where("odt.Cerrado", "=", 0)
            ->where("odt.activoCerrado", "=", 1)

            /**
             * !Condition Planner
             * Si planner Existe  ejecuta planner
             */
            ->when($planner, function ($query, $condition) {
                return $query->where('odt.Planner', "$condition");
            })

            ->when($listClientes, function ($query, $conditionEje) {
                $clienteIds = explode(',', $conditionEje);
                return $query->whereIn('odt.IdCliente', $clienteIds);
            })
            ->whereBetween(DB::raw('DATE(timestamp2)'), [$dateStart, $dateEnd])

            ->get();

            if (!$registros) {
                return sendApiFailure(
                    (object) [],
                    "Registro de odt Abiertas no encontrado",
                    404
                );
            }

            return sendApiSuccess(
                $registros,
                "Consulta de Odt Abiertas para Evidencias Correcta"
            );
    }
    public function odtEvidenciasFinalizadas(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');
        $planner = $request->input('planner');
        $idEjecutiva = $request->input('idEjecutiva');
        $listClientes = "";
        if (!empty($idEjecutiva)) {
            $listClientes = $this->clientesEjecutivaList($idEjecutiva);
            // return $listClientes;
        }
        $dateStart = "DATE_SUB(CURRENT_DATE, INTERVAL 1 MONTH)";
        $dateEnd = "CURRENT_DATE";
        if (!empty($fechaInicio) && !empty($fechaFin)) {
            $dateStart = $fechaInicio;
            $dateEnd = $fechaFin;
        }

        $registros = OrdenesDeTrabajo::from('odvCT as odt')->select(
            'odt.Idauto',
            'odt.OdV',
            'odt.Estimacion',
            'odt.Planner',
            'odt.Folio',
            'odt.TipoDeUnidad',
            'odt.NombreOperador',
            'odt.CelularOperador',
            'odt.Tractor',
            'odt.PlacasTractor',
            'odt.NumRemolque1',
            'odt.PlacasRemolque1',
            'odt.NumRemolque1',
            'odt.PlacasRemolque1',
            'odt.CiudadCarga',
            'odt.CdDeCarga',
            'odt.CiudadDesCarga',
            'odt.CdDesCarga',
            'odt.CalleCarga',
            'odt.EstadoCarga',
            'odt.PaisCarga',
            'odt.CalleDesCarga',
            'odt.EstadoDesCarga',
            'odt.PaisDesCarga',
            'odt.Link',
            'odt.UsuarioLink',
            'odt.Pass',
            'odt.Estimacion',
            'odt.Etapa',
            'odt.Cliente',
            'odt.Proveedor',
            'odt.TarifaCobro',
            'odt.TarifaPago',
            'odt.MargenMoneda',
            'odt.MargenPorcentaje',
            'odt.CobroAccesorio',
            'odt.Evidencias',
            'odt.PagoAccesorio',
            'odt.Moneda'
        )
            ->leftJoin('clientesCT as c', 'c.Id', '=', 'odt.IdCliente')
            ->leftJoin('cuentasUSUARIOS as cu', 'cu.Id', '=', 'c.Ejecutiva')
            ->selectRaw("
            COALESCE(cu.Nombre,'Sin Ejecutiva') AS Ejecutiva,
            DATE_FORMAT(odt.timestamp2, '%d/%m/%Y') as Alta,
            DATE_FORMAT(odt.SalidaDescarga, '%d/%m/%Y') as SalidaDescarga
                    ")
            ->where("odt.Cerrado", "=", 0)
            ->where("odt.activoCerrado", "=", 0)
            ->where("odt.Etapa", "!=", 'Cancelado')

            /**
             * !Condition Planner
             * Si planner Existe  ejecuta planner
             */
            ->when($planner, function ($query, $condition) {
                return $query->where('odt.Planner', "$condition");
            })

            ->when($listClientes, function ($query, $conditionEje) {
                $clienteIds = explode(',', $conditionEje);
                return $query->whereIn('odt.IdCliente', $clienteIds);
            })
            ->whereBetween(DB::raw('DATE(timestamp2)'), [$dateStart, $dateEnd])

            ->get();

            if (!$registros) {
                return sendApiFailure(
                    (object) [],
                    "Registro de odt Finalizadas no encontrado",
                    404
                );
            }

            return sendApiSuccess(
                $registros,
                "Consulta de Odt Finalizada para Evidencias Correcta"
            );
    }
    public function clientesEjecutivaList($id)
    {
        $resultados = DB::table('clientesCT')
            ->selectRaw("
        COALESCE(GROUP_CONCAT(Id), 0) AS clientesList
                ")
            ->where("Ejecutiva", "=", $id)
            ->value('clientesList');
        return $resultados;
    }
    public function evidenciaOdt(Request $request,$id)
    {

        $registros = ArchivosEvidencias::select(
            'Id',
            'nombreArchivo',
            'Tipo',
            'Extension',
            'Estatus',
            'Comentario'
            )
            ->where("OdT", "=", $id)
            ->get();

            if (!$registros) {
                return sendApiFailure(
                    (object) [],
                    "Registro de Evidencia no encontrado",
                    404
                );
            }

            return sendApiSuccess(
                $registros,
                "Evidencias obtenidas correctamente"
            );
    }
    public function altaEvidencia(Request $request)
    {
        /**
         * Validamos si recibio algun archivo
         */
        if (!$request->hasFile('archivo')) {
            return sendApiFailure(
                (object) [],
                "No se recibieron archivos",
                404
            );
        }
        //Validacion de campos obligatorios
        $request->validate([
            "odt" => ["required"],
            "idUsuario" => ["required"], //Temporal

        ]);
        $archivos = $request->file('archivo');
        // $extension = $archivo->getClientOriginalExtension();
        $resultados = [];
        $ultimoID = ArchivosEvidencias::max('Id');
        $odt = $request->input('odt');
        /**
         * Apartado temporal (Por el momento se manda el usuarion para la alta de archivos,
         *  posteriormente cuando este en produccion el login se tomaran las variables de session)
         */
        $idUser = $request->input('idUsuario');
        $usuario= DB::table('cuentasUSUARIOS')
        ->select("Usuario")
        ->where("Id", "=", $idUser)
        ->value('Usuario');

        Evidencias::updateOrInsert(
            ['OdT' => $odt],
            [
                "tmstAltaEv" => date("Y-m-d H:i:s"),
                "epochAltaEv" => (string)(time() * 1000)
            ]
        );
         /**
         * Actualiza o Inserta en la nueva tabla
         */
        DB::table('v3_evidencias_odt')->updateOrInsert(
            ['id_odt' => $odt],
            ['fecha_alta' => DB::raw('NOW()')]
        );

        foreach ($archivos as $archivo) {
            $extension = $archivo->getClientOriginalExtension();
            // $nombreOriginal = $archivo->getClientOriginalName();
            $nombreArchivo=$odt."_".$ultimoID."_evidencia";
              // Obtén el tipo (MIME type) del archivo
            $tipoArchivo = $archivo->getMimeType();
            $nuevoArchivo = ArchivosEvidencias::create([
                "OdT" => $odt,
                "Tipo" => $tipoArchivo,
                "nombreArchivo" => $nombreArchivo,
                "Extension" => $extension,
                "tmstAltaRegistro" => date("Y-m-d H:i:s"),
                "epochRegistro" => (string)(time() * 1000),
                "Usuario" => $usuario // Asegúrate de tener $usuario definido en este contexto
            ]);

            if (!$nuevoArchivo) {
                return sendApiFailure(
                    (object) [],
                    "Error en alta de archivo de evidencia",
                    404
                );
            }
            /**
             * Insertamos en la nueva tabla
             */
            DB::table('v3_archivos_ev_odt')->insert([
                'id_odt' => $odt,
                "tipo" => $tipoArchivo,
                "nombre" => $nombreArchivo,
                "extension" => $extension,
                "usuario" => $usuario,
                "id_usuario" => $idUser,
            ]);
            /**
             * Manda los archivos a la carpeta de store y app, depende el nombre que le coloques es a la carpeta que los manda
             * En este caso fue a app/evidencias
             */
            $store  = $archivo->storeAs('files/evidencias', $nombreArchivo . '.' . $extension, 'local');

            $resultados[] = [
                'nombre' => $nombreArchivo,
                'extension' => $extension,
                'tipoArchivo' => $tipoArchivo,
                'Ubicacion' => $store

            ];
            $ultimoID++;
        }
            OrdenesDeTrabajo::where('Idauto', $odt)
            ->update(['Evidencias' => 1]);

        return sendApiSuccess(
            $resultados,
            "Archivo subido con éxito"
        );

    }
    public function cerrarEvidencia(Request $request)
    {
        $request->validate([
            "odt" => ["required"],
            "idUsuario" => ["required"], //Temporal
        ]);
        /**
         * Apartado temporal (Por el momento se manda el usuarion para la alta de archivos,
         *  posteriormente cuando este en produccion el login se tomaran las variables de session)
         */
        $idUser = $request->input('idUsuario');
        $odt = $request->input('odt');

        $cantidadEv3 = CfdisConceptos::where("id_referencia", "=", $odt)
        ->where("evidencia", "=", 3)
        ->count();
        if($cantidadEv3>0){
        /**
         *  Actualizar todos los registros con evidencia igual a 2
         */
        $actualizaciones = CfdisConceptos::where("id_referencia", $odt)
        ->update(['evidencia' => 2]);
        }
        $listFacturas = $this->facturasOdt($odt);

        $facturas = $this->facturasPorCerrar($listFacturas,$odt);

        $facturasActualizadas = !empty($facturas) ? $this->actualizarFacturas($facturas) : null;

       $respuestaEvidencia= Evidencias::updateOrInsert(
            ['OdT' => $odt],
            [
                'tmstCerrarEv' => date("Y-m-d H:i:s"),
                'epochCerrarEv' => (string)(time() * 1000)
            ]
        );
        if(!$respuestaEvidencia){
            return sendApiFailure(
                (object) [],
                "Error en alta de archivo de evidencia",
                404
            );
        }
        DB::table('v3_evidencias_odt')->updateOrInsert(
            ['id_odt' => $odt],
            ['fecha_cierre' => DB::raw('NOW()')],
            ['fecha_cierre_odt' => DB::raw('NOW()')],
            ['usuario_cierre' => $idUser],
        );

        /**
         * Actualizar la tabla "oddCT"
         **/
        $dataOdd = [
            'epochCerrarOdD' => time() * 1000,
            'tmstCerrarOdD' => now(),
            'idOdt' => $odt,
        ];

        $respuestaOdd= DB::table('oddCT')
            ->where('idOdT', $odt)
            ->update($dataOdd);
        if($respuestaOdd){
            OrdenesDeTrabajo::where('Idauto', $odt)
            ->update(['Cerrado' => 1]);
        }
        //Pendiente la actualizacion
        $resultado = array(
            "listFacturas"         => $listFacturas,
            "Cantidad Facturas Actualizadas" => $facturasActualizadas
        );
        return sendApiSuccess(
            $resultado,
            "Cierre de Odt Exitoso"
        );
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->user()->allowOrFail("EVIDENCIAS", "VIEW");

        if ($request->has("for_view")) {
            switch ($request->get("for_view")) {
                case 'odtCerradaEv':
                    return $this->odtEvidenciasCerradas($request);
                    break;
                case 'odtAbiertasEv':
                    return $this->odtEvidenciasAbiertas($request);
                    break;
                case 'odtFinalizadaEv':
                    return $this->odtEvidenciasFinalizadas($request);
                    break;
                case 'AltaEvidencia':
                 $request->user()->allowOrFail("EVIDENCIAS", "CREATE");

                    return $this->altaEvidencia($request);
                    break;
                case 'cerrarEvidencia':
                    return $this->cerrarEvidencia($request);
                    break;
                default:
                    return "No existe opcion Opcion";
                    break;
            }
        }
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, int $id)
    {
        $request->user()->allowOrFail("EVIDENCIAS", "VIEW");

        if ($request->has("for_view")) {
            switch ($request->get("for_view")) {
                case "evidencia":
                    // return "Esta es la evidencia de la odt: " . $id;
                    return $this->evidenciaOdt($request, $id);
                    break;
                default:
                    return "No existe opcion Opcion";

                    break;
            }
        }
        return $request;

        // return $this->genericShow($request, $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->user()->allowOrFail("EVIDENCIAS", "UPDATE");

        if ($request->has("Estatus")) {
        return $this->cambioEstatusEvidencia($request,$id);
        }
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function facturasOdt($odt)
    {
        $resultados = CfdisConceptos::selectRaw("
        COALESCE(GROUP_CONCAT(id_factura), 0) AS facturasList
        ")
        ->where("id_referencia", "=", $odt)
        ->value('facturasList');
        return $resultados;
    }
    public function facturasPorCerrar($listFacturas,$odt){

        $resultados = CfdisConceptos::from('cfdis_recibidos_conceptos AS crc')
                    ->leftJoin('evidenciasCT AS eCT', 'eCT.OdT', '=', 'crc.id_referencia')
                    ->join('cfdis_recibidos AS cr', 'cr.id', '=', 'crc.id_factura')
                    ->leftJoin('proveedoresCT AS p', 'p.RFC', '=', 'cr.emisor_rfc')
                    ->selectRaw("DISTINCT crc.id_factura AS IdFactura, eCT.epochCerrarEv / 1000 AS InicioCreditoEpoch,
                                CASE WHEN crc.id_referencia != $odt THEN 0 ELSE 1 END AS actualizar, COALESCE(p.DiasCredito,30) AS DiasCredito")
                    ->whereNull('eCT.epochCerrarEv')
                    ->when($listFacturas, function ($query, $conditionEje) {
                        $facturasId = explode(',', $conditionEje);
                        return $query->whereIn('id_factura', $facturasId);
                    })
                    ->having('actualizar', '=', 1)
                    ->get();
                    // ;
                    // Utils::debuggerQuery($resultados);

    return $resultados;

    }
    public function actualizarFacturas($facturas){

        $facturasArray = $facturas->toArray();
        $idFacturas = array_column($facturasArray, 'IdFactura');

        $actualizacion = OdvctFinanzas::whereIn('Folio', $idFacturas)
            ->update(['FechaInicioCredito' => now()]);
    return $actualizacion;
    }
    public function cambioEstatusEvidencia(Request $request, $id){
        $estatus = $request->input('Estatus');
        $comentario =$request->input('Comentario');

        $actualizacion = ArchivosEvidencias::where('Id', $id)
        ->update([
            'Estatus' => $estatus,
            'Comentario' => $comentario ?: '',
        ]);
        if($estatus==2){
        return $this->rechazarEvidencia($id,$comentario);

        }
        return sendApiSuccess(
            $actualizacion,
            "Evidencia Aceptada Correctamente"
        );
    }
    public function rechazarEvidencia($id,$comentario){
        $resultados=[];
        $archivoEvidencia = ArchivosEvidencias::select('OdT', 'nombreArchivo')
        ->where('Id', $id)
        ->first();
        $odt = $archivoEvidencia->OdT;
        $nombreArchivo = $archivoEvidencia->nombreArchivo;

        $correoProveedor = Proveedores::join('odvCT', 'proveedoresCT.Id', '=', 'odvCT.IdProveedor')
        ->where('odvCT.Idauto', $odt)
        ->value('proveedoresCT.CorreoElectronico');
        $correosDestinatarios = [
            'desarrolladoresct@controlterrestre.com',
            $correoProveedor,
        ];
        $fechaActual = Carbon::now();

        $fechaFormateada = $fechaActual->format('j \d\e F \d\e Y');

        $correosEnviados= Mail::to($correosDestinatarios)
        ->send(new CorreoRechazoEvidencia($nombreArchivo, $odt, $comentario,$fechaFormateada));


        $resultados[] = [
            'id' => $id,
            'comentario' => $comentario,
            'odt' => $odt,
            'nombreArchivo' => $nombreArchivo,
            'correosEnviados' => $correosEnviados

        ];
        return sendApiSuccess(
            $resultados,
            "Evidencia Rechazada Correctamente"
        );
    }
}

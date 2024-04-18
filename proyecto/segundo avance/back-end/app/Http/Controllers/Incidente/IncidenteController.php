<?php

namespace App\Http\Controllers\Incidente;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\Incidente;
use App\Models\Departamento;
use App\Models\Empleado;

class IncidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puestos = Incidente::from('incidente as i')->select(
            'i.id',
            'i.empleado_id',
            'i.departamento_id',
            'i.fecha_incidente',
            'i.interno_imss',
            'i.trabajo_trayecto',
            'i.observaciones',
            'i.created_at',
            'i.updated_at',
            )
            ->selectRaw('d.nombre as nombreDepartamento, e.nombre as nombreEmpleado')
            ->join('departameto as d', 'd.id', '=', 'i.departamento_id')
            ->join('empleado as e', 'e.id', '=', 'i.empleado_id')
            ->get();
        return sendApiSuccess(
            $puestos,
            "Consulta Exitosa"
        );
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
        $request->validate([
            'empleado_id' => ["required"],
            'departamento_id' => ["required"],
            'fecha_incidente' => 'required|date',
            'trabajo_trayecto' => ["required"],

        ]);

        /**
         * !Buscamos si el departamento existe
         */
        $departamento_id =$request->input('departamento_id');
        $fecha_incidente =$request->input('fecha_incidente');
        $observaciones =$request->input('observaciones');
        $trabajo_trayecto =$request->input('trabajo_trayecto');

        $departamento = Departamento::find($departamento_id);

        if (!$departamento) {
            return sendApiFailure(
                (object) [],
                "Departamento no encontrado",
                200
            );
        }
        /**
         * !Buscamos si el Empleado existe
         */
        $empleado_id =$request->input('empleado_id');

        $empleado = Empleado::find($empleado_id);
        if (!$empleado) {
            return sendApiFailure(
                (object) [],
                "Empleado no encontrado",
                200
            );
        }
        $this->sendCorreoWsIncidencia($empleado,$fecha_incidente,$observaciones,$trabajo_trayecto);

        $incidente =Incidente::create($request->all());

        return sendApiSuccess(
            $incidente,
            "Incidente dado de alta Correctamente"
        );
    }

    /**
     * !Envio de informacion de incidente
     */
    public function sendCorreoWsIncidencia($dataEmpleado,$fecha_incidente,$observaciones,$trabajo_trayecto){
        // Extrae la información necesaria
        $correo_empleado = $dataEmpleado->correo;
        $nombre_empleado = $dataEmpleado->nombre;
        $apellido_paterno_empleado = $dataEmpleado->apellido_paterno;
        $telefono_empleado = $dataEmpleado->telefono;

        // Accede a la relación 'datosEmergencia' para obtener los datos de emergencia del empleado
        $datos_emergencia = $dataEmpleado->datosEmergencia;

        // Extrae la información de contacto de emergencia
        $contacto_emergencia = $datos_emergencia->contacto_emergencia;
        $correo_emergencia = $datos_emergencia->correo_emergencia;
        $telefono_emergencia = $datos_emergencia->telefono_emergencia;

        $array = [
            'correo_empleado' => $correo_empleado,
            'nombre_empleado' => $nombre_empleado,
            'apellido_paterno_empleado' => $apellido_paterno_empleado,
            'telefono_empleado' => $telefono_empleado,
            'contacto_emergencia' => $contacto_emergencia,
            'correo_emergencia' => $correo_emergencia,
            'telefono_emergencia' => $telefono_emergencia,
        ];  
            $arrayTelefonosEmergencia = ["$telefono_emergencia"];
            // print_r($arrayTelefonosEmergencia);
            $jsonTelefonos = json_encode($arrayTelefonosEmergencia);
            // print_r($jsonTelefonos);

            $mensajeEmergencia = "Estimado $contacto_emergencia 👤,\\n\\n";
            $mensajeEmergencia .= "Le informamos que ha ocurrido un incidente con el empleado 🦺 *$nombre_empleado $apellido_paterno_empleado*.\\n📅 El día *$fecha_incidente.*\\n";
            $mensajeEmergencia .= "El incidente ocurrió durante: *$trabajo_trayecto*.\\n";
            $mensajeEmergencia .= "Observaciones: *$observaciones*\\n\\n";
            $mensajeEmergencia .= "Atentamente,\\n";
            $mensajeEmergencia .= "Zenith";
            $response=$this->wsMsg($jsonTelefonos, $mensajeEmergencia);

            return $response;        
    }

    public function wsMsg($arrayNumeros, $msj){
        $curl = curl_init();
        // $msj="test";
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://angel-developer.com:3001/lead',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "message":"'.$msj.'" ,
            "phone": ['.$arrayNumeros.']
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $incidente = Incidente::from('incidente as i')->select(
            'i.id',
            'i.empleado_id',
            'i.departamento_id',
            'i.fecha_incidente',
            'i.interno_imss',
            'i.trabajo_trayecto',
            'i.observaciones',
            'i.created_at',
            'i.updated_at',
            )
            ->selectRaw('d.nombre as nombreDepartamento, e.nombre as nombreEmpleado')
            ->join('departameto as d', 'd.id', '=', 'i.departamento_id')
            ->join('empleado as e', 'e.id', '=', 'i.empleado_id')
            ->where("i.id", "=", $id)
            ->first();

            $incidenteExiste = Incidente::find($id);

            if (!$incidenteExiste) {
                return sendApiFailure(
                    (object) [],
                    "Incidente no encontrado",
                    200
                );
            }

        return sendApiSuccess(
            $incidente,
            "Consulta Exitosa"
        );
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
        $request->validate([
            'empleado_id' => ["required"],
            'departamento_id' => ["required"],
            'fecha_incidente' => 'required|date',
            'trabajo_trayecto' => ["required"],

        ]);

        /**
         * !Buscamos si el departamento existe
         */
        $departamento_id =$request->input('departamento_id');

        $departamento = Departamento::find($departamento_id);

        if (!$departamento) {
            return sendApiFailure(
                (object) [],
                "Departamento no encontrado",
                200
            );
        }
        /**
         * !Buscamos si el Empleado existe
         */
        $empleado_id =$request->input('empleado_id');

        $empleado = Empleado::find($empleado_id);

        if (!$empleado) {
            return sendApiFailure(
                (object) [],
                "Empleado no encontrado",
                200
            );
        }
        // Encuentra el registro de incidente existente por su ID
        $incidente = Incidente::findOrFail($id);
        // Actualiza los datos del empleado
        $incidente->update($request->all());

        return sendApiSuccess(
            $incidente,
            "Actualización de registro de incidente Exitosa"
        );

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

    public function incidentesDepartamento($id)
    {
        $puestos = Incidente::from('incidente as i')->select(
            'i.id',
            'i.empleado_id',
            'i.departamento_id',
            'i.fecha_incidente',
            'i.interno_imss',
            'i.trabajo_trayecto',
            'i.observaciones',
            'i.created_at',
            'i.updated_at',
            )
            ->selectRaw('d.nombre as nombreDepartamento, e.nombre as nombreEmpleado')
            ->join('departameto as d', 'd.id', '=', 'i.departamento_id')
            ->join('empleado as e', 'e.id', '=', 'i.empleado_id')
            ->where('i.departamento_id',$id)
            ->get();
        return sendApiSuccess(
            $puestos,
            "Consulta Exitosa"
        );
    }
    public function incidentesEmpleado($id)
    {
        $puestos = Incidente::from('incidente as i')->select(
            'i.id',
            'i.empleado_id',
            'i.departamento_id',
            'i.fecha_incidente',
            'i.interno_imss',
            'i.trabajo_trayecto',
            'i.observaciones',
            'i.created_at',
            'i.updated_at',
            )
            ->selectRaw('d.nombre as nombreDepartamento, e.nombre as nombreEmpleado')
            ->join('departameto as d', 'd.id', '=', 'i.departamento_id')
            ->join('empleado as e', 'e.id', '=', 'i.empleado_id')
            ->where('i.empleado_id',$id)
            ->get();
        return sendApiSuccess(
            $puestos,
            "Consulta Exitosa"
        );
    }

}

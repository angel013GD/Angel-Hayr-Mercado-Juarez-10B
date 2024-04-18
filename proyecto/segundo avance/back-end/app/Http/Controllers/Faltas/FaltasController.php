<?php

namespace App\Http\Controllers\Faltas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Faltas;
use App\Models\Empleado;

class FaltasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Obtener todas las faltas con la información relacionada de empleado y departameto
        $faltas = Faltas::with('empleado', 'departamento')->get();

        return sendApiSuccess(
            $faltas,
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
        // Validar la solicitud
        $request->validate([
            'id_empleado' => 'required|exists:empleado,id',
            'motivo' => 'required|string',
            'fecha' => 'required|date',
        ]);

        // Obtener el id_departamento asociado al id_empleado
        $idEmpleado = $request->input('id_empleado');
        $idDepartamento = Empleado::where('empleado.id', $idEmpleado)->join('puesto', 'empleado.puesto_id', '=', 'puesto.id')->value('puesto.departamento_id');
        $dataEmpleado = Empleado::where('empleado.id', $idEmpleado)->first();

        $nombreEmpleado= $dataEmpleado->nombre;
        $telefonoEmpleado= $dataEmpleado->telefono;
        $arrayTelefonosEmergencia = ["$telefonoEmpleado"];
        // print_r($arrayTelefonosEmergencia);
        $jsonTelefonos = json_encode($arrayTelefonosEmergencia);
        // print_r($jsonTelefonos);
        $fechaFalta=$request->input('fecha');
        $msjFalta = "Estimado $nombreEmpleado 👤 espero se encuentre muy bien,\\n\\n";
        $msjFalta .= "Le informamos que tiene registrada una falta 🚫.\\n📅 El día *$fechaFalta.*\\n";
        $msjFalta .= "Favor de comunicarse con su jefe de departamento correspondiente 👨🏻‍💼 para aclarar el motivo por la cual no pudo asistir a laborar.\\n";
        $msjFalta .= "Sin mas por el momento quedamos a sus ordenes 👋.\\n";
        $msjFalta .= "Atentamente,\\n";
        $msjFalta .= "Zenith 🏢";
        $response=$this->wsMsg($jsonTelefonos, $msjFalta);

        // Crear la falta
        $falta = Faltas::create([
            'id_empleado' => $idEmpleado,
            'id_departamento' => $idDepartamento,
            'motivo' => $request->input('motivo'),
            'fecha' => $request->input('fecha'),
        ]);
        return sendApiSuccess(
            $falta,
            "Falta dado de alta Correctamente"
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Obtener la falta con la información relacionada de empleado y departamento
        $falta = Faltas::with('empleado', 'departamento')->find($id);
        if(!$falta){
            return sendApiFailure(
                (object) [],
                "Registro de falta no existe",
                200
            );
        }
        return sendApiSuccess(
            $falta,
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
        //
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
    public function faltasEmpleado($idEmpleado)
    {
        // Obtener fechas, nombre del empleado, nombre del departamento y cantidad de faltas por empleado
        $faltasPorEmpleado = Faltas::where('id_empleado', $idEmpleado)
        ->join('empleado', 'faltas.id_empleado', '=', 'empleado.id')
        ->join('departameto', 'faltas.id_departamento', '=', 'departameto.id')
        ->selectRaw('faltas.fecha, empleado.nombre as nombre_empleado, departameto.nombre as nombre_departamento')
        ->groupBy('faltas.fecha', 'empleado.nombre', 'departameto.nombre')
        ->get();

        // Crear un arreglo con las fechas, nombre del empleado, nombre del departamento y la cantidad de faltas
        $resultados = [];
        foreach ($faltasPorEmpleado as $falta) {
        $resultados[] = [
            'fecha' => $falta->fecha,
            'nombre_empleado' => $falta->nombre_empleado,
            'nombre_departamento' => $falta->nombre_departamento,
        ];
        }

        return sendApiSuccess(
            $resultados,
            "Consulta Exitosa"
        );
    }
    public function faltasDepartamento($id)
    {
        // Obtener fechas, nombre del empleado, nombre del departamento y cantidad de faltas por empleado
        $faltasPorEmpleado = Faltas::where('departameto.id', $id)
        ->join('empleado', 'faltas.id_empleado', '=', 'empleado.id')
        ->join('departameto', 'faltas.id_departamento', '=', 'departameto.id')
        ->selectRaw('faltas.fecha, empleado.nombre as nombre_empleado, departameto.nombre as nombre_departamento')
        ->groupBy('faltas.fecha', 'empleado.nombre', 'departameto.nombre')
        ->get();

        // Crear un arreglo con las fechas, nombre del empleado, nombre del departamento y la cantidad de faltas
        $resultados = [];
        foreach ($faltasPorEmpleado as $falta) {
        $resultados[] = [
            'fecha' => $falta->fecha,
            'nombre_empleado' => $falta->nombre_empleado,
            'nombre_departamento' => $falta->nombre_departamento,
        ];
        }

        return sendApiSuccess(
            $resultados,
            "Consulta Exitosa"
        );
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
}

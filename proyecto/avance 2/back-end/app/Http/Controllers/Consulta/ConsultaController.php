<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Empleado;
use Carbon\Carbon;
use App\Models\Motivo;

class ConsultaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $consultas = Consulta::all();
        $consultas =  Consulta::from('consulta as c')
        ->select(
            'c.id as id',
            'e.id as empleado',
            'c.motivo as motivo',
            'c.responsable as responsable',
            'c.observaciones as observaciones',
            'c.created_at as created_at',
            'c.updated_at as updated_at',
            'e.nombre as nombreEmpleado',
            'e2.nombre as nombreResponsable',
            'p.nombre as puestoEmpleado',
            'd.nombre as departamentoNombre',
            'm.nombre as nombreMotivo',
        )
        ->join('empleado as e', 'c.empleado', '=', 'e.id')
        ->join('motivo as m', 'c.motivo', '=', 'm.id')
        ->join('empleado as e2', 'c.responsable', '=', 'e2.id')
        ->join('puesto as p', 'e.puesto_id', '=', 'p.id')
        ->join('departameto as d', 'p.departamento_id', '=', 'd.id')
        ->get();
        return sendApiSuccess(
            $consultas,
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
            'empleado' => ["required"],
            'motivo' => ["required"],
            'responsable' => ["required"],
            'observaciones' => ["nullable"]
        ]);


        $consulta = Consulta::create($request->all());
        
        $idEmpleado=$request->input('empleado');
        $motivo=$request->input('motivo');
        $observaciones=$request->input('observaciones');
        $dataEmpleado = Empleado::where('empleado.id', $idEmpleado)->first();
        $nombreMotivo = Motivo::where('id', $motivo)->value('nombre');

        $nombreEmpleado= $dataEmpleado->nombre;
        $telefonoEmpleado= $dataEmpleado->telefono;
        $arrayTelefonosEmergencia = ["$telefonoEmpleado"];
        // print_r($arrayTelefonosEmergencia);
        $jsonTelefonos = json_encode($arrayTelefonosEmergencia);
        // print_r($jsonTelefonos);
        $fechaConsulta=$consulta->created_at;
        $fechaFormateada = Carbon::parse($fechaConsulta)->format('Y-m-d');
        $msjConsulta = "Estimado $nombreEmpleado 👤 espero se encuentre muy bien,\\n\\n";
        $msjConsulta .= "Le informamos sobre la consulta 🩺 que tuvo en la empresa 🏢.\\n";
        $msjConsulta .= "📅 El día *$fechaFormateada.*\\n";
        $msjConsulta .= "🗒️ Motivo de consulta: *$nombreMotivo* .\\n";
        $msjConsulta .= "👀 Observaciones de consulta: *$observaciones* .\\n";
        $msjConsulta .= "Favor de seguir las indicaciones dadas por el médico y en caso de seguir con molestias acudir con el médico 🚑 de inmediato.\\n";
        $msjConsulta .= "Sin mas por el momento quedamos a sus ordenes 👋.\\n";
        $msjConsulta .= "Atentamente,\\n";
        $msjConsulta .= "Zenith 🏢";
        $response=$this->wsMsg($jsonTelefonos, $msjConsulta);

        return sendApiSuccess(
            $consulta,
            "Consulta creada Correctamente"
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
        $consulta = Consulta::find($id);
        return sendApiSuccess(
            $consulta,
            "Consulta de consulta correcta xd"
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
            'empleado' => ["required"],
            'motivo' => ["required"],
            'responsable' => ["required"],
            'observaciones' => ["nullable"]
        ]);

        $consulta= Consulta::find($id)->update($request->all());
        return sendApiSuccess(
            $consulta,
            "Actualizacion de consulta correcta"
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


public function consultaDepartamento($id)
{
    $result =  Consulta::from('consulta as c')
        ->select(
            'e.nombre as nombreEmpleado',
            'c.observaciones as observacionesConsulta',
            'c.created_at as fechaConsulta',
            'e2.nombre as nombreResponsable',
            'p.nombre as puestoEmpleado',
            'd.nombre as departamentoNombre'
        )
        ->join('empleado as e', 'c.empleado', '=', 'e.id')
        ->join('motivo as m', 'c.motivo', '=', 'm.id')
        ->join('empleado as e2', 'c.responsable', '=', 'e2.id')
        ->join('puesto as p', 'e.puesto_id', '=', 'p.id')
        ->join('departameto as d', 'p.departamento_id', '=', 'd.id')
        ->where('p.departamento_id', $id)
        ->get();

    return sendApiSuccess(
        $result,
        "Consulta Exitosa"
    );
}
public function consultaEmpleado($id)
{
    $result =  Consulta::from('consulta as c')
        ->select(
            'e.nombre as nombreEmpleado',
            'c.observaciones as observacionesConsulta',
            'c.created_at as fechaConsulta',
            'e2.nombre as nombreResponsable',
            'p.nombre as puestoEmpleado',
            'd.nombre as departamentoNombre'
        )
        ->join('empleado as e', 'c.empleado', '=', 'e.id')
        ->join('motivo as m', 'c.motivo', '=', 'm.id')
        ->join('empleado as e2', 'c.responsable', '=', 'e2.id')
        ->join('puesto as p', 'e.puesto_id', '=', 'p.id')
        ->join('departameto as d', 'p.departamento_id', '=', 'd.id')
        ->where('c.empleado', $id)
        ->get();

    return sendApiSuccess(
        $result,
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

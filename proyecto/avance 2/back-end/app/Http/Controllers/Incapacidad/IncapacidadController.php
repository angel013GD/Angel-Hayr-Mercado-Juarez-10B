<?php

namespace App\Http\Controllers\Incapacidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Incapacidad;

class IncapacidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $incapacidades = Incapacidad::all();
        $incapacidades = Incapacidad::from('incapacidad as i')->select(
            'i.id as id',
            'e.id as empleado',
            'i.motivo as motivo',
            'i.tipo_incapacidad as tipo_incapacidad',
            'i.dias',
            'i.fecha_inicio',
            'i.fecha_fin',
            'i.observaciones as observaciones',
            'i.estado',
            'i.created_at as created_at',
            'i.updated_at as updated_at',
            'e.nombre as nombreEmpleado',
            'm.nombre as nombreMotivo',
            'ti.nombre as tipoIncapacidad',
            'p.nombre as puestoEmpleado',
            'd.nombre as departamentoNombre'
        )
        ->join('empleado as e', 'i.empleado', '=', 'e.id')
        ->join('motivo as m', 'i.motivo', '=', 'm.id')
        ->join('tipodeincapacidad as ti', 'i.tipo_incapacidad', '=', 'ti.id')
        ->join('puesto as p', 'e.puesto_id', '=', 'p.id')
        ->join('departameto as d', 'p.departamento_id', '=', 'd.id')
        ->get();
        return sendApiSuccess(
            $incapacidades,
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
            'tipo_incapacidad' => ["required"],
            'dias' => ["required"],
            'fecha_inicio' => ["required"],
            'fecha_fin' => ["required"],
            'observaciones' => ["nullable"],
            'estado' => ["required"]
        ]);


        $incapacidad = Incapacidad::create($request->all());

        return sendApiSuccess(
            $incapacidad,
            "Incapacidad creado Correctamente"
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
        $incapacidad = Incapacidad::find($id);
        return sendApiSuccess(
            $incapacidad,
            "Consulta de incapacidad correcta"
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
            'tipo_incapacidad' => ["required"],
            'dias' => ["required"],
            'fecha_inicio' => ["required"],
            'fecha_fin' => ["required"],
            'observaciones' => ["nullable"],
            'estado' => ["required"]
        ]);

        $incapacidad= Incapacidad::find($id)->update($request->all());
        return sendApiSuccess(
            $incapacidad,
            "Actualizacion de incapacidad correcta"
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
    public function incapacidadDepartamento($id)
    {
        $puestos = Incapacidad::from('incapacidad as i')->select(
            'e.nombre as nombreEmpleado',
            'm.nombre as nombreMotivo',
            'ti.nombre as tipoIncapacidad',
            'i.dias',
            'i.fecha_inicio',
            'i.fecha_fin',
            'i.observaciones as observacionesIncapacidad',
            'p.nombre as puestoEmpleado',
            'd.nombre as departamentoNombre'
        )
        ->join('empleado as e', 'i.empleado', '=', 'e.id')
        ->join('motivo as m', 'i.motivo', '=', 'm.id')
        ->join('tipodeincapacidad as ti', 'i.tipo_incapacidad', '=', 'ti.id')
        ->join('puesto as p', 'e.puesto_id', '=', 'p.id')
        ->join('departameto as d', 'p.departamento_id', '=', 'd.id')
        ->where('p.departamento_id', $id)
        ->get();
        return sendApiSuccess(
            $puestos,
            "Consulta Exitosa"
        );
    }
    public function incapacidadEmpleado($id)
    {
        $puestos = Incapacidad::from('incapacidad as i')->select(
            'e.nombre as nombreEmpleado',
            'm.nombre as nombreMotivo',
            'ti.nombre as tipoIncapacidad',
            'i.dias',
            'i.fecha_inicio',
            'i.fecha_fin',
            'i.observaciones as observacionesIncapacidad',
            'p.nombre as puestoEmpleado',
            'd.nombre as departamentoNombre'
        )
        ->join('empleado as e', 'i.empleado', '=', 'e.id')
        ->join('motivo as m', 'i.motivo', '=', 'm.id')
        ->join('tipodeincapacidad as ti', 'i.tipo_incapacidad', '=', 'ti.id')
        ->join('puesto as p', 'e.puesto_id', '=', 'p.id')
        ->join('departameto as d', 'p.departamento_id', '=', 'd.id')
        ->where('i.empleado', $id)
        ->get();
        return sendApiSuccess(
            $puestos,
            "Consulta Exitosa"
        );
    }
}

<?php

namespace App\Http\Controllers\Puesto;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Departamento;
use App\Models\Puesto;

class PuestoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $puestos = Puesto::from('puesto as p')->select(
            'p.id',
            'p.nombre',
            'p.departamento_id',
            'p.created_at',
            'p.updated_at'
            )
            ->selectRaw('d.nombre as nombreDepartamento')
            ->join('departameto as d', 'd.id', '=', 'p.departamento_id')
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
            'nombre' => ["required"],
            'departamento_id' => ["required"],
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

        $puesto =Puesto::create($request->all());

        return sendApiSuccess(
            $puesto,
            "Puesto creado Correctamente"
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
        $puestoExiste = Puesto::find($id);

        if (!$puestoExiste) {
            return sendApiFailure(
                (object) [],
                "Puesto no encontrado",
                200
            );
        }
        // $puesto = Puesto::with('departamento')->find($id);
        $puesto = Puesto::from('puesto as p')->select(
            'p.id',
            'p.nombre',
            'p.departamento_id',
            'p.created_at',
            'p.updated_at'
            )
            ->selectRaw('d.nombre as nombreDepartamento')
            ->join('departameto as d', 'd.id', '=', 'p.departamento_id')
            ->where("p.id", "=", $id)
            ->first();

        return sendApiSuccess(
            $puesto,
            "Consulta de puesto correcta"
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
        // print_r($request);
        $request->validate([
            'nombre' => ["required"],
            'departamento_id' => ["required"],
        ]);
        $nombre = $request->input('nombre');
        $departamento_id =$request->input('departamento_id');
        /**
         * !Buscamos si el departamento existe
         */
        $departamento = Departamento::find($departamento_id);

        if (!$departamento) {
            return sendApiFailure(
                (object) [],
                "Departamento no encontrado",
                200
            );
        }
        $puesto = Puesto::where('id', $id)
        ->update([
            'nombre' => $nombre,
            'departamento_id' => $departamento_id,
        ]);

        return sendApiSuccess(
            $puesto,
            "Actualizacion de puesto correcta"
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
}

<?php

namespace App\Http\Controllers\Motivo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Motivo;

class MotivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $motivos = Motivo::all();
        return sendApiSuccess(
            $motivos,
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
            'nivel_gravedad' => ["required"]
        ]);


        $motivo = Motivo::create($request->all());

        return sendApiSuccess(
            $motivo,
            "Motivo creado Correctamente"
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
        $motivo = Motivo::find($id);
        return sendApiSuccess(
            $motivo,
            "Consulta de motivo correcta"
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
            'nombre' => ["required"],
            'nivel_gravedad' => ["required"]
        ]);

        $motivo= Motivo::find($id)->update($request->all());
        return sendApiSuccess(
            $motivo,
            "Actualizacion de motivo correcta"
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

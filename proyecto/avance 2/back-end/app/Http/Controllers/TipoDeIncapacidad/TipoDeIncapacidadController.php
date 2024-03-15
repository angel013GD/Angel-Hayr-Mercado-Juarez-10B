<?php

namespace App\Http\Controllers\TipoDeIncapacidad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TipoDeIncapacidad;

class TipoDeIncapacidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tiposdeincapacidad = TipoDeIncapacidad::all();
        return sendApiSuccess(
            $tiposdeincapacidad,
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
        ]);


        $tipodeincapacidad = TipoDeIncapacidad::create($request->all());

        return sendApiSuccess(
            $tipodeincapacidad,
            "Tipo de Incapacidad creado Correctamente"
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
        $tipodeincapacidad = TipoDeIncapacidad::find($id);
        return sendApiSuccess(
            $tipodeincapacidad,
            "Consulta de tipo de incapacidad correcta"
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
        ]);

        $tipodeincapacidad= TipoDeIncapacidad::find($id)->update($request->all());
        return sendApiSuccess(
            $tipodeincapacidad,
            "Actualizacion de tipo de incapacidad correcta"
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

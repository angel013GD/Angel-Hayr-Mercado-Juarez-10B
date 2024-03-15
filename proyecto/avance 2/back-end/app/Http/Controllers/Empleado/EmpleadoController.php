<?php

namespace App\Http\Controllers\Empleado;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Empleado;
use App\Models\Direccion;
use App\Models\DatosSeguro;
use App\Models\DatosEmergencia;
use App\Models\Departamento;
use App\Models\Puesto;
use App\Models\User;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          // Obtén todos los empleados con sus relaciones
        $empleados = Empleado::with(['direccion', 'datosSeguro', 'datosEmergencia'])->get();

        foreach ($empleados as $empleado) {
            $idPuesto = $empleado->puesto_id;
            $datosPuesto = $this->puestoEmpleado($idPuesto);
    
            $empleado->nombreDepartamento = $datosPuesto->nombreDepartamento;
            $empleado->nombrePuesto = $datosPuesto->nombrePuesto;
        }

        return sendApiSuccess(
            $empleados,
            "Listado de Empleados"
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
            'empleado.nombre' => 'required',
            'empleado.apellido_paterno' => 'required',
            'empleado.apellido_materno' => 'required',
            'empleado.fecha_nacimiento' => 'required|date',
            'empleado.puesto_id' => 'required|exists:puesto,id',
            'empleado.telefono' => 'required',
            'empleado.correo' => 'required|email|max:255|unique:empleado,correo',
            // 'direccion.calle' => 'required',
        ]);
    
        // Extrae los datos del request
        $empleadoData = $request->input('empleado');
        $direccionData = $request->input('direccion');
        $datosSeguroData = $request->input('datos_seguro');
        $datosEmergenciaData = $request->input('datos_emergencia');

        // Crea el empleado en la base de datos
        $empleado = Empleado::create($empleadoData);
        // Asocia la direccion con el empleado
        $empleado->direccion()->create($direccionData);
        // Asocia los datos del seguro con el empleado
        $empleado->datosSeguro()->create($datosSeguroData);
        // Asocia los datos de emergencia con el empleado
        $empleado->datosEmergencia()->create($datosEmergenciaData);
                
        return sendApiSuccess(
            $empleado,
            "Alta de empleado Exitosa"
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
           // Obtén un empleado específico con sus relaciones
        $empleado = Empleado::with(['direccion', 'datosSeguro', 'datosEmergencia'])->find($id);

        // print_r($nombreDepartamento);
        if (!$empleado) {
            return sendApiFailure(
                (object) [],
                "No se encontro Empleado",
                200
            );
        }
        $idPuesto=$empleado['puesto_id'];
        $datosPuesto=$this->puestoEmpleado($idPuesto);
        $nombreDepartamento = $datosPuesto->nombreDepartamento;
        $nombrePuesto = $datosPuesto->nombrePuesto;
        $empleado->nombreDepartamento = $datosPuesto->nombreDepartamento;
        $empleado->nombrePuesto = $datosPuesto->nombrePuesto;

        return sendApiSuccess(
            $empleado,
            "Detalles del Empleado"
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
        $empleado = Empleado::find($id);

        if (!$empleado) {
            return sendApiFailure(
                (object) [],
                "No se encontro Empleado",
                200
            );
        }
        $request->validate([
            'empleado.nombre' => 'required',
            'empleado.apellido_paterno' => 'required',
            'empleado.apellido_materno' => 'required',
            'empleado.fecha_nacimiento' => 'required|date',
            'empleado.puesto_id' => 'required|exists:puesto,id',
            'empleado.telefono' => 'required',
            'empleado.correo' => 'required|email|max:255|unique:empleado,correo,' . $id,
        ]);
    
        // Extrae los datos del request
        $empleadoData = $request->input('empleado');
        $direccionData = $request->input('direccion');
        $datosSeguroData = $request->input('datos_seguro');
        $datosEmergenciaData = $request->input('datos_emergencia');
    
        // Encuentra el empleado existente por su ID
        $empleado = Empleado::findOrFail($id);
    
        // Actualiza los datos del empleado
        $empleado->update($empleadoData);
    
        // Actualiza la dirección del empleado
        $empleado->direccion()->update($direccionData);
    
        // Actualiza los datos del seguro del empleado
        $empleado->datosSeguro()->update($datosSeguroData);
    
        // Actualiza los datos de emergencia del empleado
        $empleado->datosEmergencia()->update($datosEmergenciaData);
    
        return sendApiSuccess(
            $empleado,
            "Actualización de empleado Exitosa"
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
    public function puestoEmpleado ($id){
        $puesto = Puesto::from('puesto as p')->selectRaw(
            'd.nombre as nombreDepartamento, 
             p.nombre as nombrePuesto')
            ->join('departameto as d', 'd.id', '=', 'p.departamento_id')
            ->where("p.id", "=", $id)
            ->first();
        // print_r($puesto);


        return $puesto;
    }

    public function usuarioEmpleado($id)
    {
         // Buscar usuario por su ID
        $usuario = User::find($id);
        if(!$usuario){
            return sendApiFailure(
                (object) [],
                "El usuario no esta relacionado con un registro de empleado",
                200
            );
        }
        $empleadoId = $usuario->empleado_id;
        // Obtén un empleado específico con sus relaciones
        $empleado = Empleado::with(['direccion', 'datosSeguro', 'datosEmergencia'])->find($empleadoId);

        // print_r($nombreDepartamento);
        if (!$empleado) {
            return sendApiFailure(
                (object) [],
                "No se encontro Empleado",
                200
            );
        }
        $idPuesto=$empleado['puesto_id'];
        $datosPuesto=$this->puestoEmpleado($idPuesto);
        $nombreDepartamento = $datosPuesto->nombreDepartamento;
        $nombrePuesto = $datosPuesto->nombrePuesto;
        $empleado->nombreDepartamento = $datosPuesto->nombreDepartamento;
        $empleado->nombrePuesto = $datosPuesto->nombrePuesto;

        return sendApiSuccess(
            $empleado,
            "Detalles del Empleado"
        );
    }
}

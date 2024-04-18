<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * !Evidencias
 */
use App\Http\Controllers\Evidencias\EvidenciasController;

/**
 * !Usuario
 */
use App\Http\Controllers\Usuario\SignUpController;
use App\Http\Controllers\Usuario\LoginController;

/**
 * !Departamento
 */
use App\Http\Controllers\Departamento\DepartamentoController;

/**
 * !Puesto
 */
use App\Http\Controllers\Puesto\PuestoController;
/**
 * !Empleado
 */
use App\Http\Controllers\Empleado\EmpleadoController;
/**
 * !Incidente
 */
use App\Http\Controllers\Incidente\IncidenteController;


/**
 * !TipoDeIncapacidad
 */
use App\Http\Controllers\TipoDeIncapacidad\TipoDeIncapacidadController;

/**
 * !Motivo
 */
use App\Http\Controllers\Motivo\MotivoController;

/**
 * !Consulta
 */
use App\Http\Controllers\Consulta\ConsultaController;

/**
 * !Incapacidad
 */
use App\Http\Controllers\Incapacidad\IncapacidadController;
/**
 * !Faltas
 */
use App\Http\Controllers\Faltas\FaltasController;

/*ConfigurationController Dashboard
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(["prefix" => "v1"], function () {
    Route::middleware(["jwt.authCustom"])->group(function () {
        Route::get("/health/auth", function (Request $request) {
            $user = $request->user();
            return sendApiSuccess(
                ["status" => "ok"],
                "Server online, You are authenticated"
            );
        });
    /**
     * Evidencias
     */
    Route::resource("evidenciasOdt", EvidenciasController::class);
    
    /**
     * !Departamento
     */
    Route::resource("departamento", DepartamentoController::class);
    /**
     * !Puesto
     */
    Route::resource("puesto", PuestoController::class);
    /**
     * !Empleado
     */
    Route::resource("empleado", EmpleadoController::class);
    Route::get("usuario/empleado/{id}", [EmpleadoController::class,'usuarioEmpleado']);

    /**
     * !Incidente
     */
    Route::resource("incidente", IncidenteController::class);
    Route::get("incidente/departamento/{id}", [IncidenteController::class,'incidentesDepartamento']);
    Route::get("incidente/empleado/{id}", [IncidenteController::class,'incidentesEmpleado']);


    /**
     * !TipoDeIncapacidad
     */
    Route::resource("tipodeincapacidad", TipoDeIncapacidadController::class);

    /**
     * !Motivo
     */
    Route::resource("motivo", MotivoController::class);

    /**
     * !Consulta
     */
    Route::resource("consulta", ConsultaController::class);
    Route::get("consulta/departamento/{id}", [ConsultaController::class,'consultaDepartamento']);
    Route::get("consulta/empleado/{id}", [ConsultaController::class,'consultaEmpleado']);


    /**
     * !Incapacidad
     */
    Route::resource("incapacidad", IncapacidadController::class);
    Route::get("incapacidad/departamento/{id}", [IncapacidadController::class,'incapacidadDepartamento']);
    Route::get("incapacidad/empleado/{id}", [IncapacidadController::class,'incapacidadEmpleado']);
    
    /**
     * !Faltas
     */
    Route::resource("faltas", FaltasController::class);
    Route::get("faltas/empleado/{id}", [FaltasController::class,'faltasEmpleado']);
    Route::get("faltas/departamento/{id}", [FaltasController::class,'faltasDepartamento']);






    });
    // Route::resource("evidenciasOdt", EvidenciasController::class);

    Route::post("auth/sign-up", SignUpController::class);
    Route::post("auth/login", LoginController::class);
    Route::get("testing", function (Request $request) {
        return [
            "ok" => "si funciono",
        ];
    });
});


<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\RolesUsuarios;
use Illuminate\Http\JsonResponse;
use App\Models\Empleado;


class SignUpController extends Controller
{
    public function __invoke(Request $request)
    {

        $request->validate([
            // no funciona si la request no tiene header accept: application/json
            "correo" => ["required", "string", "email"], // check regex js ?
            "nombre_usuario" => ["required", "string", "min:4", "max:15"],
            "contrasenia" => ["required", "string", "min:4"],
            "nombre" => ["required", "string"],
            "roles" => ["nullable", "array"],
        ]);
        // Validar si el empleado_id no está vacío
        if (!empty($request->empleado_id)) {
            // Validar si el empleado existe
            $empleadoExistente = Empleado::find($request->empleado_id);

            if (!$empleadoExistente) {
                return sendApiFailure(
                    (object) [],
                    "El empleado que intenta relacionar no esta registrado",
                    200
                );
            }
        }
        // return "32";
        $usuario = User::create([
            "correo" => $request->correo,
            "nombre_usuario" => $request->nombre_usuario,
            "nombre" => $request->get('nombre'),
            "contrasenia" => Hash::make($request->contrasenia),
            "empleado_id" => $request->empleado_id,

        ]);

         return sendApiSuccess($usuario, "Usuario registrado exitosamente");
    }
}

<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

use JWTAuth;

// usar cookies
// TODO: automatizar respuestas

class LoginController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $params = $request->only(["nombre_usuario", "contrasenia"]);
        $credentials = $request->validate([
            "contrasenia" => ["required"],
            "nombre_usuario" => ["required"],
        ]);

        $credentials = [
            "password" => $params["contrasenia"],
            "nombre_usuario" => $params["nombre_usuario"],
        ];
        if (filter_var($params['nombre_usuario'], FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                "password" => $params["contrasenia"],
                "correo" => $params["nombre_usuario"],
            ];
        }

        $found = $found = User::where(
            "nombre_usuario",
            "=",
            $params["nombre_usuario"]
        )
        ->orWhere("correo", $params["nombre_usuario"])
            // ->with("roles")
            ->first();
        // print_r($found);
        if (!$found) {
            error_log("was not found");
            return sendApiFailure((object) [], "Usuario no reconocido");
        }

        $token = JWTAuth::attempt($credentials);
        // error_log($token);
        if ($token) {
            $found["token"] = $token;
            // $found["permisos"] = $found->getPermisos();
            // $found["roles_menores"] = $found->getRolesMenores();

            $result = sendApiSuccess($found, "Identificado exitosamente");
            // $found->tryLogToBitacora($result, "login", "LOGIN");

            return $result;
        }

        return sendApiFailure((object) [], "Contraseña incorrecta");

        /*

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return sendApiSuccess(["userData" => $request->user()], "Sesión iniciada exitosamente");
        } else {
            return sendApiFailure((object)[], "Fallo al iniciar sesión (email o contraseña incorrectos)", 401);
        }¨
        */
    }
}

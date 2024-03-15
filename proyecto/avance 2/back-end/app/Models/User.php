<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Models\Rol;
use App\Models\RolesUsuarios;
use App\Models\Permiso;
use App\Utils\Exceptions\UnauthorizedApiException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * Agregado para cambiar el nombre de la tabla
     */
    protected $table = 'usuarios';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected $fillable = [
    //     'name', 'email', 'password',
    // ];
    protected $guarded = ["id"];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getAuthPassword()
    {
        return $this->contrasenia;
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    /**
     * Inicia apartado de roles y permisos
     */
    public function roles()
    {
        return $this->hasManyThrough(
            Rol::class,
            RolesUsuarios::class,
            "usuario_id",
            "id",
            "id",
            "rol_id"
        );
    }
    public function getPermisos()
    {
        $roles = RolesUsuarios::where("usuario_id", $this->id)
            ->get("rol_id")
            ->map(function ($rol) {
                return $rol->rol_id;
            });

        $permisos = Permiso::whereHas("permisos_roles", function ($query) use (
            $roles
        ) {
            $query->whereIn("rol_id", $roles);
        })->get();

        return $permisos;
    }
        /**
     * Undocumented function
     *
     * @param string $modulo
     * @param string $permiso
     * @return void
     */
    public function allow(string $modulo, string $permiso)
    {
        $modulo = strtoupper($modulo);
        $permiso = strtoupper($permiso);

        $allowed = $this->with([
            "roles.permisos" => function ($query) use ($modulo, $permiso) {
                $query->where("nombre", $permiso);
                $query->where("modulo", $modulo);
            },
        ])
            ->where("id", $this->id)
            ->get();

        $permisos = $allowed
            ->pluck("roles")
            ->flatten()
            ->pluck("permisos")
            ->flatten();
        $denies = $permisos->flatMap(function ($permisoObj) {
            if (
                strpos(
                    strtolower($permisoObj["tipo"]),
                    strtolower("FORBID")
                ) !== false
            ) {
                return [$permisoObj];
            }
            return [];
        });

        if (count($denies) > 0) {
            return false;
        }
        return count($permisos) > 0;
    }
       /**
     * Undocumented function
     *
     * @param string $modulo
     * @param string $permiso
     * @return void
     */
    public function allowOrFail(string $modulo, string $permiso)
    {
        if ($this->allow($modulo, $permiso)) {
            return true;
        }
        throw new UnauthorizedApiException();
        // return $this->autenticar($modulo, $permiso) ? true : (throw new UnauthorizedException());
    }

    public function hasRole(string $rolName)
    {
        $userId = $this->id;

        $rolId = Rol::where([["nombre", $rolName]])->first()["id"];

        $found = RolesUsuarios::where([
            ["usuario_id", $userId],
            ["rol_id", $rolId],
        ])->get();

        return count($found) > 0;
    }

}

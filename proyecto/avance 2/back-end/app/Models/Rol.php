<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Permiso;
use App\Models\PermisosRoles;
use App\Models\RolesUsuarios;

class Rol extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "roles";

    protected $guarded = ["id"];

    protected $hidden = ["created_at", "updated_at"];

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Rol $rol) {
            foreach ($rol->roles_usuarios as $rolUsuario) {
                // $rolUsuario->forceDelete();
                $rolUsuario->delete();
            }

            foreach ($rol->permisos_roles as $permisoRol) {
                $permisoRol->delete();
            }
        });
    }

    public function permisos()
    {
        return $this->hasManyThrough(
            Permiso::class,
            PermisosRoles::class,
            "rol_id",
            "id",
            "id",
            "permiso_id"
        );
    }

    public function permisos_roles()
    {
        return $this->hasMany(PermisosRoles::class, "rol_id", "id");
    }

    public function roles_usuarios()
    {
        return $this->hasMany(RolesUsuarios::class, "rol_id");
    }


}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\PermisosRoles;
use App\Models\Rol;
use App\Models\User;
use App\Models\RolesUsuarios;

class Permiso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "permisos";

    protected $guarded = ["id"];

    protected $hidden = ["created_at", "updated_at", "deleted_at"];

    public static function boot()
    {
        parent::boot();

        self::deleting(function (Permiso $permiso) {
            foreach ($permiso->permisos_roles as $permisoRol) {
                $permisoRol->forceDelete();
            }
        });
    }

    public function permisos_roles()
    {
        return $this->hasMany(PermisosRoles::class, "permiso_id");
    }

    public function usuarios()
    {
        return $this->hasManyThrough(
            User::class,
            RolesUsuarios::class,
            "usuario_id",
            "id",
            "id",
            "rol_id"
        );
    }

    public function roles()
    {
        return $this->hasManyThrough(
            Rol::class,
            PermisosRoles::class,
            "permiso_id",
            "id",
            "id",
            "rol_id"
        );
    }
}

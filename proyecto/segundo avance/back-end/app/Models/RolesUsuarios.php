<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\Rol;

class RolesUsuarios extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = "roles_usuarios";

    protected $guarded = ["id"];

    public function usuarios() {
        return $this->hasMany(User::class, "id");
    }

    public function rol() {
        return $this->hasOne(Rol::class, 'id', 'rol_id');
    }

    public function usuario() {
        return $this->hasOne(User::class, 'id', 'usuario_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosEmergencia extends Model
{
    use HasFactory;

    protected $table = 'datos_emergencia';

    protected $guarded = ["id"];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}

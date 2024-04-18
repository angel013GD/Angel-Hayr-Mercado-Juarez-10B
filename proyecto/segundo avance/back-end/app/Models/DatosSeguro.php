<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosSeguro extends Model
{
    use HasFactory;
    protected $table = 'datos_seguro';

    protected $guarded = ["id"];
    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }
}

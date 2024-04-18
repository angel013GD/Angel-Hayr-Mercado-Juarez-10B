<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';

    protected $guarded = ["id"];

      /**
     * Obtén la dirección asociada al empleado.
     */
    public function direccion()
    {
        return $this->hasOne(Direccion::class);
    }
    public function datosSeguro()
    {
        return $this->hasOne(DatosSeguro::class);
    }

    public function datosEmergencia()
    {
        return $this->hasOne(DatosEmergencia::class);
    }
}

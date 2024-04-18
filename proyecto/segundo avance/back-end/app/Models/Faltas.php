<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faltas extends Model
{
    use HasFactory;
    protected $table = 'faltas';

    protected $guarded = ["id"];

      // Relación con la tabla 'empleados'
      public function empleado()
      {
          return $this->belongsTo(Empleado::class, 'id_empleado');
      }
  
      // Relación con la tabla 'departamentos'
      public function departamento()
      {
          return $this->belongsTo(Departamento::class, 'id_departamento');
      }
}

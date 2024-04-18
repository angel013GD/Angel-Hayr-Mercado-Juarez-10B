<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faltas;
use App\Models\Empleado;

class FaltasSeeder extends Seeder
{
    public function run()
    {
        // Obtener varios empleados para generar faltas
        $empleados = Empleado::all();

        foreach ($empleados as $empleado) {
            // Obtener el id_departamento del empleado actual
            $idDepartamento = $this->obtenerIdDepartamento($empleado->id);

            if ($idDepartamento) {
                // Generar varias faltas para el empleado
                for ($i = 0; $i < rand(1, 5); $i++) {
                    Faltas::create([
                        'id_empleado' => $empleado->id,
                        'id_departamento' => $idDepartamento,
                        'motivo' => $this->generarMotivo(),
                        'fecha' => now()->subDays(rand(1, 30)), // Fecha aleatoria en los últimos 30 días
                    ]);
                }
            }
        }
    }

    // Método para obtener el id_departamento sin relación en el modelo Empleado
    private function obtenerIdDepartamento($idEmpleado)
    {
        return Empleado::join('puesto', 'empleado.puesto_id', '=', 'puesto.id')
            ->where('empleado.id', $idEmpleado)
            ->value('puesto.departamento_id');
    }

    // Método para generar motivos coherentes
    private function generarMotivo()
    {
        $motivos = ['Enfermedad', 'Emergencia familiar', 'Problemas de transporte', 'Cita médica', 'Otros'];

        return $motivos[array_rand($motivos)];
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Puesto;
use App\Models\Departamento;

class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtén todos los departamentos
        $departamentos = Departamento::all();

        // Puestos por departamento
        $puestosPorDepartamento = [
            'jefe',
            'encargado',
            'trabajador general',
        ];

        // Agrega 3 registros de puestos por cada departamento
        foreach ($departamentos as $departamento) {
            foreach ($puestosPorDepartamento as $puesto) {
                Puesto::create([
                    'nombre' => $puesto,
                    'departamento_id' => $departamento->id,
                ]);
            }
        }
    }
}

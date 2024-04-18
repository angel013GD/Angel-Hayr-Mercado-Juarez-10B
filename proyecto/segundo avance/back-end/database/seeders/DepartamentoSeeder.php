<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Departamento; // Asegúrate de ajustar el espacio de nombres según la ubicación de tu modelo

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Nombres de departamentos
        $nombresDepartamentos = [
            'Recursos Humanos',
            'Finanzas',
            'Marketing',
            'Ventas',
            'Desarrollo',
            'Soporte Técnico',
            'Operaciones',
            'Calidad',
            'Logística',
            'Administración',
        ];

        // Agrega 10 registros a la tabla 'departamento' utilizando el modelo
        foreach ($nombresDepartamentos as $nombre) {
            Departamento::create([
                'nombre' => $nombre,
            ]);
        }
    }
}

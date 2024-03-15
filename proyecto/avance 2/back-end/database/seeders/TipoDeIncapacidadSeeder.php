<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TipoDeIncapacidad;

class TipoDeIncapacidadSeeder extends Seeder
{
    public function run()
    {
        $tiposIncapacidad = [
            'Enfermedad Común',
            'Accidente de Trabajo',
            'Licencia de Maternidad',
            'Lesiones Deportivas',
            'Rehabilitación Médica',
            'Enfermedad Profesional',
            'Licencia por Estrés',
            'Cirugía Programada',
            'Lesiones por Accidente Automovilístico',
            'Licencia por Duelo',
            'Enfermedad Respiratoria',
            'Lesiones en el Trabajo',
            'Licencia por Agotamiento',
            'Enfermedad Cardiovascular',
            'Licencia por Cuidado Familiar',
            'Lesiones por Caídas',
            'Licencia por Problemas de Salud Mental',
            'Enfermedad Gastrointestinal',
            'Licencia por Cirugía Mayor',
            'Lesiones Musculares',
        ];

        foreach ($tiposIncapacidad as $tipo) {
            TipoDeIncapacidad::create(['nombre' => $tipo]);
        }
    }
}

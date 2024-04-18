<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consulta;
use App\Models\Motivo;
use App\Models\Empleado;
use Faker\Factory as Faker;

class ConsultaSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtén todos los motivos y empleados disponibles
        $motivos = Motivo::all();
        $empleados = Empleado::all();

        $consultasCoherentes = [
            'Consulta sobre primeros auxilios por accidente en la línea de producción.',
            'Revisión médica para trabajadores que manejan maquinaria pesada.',
            'Solicitud de asesoramiento para la prevención de enfermedades ocupacionales.',
            'Consulta sobre protocolos de seguridad para el manejo de productos químicos.',
            'Revisión médica rutinaria para empleados en turnos nocturnos.',
            'Solicitud de orientación sobre ergonomía en los puestos de trabajo.',
            'Consulta sobre medidas preventivas para evitar contagios en la fábrica.',
            'Revisión de lesiones leves reportadas por trabajadores.',
            'Consulta sobre requisitos médicos para nuevos empleados.',
            'Solicitud de capacitación en primeros auxilios para el personal.',
        ];

        foreach ($empleados as $empleado) {
            // Selecciona un motivo aleatorio
            $motivo = $motivos->random();

            Consulta::create([
                'empleado' => $empleado->id,
                'motivo' => $motivo->id,
                'responsable' => $empleados->where('id', '!=', $empleado->id)->random()->id,
                'observaciones' => $consultasCoherentes[array_rand($consultasCoherentes)],
            ]);
        }
    }
}

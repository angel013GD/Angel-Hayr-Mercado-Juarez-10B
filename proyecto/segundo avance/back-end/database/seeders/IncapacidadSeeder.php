<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incapacidad;
use App\Models\Motivo;
use App\Models\TipoDeIncapacidad;
use App\Models\Empleado;
use Faker\Factory as Faker;

class IncapacidadSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // Obtén todos los tipos de incapacidad, motivos y empleados disponibles
        $tiposIncapacidad = TipoDeIncapacidad::all();
        $motivos = Motivo::all();
        $empleados = Empleado::all();

        // Lista de frases relacionadas con incapacidades
        $frasesIncapacidad = [
            'Incapacidad debido a enfermedad.',
            'Reposo por lesión laboral.',
            'Licencia médica por problemas de salud.',
            'Recuperación de cirugía programada.',
            'Convalecencia por accidente automovilístico.',
            'Tratamiento médico por enfermedad crónica.',
            'Descanso recomendado para recuperación completa.',
            'Permiso médico por consulta especializada.',
            'Reposo necesario para recuperación física.',
            'Licencia por motivos de salud mental.',
        ];

        foreach ($tiposIncapacidad as $tipoIncapacidad) {
            foreach ($empleados as $empleado) {
                // Selecciona un motivo aleatorio y una frase de incapacidad aleatoria
                $motivo = $motivos->random();

                // Genera fechas de inicio y fin dentro del rango 2016-2023
                $fechaInicio = $faker->dateTimeBetween('-7 years', 'now');
                $dias = $faker->numberBetween(1, 15);

                // Clona la fecha de inicio y luego agrega los días
                $fechaFin = clone $fechaInicio;
                $fechaFin->modify("+$dias days");

                Incapacidad::create([
                    'empleado' => $empleado->id,
                    'motivo' => $motivo->id,
                    'tipo_incapacidad' => $tipoIncapacidad->id,
                    'dias' => $dias,
                    'fecha_inicio' => $fechaInicio->format('Y-m-d'),
                    'fecha_fin' => $fechaFin->format('Y-m-d'),
                    'observaciones' => $frasesIncapacidad[array_rand($frasesIncapacidad)],
                    'estado' => $faker->numberBetween(1, 3),
                ]);
            }
        }
    }
}

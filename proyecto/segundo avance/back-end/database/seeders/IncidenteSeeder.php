<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Incidente;
use App\Models\Empleado;
use App\Models\Departamento;

class IncidenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtén todos los empleados y departamentos
        $empleados = Empleado::all();
        $departamentos = Departamento::all();

        // Datos comunes para los incidentes
        $datosIncidenteComunes = [
            "trabajo_trayecto" => "Trabajo",
            "interno_imss" => "N/A",
            "observaciones" => "Sin observaciones",
        ];

        // Genera al menos un incidente por cada empleado
        foreach ($empleados as $empleado) {
            // Obtén un departamento aleatorio para el incidente
            $departamento = $departamentos->random();

            // Datos específicos del incidente
            $datosIncidenteEspecificos = [
                "empleado_id" => $empleado->id,
                "departamento_id" => $departamento->id,
                "fecha_incidente" => $this->generarFechaAleatoria(),
                "observaciones" => $this->generarObservacionAleatoria(),
            ];

            // Crea el incidente
            Incidente::create(array_merge($datosIncidenteComunes, $datosIncidenteEspecificos));
        }
    }

    private function generarObservacionAleatoria()
    {
        $observaciones = [
            'fallecimiento',
            'pérdida de una mano',
            'pérdida de un dedo',
            'desmayo',
            'accidente menor',
            'lesión grave',
            'incidente de trayecto',
            // Añade más observaciones según sea necesario
        ];

        return $observaciones[array_rand($observaciones)];
    }

    private function generarFechaAleatoria()
    {
        $inicio = strtotime("2023-01-01");
        $fin = strtotime("2023-12-31");
        $fechaAleatoria = date("Y-m-d", rand($inicio, $fin));
        return $fechaAleatoria;
    }
}

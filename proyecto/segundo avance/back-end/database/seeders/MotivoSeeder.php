<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Motivo;

class MotivoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $motivos = [
            "Caída desde altura",
            "Objeto cortante",
            "Objeto contundente",
            "Exposición a sustancias tóxicas",
            "Accidente vehicular",
            "Resbalón o tropiezo",
            "Equipo defectuoso",
            "Fuego o quemadura",
            "Electrocución",
            "Exceso de velocidad",
            "Mal manejo de maquinaria",
            "Falta de equipo de protección",
            "Ergonomía inadecuada",
            "Falta de señalización",
            "Derrame de líquidos",
            "Accidente durante el trayecto",
            "Malas condiciones climáticas",
            "Uso incorrecto de herramientas",
            "Falta de capacitación"
        ];

        foreach ($motivos as $motivo) {
            Motivo::create([
                "nombre" => $motivo,
                "nivel_gravedad" => rand(1, 5),
            ]);
        }
    }
}

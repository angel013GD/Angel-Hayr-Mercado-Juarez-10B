<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Rol;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rol::create([
            "id" => 1,
            "nombre" => "admin",
            "descripcion" => "Administrador que puede manipular auth",
        ]);

        Rol::create([
            "id" => 2,
            "nombre" => "gerente_general",
            "descripcion" => "Administrador regular, no puede manipular auth",
        ]);

        Rol::create([
            "id" => 3,
            "nombre" => "allSeeing",
            "descripcion" => "Usuario que puede ver todos los módulos",
        ]);
        Rol::create([
            "id" => 4,
            "nombre" => "evidencias",
            "descripcion" => "Usuario que puede ver y realizar todas las acciones del modulo de evidencias",
        ]);
        Rol::create([
            "id" => 5,
            "nombre" => "RH",
            "descripcion" => "Usuario que puede ver y realizar todas las acciones del modulo de evidencias",
        ]);
    }
}

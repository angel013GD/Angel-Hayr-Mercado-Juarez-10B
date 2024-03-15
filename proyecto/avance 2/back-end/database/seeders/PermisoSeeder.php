<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Permiso;

use App\Utils\Database;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Se dejaron los roles Previos de Edgar para llevar la misma secuencia que tiene cuando se llegue a implementar
     * @return void
     */
    public function run()
    {
        Permiso::create([
            "id" => 1,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "PERMISOS",
        ]);
        $crudPermisos = Database::generatePermisosCrud("PERMISOS"); // offset de 4
        foreach ($crudPermisos as $crudObj) {
            Permiso::create($crudObj);
        }

        Permiso::create([
            "id" => 6,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "ROLES",
        ]);
        $crudRoles = Database::generatePermisosCrud("ROLES");
        foreach ($crudRoles as $crudObj) {
            Permiso::create($crudObj);
        }

        Permiso::create([
            "id" => 11,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "USUARIOS",
        ]);
        $crudUsuarios = Database::generatePermisosCrud("USUARIOS");
        foreach ($crudUsuarios as $crudObj) {
            Permiso::create($crudObj);
        }

        Permiso::create([
            "id" => 16,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "CLIENTES",
        ]);
        $crudClientes = Database::generatePermisosCrud("CLIENTES");
        foreach ($crudClientes as $crudObj) {
            Permiso::create($crudObj);
        }

        Permiso::create([
            "id" => 21,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "OPERADORES",
        ]);
        $crudOperadores = Database::generatePermisosCrud("OPERADORES");
        foreach ($crudOperadores as $crudObj) {
            Permiso::create($crudObj);
        }

        Permiso::create([
            "id" => 26,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "TRACTORES",
        ]);
        $crudClientes = Database::generatePermisosCrud("TRACTORES");
        foreach ($crudClientes as $crudObj) {
            Permiso::create($crudObj);
        }

        Permiso::create([
            "id" => 31,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "REMOLQUES",
        ]);
        $crudRemolques = Database::generatePermisosCrud("REMOLQUES");
        foreach ($crudRemolques as $crudObj) {
            Permiso::create($crudObj);
        }
        Permiso::create([
            "id" => 36,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "EVIDENCIAS",
        ]);
        $crudEvidencias = Database::generatePermisosCrud("EVIDENCIAS");
        foreach ($crudEvidencias as $crudObj) {
            Permiso::create($crudObj);
        }
        Permiso::create([
            "id" => 41,
            "nombre" => "VIEW_SECTION",
            "tipo" => "ALLOW_CRUD",
            "modulo" => "RECURSOSHUMANOS",
        ]);
        $crudrh = Database::generatePermisosCrud("RECURSOSHUMANOS");
        foreach ($crudrh as $crudObj) {
            Permiso::create($crudObj);
        }

    }
}

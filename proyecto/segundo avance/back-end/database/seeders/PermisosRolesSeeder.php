<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PermisosRoles;

use App\Models\Permiso;

class PermisosRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // NOTA. correr primero los seeders de permisos y roles, antes de correr este seeder

        // admin (todos los permisos existentes)
        $allPermisos = Permiso::get()->map(function ($permiso) {
            PermisosRoles::create([
                "rol_id" => 1,
                "permiso_id" => $permiso["id"],
            ]);
        });

        // gerente General ( todos excepto los de auth (usuarios, permisos, roles))
        $permisosAdmin = Permiso::whereNotIn("modulo", [
            "PERMISOS",
            "ROLES",
            "USUARIOS",
            "ADMIN",
        ])
            ->get()
            ->map(function ($permiso) {
                PermisosRoles::create([
                    "rol_id" => 2,
                    "permiso_id" => $permiso["id"],
                ]);
            });

        // allseeing: todos los permisos para ALL (puede entrar a todas las páginas solamente)
        $permisosAllSeeing = Permiso::where("nombre", "VIEW_SECTION")
            ->get()
            ->map(function ($permiso) {
                PermisosRoles::create([
                    "rol_id" => 3,
                    "permiso_id" => $permiso["id"],
                ]);
            });
        $permisosEvidencias = Permiso::where("modulo", "EVIDENCIAS")
        ->get()
        ->map(function ($permiso) {
            PermisosRoles::create([
                "rol_id" => 4,
                "permiso_id" => $permiso["id"],
            ]);
        });
        $permisosEvidencias = Permiso::where("modulo", "RECURSOSHUMANOS")
        ->get()
        ->map(function ($permiso) {
            PermisosRoles::create([
                "rol_id" => 5,
                "permiso_id" => $permiso["id"],
            ]);
        });

    }
}

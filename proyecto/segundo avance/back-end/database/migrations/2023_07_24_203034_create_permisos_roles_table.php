<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePermisosRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permisos_roles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("rol_id");
            $table->unsignedBigInteger("permiso_id");
            $table->unique(["rol_id", "permiso_id"]);

            $table->foreign("rol_id")
                ->references("id")->on("roles");

            $table->foreign("permiso_id")
                ->references("id")->on("permisos");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE permisos_roles CONVERT TO CHARACTER SET utf8 COLLATE utf8_bin");
        DB::statement('ALTER TABLE permisos_roles ENGINE=InnoDB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permisos_roles');
    }
}

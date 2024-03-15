<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolesUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles_usuarios', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("usuario_id");
            $table->unsignedBigInteger("rol_id");
            $table->timestamps();
            $table->softDeletes();

            $table->unique(["usuario_id", "rol_id"]);

            $table->foreign("usuario_id")
                // ->references("id")->on("usuarios"); //Comentado para agregar la tabla temporal, cambiar cuando se implemente la tabla verdadera
                ->references("id")->on("usuarios");
            $table->foreign("rol_id")
                ->references("id")->on("roles");
        });
        DB::statement("ALTER TABLE roles_usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_bin");
        DB::statement('ALTER TABLE roles_usuarios ENGINE=InnoDB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles_usuarios');
    }
}

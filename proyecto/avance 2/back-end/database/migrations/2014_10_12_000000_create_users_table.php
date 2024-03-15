<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('nombre_usuario');
            $table->string('correo')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('contrasenia');
            $table->unsignedBigInteger("empleado_id");
            $table->rememberToken();
            $table->timestamps();
        });
                // Definir la collation utf8_bin para toda la tabla
                DB::statement("ALTER TABLE usuarios CONVERT TO CHARACTER SET utf8 COLLATE utf8_bin");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaltasTable extends Migration
{
    public function up()
    {
        Schema::create('faltas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_empleado');
            $table->unsignedBigInteger('id_departamento');
            $table->string('motivo');
            $table->date('fecha');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Definir las llaves foráneas
            $table->foreign('id_empleado')->references('id')->on('empleado');
            $table->foreign('id_departamento')->references('id')->on('departameto');
        });
    }

    public function down()
    {
        Schema::dropIfExists('faltas');
    }
}

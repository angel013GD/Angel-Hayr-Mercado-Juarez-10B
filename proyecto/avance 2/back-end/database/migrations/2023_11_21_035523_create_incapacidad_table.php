<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncapacidadTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incapacidad', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado');
            $table->unsignedBigInteger('motivo');
            $table->unsignedBigInteger('tipo_incapacidad');
            $table->integer('dias');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->text('observaciones');
            $table->boolean('estado');
            $table->timestamps();

            $table->foreign('empleado')->references('id')->on('empleado');
            $table->foreign('motivo')->references('id')->on('motivo');
            $table->foreign('tipo_incapacidad')->references('id')->on('tipodeincapacidad');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incapacidad');
    }
}

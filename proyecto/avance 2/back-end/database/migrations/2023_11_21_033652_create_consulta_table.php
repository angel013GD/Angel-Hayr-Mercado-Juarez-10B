<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsultaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consulta', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('empleado');
            $table->unsignedBigInteger('motivo');
            $table->unsignedBigInteger('responsable');
            $table->text('observaciones');
            $table->timestamps();

            $table->foreign('empleado')->references('id')->on('empleado');
            $table->foreign('motivo')->references('id')->on('motivo');
            $table->foreign('responsable')->references('id')->on('empleado');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consulta');
    }
}

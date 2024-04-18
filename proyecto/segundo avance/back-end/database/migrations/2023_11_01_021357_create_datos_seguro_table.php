<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosSeguroTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_seguro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("empleado_id");
            $table->unsignedBigInteger('numero_seguro');
            $table->tinyInteger('estatus');
            $table->timestamp('fecha_alta_seguro')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign("empleado_id")
            ->references("id")->on("empleado");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datos_seguro');
    }
}

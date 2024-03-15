<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosEmergenciaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datos_emergencia', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("empleado_id");
            $table->string('contacto_emergencia');
            $table->string('correo_emergencia');
            $table->string('telefono_emergencia');
            $table->string('alergias');
            $table->string('tipo_sangre');
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
        Schema::dropIfExists('datos_emergencia');
    }
}

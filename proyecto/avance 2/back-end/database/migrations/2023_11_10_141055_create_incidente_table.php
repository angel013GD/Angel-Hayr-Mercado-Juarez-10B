<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidente', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("empleado_id");
            $table->unsignedBigInteger("departamento_id");
            $table->date('fecha_incidente');
            $table->string('interno_imss');
            $table->string('trabajo_trayecto');
            $table->string('observaciones');        
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign("empleado_id")
            ->references("id")->on("empleado");
            $table->foreign("departamento_id")
            ->references("id")->on("departameto");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidente');
    }
}

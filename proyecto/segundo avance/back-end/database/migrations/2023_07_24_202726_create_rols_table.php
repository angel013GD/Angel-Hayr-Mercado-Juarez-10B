<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateRolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string("nombre")->unique();
            $table->string("descripcion");

            $table->timestamps();
            $table->softDeletes();
        });
                // Configuración de collation y motor
                DB::statement("ALTER TABLE roles CONVERT TO CHARACTER SET utf8 COLLATE utf8_bin");
                DB::statement('ALTER TABLE roles ENGINE=InnoDB');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}

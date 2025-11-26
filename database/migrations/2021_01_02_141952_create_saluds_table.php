<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaludsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salud', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_matricula');
            $table->string('tipo_documento',3)->comment('DNI, PTP, CE, PN');
            $table->string('numero_documento',20)->unique();
            $table->string('nombres');
            $table->string('nombre_establecimiento');
            $table->string('direccion');
            $table->string('referencia');
            $table->string('tipo_seguro');
            $table->string('otro_seguro')->nullable();
            $table->string('parentesco');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salud');
    }
}

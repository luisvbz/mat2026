<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatriculasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('estado')->comment('0: Pendiente, 1: Confirmada, 2: Anulada');
            $table->integer('alumno_id')->unsigned();
            $table->string('codigo');
            $table->integer('anio')->unsigned();
            $table->char('nivel',1)->comment('P: Primaria, S: Secundaria');
            $table->tinyInteger('grado')->unsigned();
            $table->string('tipo_documento_dj',3)->comment('DNI, PTP, CE, PN');
            $table->string('numero_documento_dj',20);
            $table->string('nombres_dj');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matriculas');
    }
}

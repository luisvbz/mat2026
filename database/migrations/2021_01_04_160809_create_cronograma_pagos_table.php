<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCronogramaPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cronograma_pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('orden');
            $table->string('orden_letras');
            $table->string('mes', 2);
            $table->integer('costo_id');
            $table->decimal('costo', 9,2);
            $table->date('fecha_inicio');
            $table->date('fecha_vencimiento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cronograma_pagos');
    }
}

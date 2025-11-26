<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('estado')->comment('0: Pendiente de por aprobación, 1: Pago Verificado, 2: Anulado');
            $table->char('concepto', 1)->comment('M: Matricula, P: Pension');
            $table->string('codigo_matricula');
            $table->char('tipo_pago', 1)->comment('D: Deposito en Banco, T: Transferencia, A: Agente, Y: Yape');
            $table->string('numero_operacion')->unique();
            $table->decimal('monto_pagado', 9,2);
            $table->date('fecha_deposito');
            $table->string('comprobante');
            $table->text('justificacion')->nullable();
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
        Schema::dropIfExists('pagos');
    }
}

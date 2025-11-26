<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePensionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pensiones', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('estado')->comment('0: Pendiente de por aprobación, 1: Pago Verificado, 2: Anulado');
            $table->string('codigo_matricula');
            $table->string('mes', 2);
            $table->decimal('costo', 9,2);
            $table->string('comprobante');
            $table->unsignedTinyInteger('has_boleta')->default(0);
            $table->date('fecha_pago');
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
        Schema::dropIfExists('pensiones');
    }
}

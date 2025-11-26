<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePadresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('padres', function (Blueprint $table) {
            $table->id();
            $table->char('parentesco', 1)->comment('M: Madre, P: Padre');
            $table->string('tipo_documento',3)->comment('DNI, PTP, CE, PN');
            $table->string('numero_documento',20)->unique();
            $table->string('apellidos');
            $table->string('nombres');
            $table->date('fecha_nacimiento');
            $table->string('domicilio')->nullable();
            $table->string('telefono_celular')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('nivel_escolaridad')->nullable();
            $table->string('centro_trabajo')->nullable();
            $table->string('cargo_ocupacion')->nullable();
            $table->char('estado_civil',1)->nullable();
            $table->unsignedTinyInteger('apoderado')->default(0);
            $table->unsignedTinyInteger('responsable_economico')->default(0);
            $table->unsignedTinyInteger('vive')->default(0);
            $table->unsignedTinyInteger('vive_estudiante')->default(0);
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
        Schema::dropIfExists('padres');
    }
}

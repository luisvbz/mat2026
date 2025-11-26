<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApoderadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apoderados', function (Blueprint $table) {
            $table->id();
            $table->string('parentesco');
            $table->string('tipo_documento',3)->comment('DNI, PTP, CE, PN');
            $table->string('numero_documento',20)->unique();
            $table->string('apellidos');
            $table->string('nombres');
            $table->string('telefono_celular')->nullable();
            $table->string('correo_electronico')->nullable();
            $table->string('nivel_escolaridad')->nullable();
            $table->string('grado_obtenido')->nullable();
            $table->string('centro_trabajo')->nullable();
            $table->unsignedTinyInteger('vive_estudiante')->default(0);
            $table->unsignedTinyInteger('apoderado')->default(0);
            $table->unsignedTinyInteger('responsable_economico')->default(0);
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
        Schema::dropIfExists('apoderados');
    }
}

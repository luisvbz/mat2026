<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('estado')->nullable()->default(null)->unsigned();
            $table->string('apellido_paterno',100);
            $table->string('apellido_materno',100)->nullable()->default(null);
            $table->string('nombres',200);
            $table->string('tipo_documento',3)->comment('DNI, PTP, CE, PN');
            $table->string('numero_documento',20)->unique();
            $table->char('genero',1)->nullable()->default(null);
            $table->date('fecha_nacimiento')->nullable()->default(null);
            $table->char('estado_civil',1)->nullable()->default(null);
            $table->char('departamento_id',5)->nullable()->default(null);
            $table->char('provincia_id',5)->nullable()->default(null);
            $table->char('distrito_id',6)->nullable()->default(null);
            $table->string('domicilio',500)->nullable()->default(null);
            $table->string('religion',100)->nullable()->default(null);
            $table->string('parroquia',100)->nullable()->default(null);
            $table->string('telefono_fijo',12)->nullable()->default(null);
            $table->string('celular',12)->nullable()->default(null);
            $table->string('telefono_emergencia',12)->nullable()->default(null);
            $table->tinyInteger('exonerado_religion')->nullable()->default(null)->unsigned();
            $table->tinyInteger('bautizado')->nullable()->default(null)->unsigned();;
            $table->tinyInteger('comunion')->nullable()->default(null)->unsigned();
            $table->tinyInteger('confirmacion')->nullable()->default(null)->unsigned();
            $table->string('colegio_procedencia')->nullable()->default(null);
            $table->string('situacion_final')->nullable()->default(null);
            $table->string('lugar')->nullable()->default(null);
            $table->string('correo')->nullable()->default(null);
            $table->tinyInteger('lugar_hermano')->nullable()->default(null)->unsigned();
            $table->char('tipo_parto',2)->nullable()->default(null);
            $table->tinyInteger('nee')->nullable()->default(null)->unsigned()->unsigned();
            $table->string('nee_descripcion')->nullable()->default(null);
            $table->string('observaciones')->nullable()->default(null);
            $table->string('foto')->nullable()->default(null);
            $table->string('se_sento')->nullable()->default(null);
            $table->string('control_esfinteres')->nullable()->default(null);
            $table->string('camino')->nullable()->default(null);
            $table->string('hablo_fluido')->nullable()->default(null);
            $table->string('se_paro')->nullable()->default(null);
            $table->string('primeras_palabras')->nullable()->default(null);
            $table->string('levanto_cabeza')->nullable()->default(null);
            $table->string('gateo')->nullable()->default(null);
            $table->string('nacionalidad')->default('PERUANA');
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
        Schema::dropIfExists('alumnos');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoAlumno extends Model
{
    use HasFactory;

    public $table = "permisos_alumnos";

    const Entrada = 'E';
    const SALIDA = 'S';
    const SALUD = 'SA';


    protected $fillable = [
        'alumno_id',
        'estado',
        'tipo',
        'desde',
        'hasta',
        'comentario',
        'creado_por'
    ];


    public function alumno()
    {
        return $this->belongsTo(Matricula::class, 'alumno_id', 'alumno_id');
    }
}

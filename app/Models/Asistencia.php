<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    const NORMAL = 'N';
    const TARDANZA = 'T';
    const TARDANZA_JUSTIFICADA = 'TJ';
    const FALTA_INJUSTIFICADA = 'FI';
    const FALTA_JUSTIFICADA = 'FJ';
    const FERIADO = 'F';

    protected $fillable = [
        'alumno_id',
        'tipo',
        'anio',
        'mes',
        'dia',
        'entrada',
        'tardanza_entrada',
        'salida',
        'salida_anticipada',
        'comentario_salida',
        'permiso_id'
    ];

    public function feriado()
    {
        return $this->belongsTo(AsistenciaFeriado::class, 'dia', 'fecha_feriado');
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }
}

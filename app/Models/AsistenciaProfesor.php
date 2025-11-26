<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaProfesor extends Model
{
    use HasFactory;

    protected $table = 'asistencias_profesores';

    protected $guarded = [];

    const NORMAL = 'N';
    const TARDANZA = 'T';
    const FALTA_INJUSTIFICADA = 'FI';
    const FALTA_JUSTIFICADA = 'FJ';
    const FERIADO = 'F';
    const NO_LABORABLE  = 'NL';

    public function feriado()
    {
        return $this->belongsTo(AsistenciaFeriado::class, 'dia', 'fecha_feriado');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsistenciaFeriado extends Model
{
    use HasFactory;

    protected $table = 'asistencias_feriados';

    protected $fillable = [
        'fecha_feriado',
        'descripcion',
    ];

    public function getFechaFeriadoAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d/m/Y');
    }
}

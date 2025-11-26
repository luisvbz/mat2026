<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisosPersonal extends Model
{
    use HasFactory;
    protected $table = "permisos_personal";
    const Entrada = 'E';
    const SALIDA = 'S';
    const SALUD = 'SA';


    protected $fillable = [
        'teacher_id',
        'estado',
        'tipo',
        'desde',
        'hasta',
        'comentario',
        'creado_por'
    ];

    public function profesor()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}

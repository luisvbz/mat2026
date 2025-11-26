<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfesorHorario extends Model
{
    use HasFactory;
    protected $table = 'profesores_horarios';

    protected $casts = [
      'lunes' => 'boolean',
      'martes' => 'boolean',
      'miercoles' => 'boolean',
      'jueves' => 'boolean',
      'viernes' => 'boolean',
    ];
}

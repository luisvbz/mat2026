<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grado extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nivel',
        'numero',
        'nombre'
    ];

    public function profesores(){
        return $this->belongsToMany(Profesor::class,'grados_profesores',  'grado_id', 'profesor_id')->orderBy('nombre', 'ASC');
    }
}

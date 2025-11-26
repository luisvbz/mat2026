<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Padre extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['nombre_completo'];

    public function getNombreCompletoAttribute()
    {
        $nombres = ucwords(strtolower($this->nombres));
        return trim("{$this->apellidos}, {$nombres}");
    }

}

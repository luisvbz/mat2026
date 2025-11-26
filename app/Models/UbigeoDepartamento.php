<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbigeoDepartamento extends Model
{
    protected $table = 'ubigeo_departamentos';
    public $incrementing = false;

    public function getNombreAttribute($value)
    {
        return $this->attributes['nombre'] = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }
}

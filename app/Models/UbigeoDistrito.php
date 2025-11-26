<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UbigeoDistrito extends Model
{
    protected $table = 'ubigeo_distritos';
    public $incrementing = false;

    public function getNombreAttribute($value)
    {
        return $this->attributes['nombre'] = mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }
}

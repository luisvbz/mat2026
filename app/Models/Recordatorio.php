<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status'];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'codigo_matricula', 'codigo');
    }


    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    public function getStatusAttribute()
    {
        $value = $this->estado;
        switch ($value) {
            case 0:
                return '<i class="fas fa-circle has-text-danger"></i>';
                break;
            case 1:
                return '<i class="fas fa-circle has-text-success"></i>';
                break;
        }
    }
}

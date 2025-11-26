<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status'];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'codigo_matricula', 'codigo');
    }

    public function getStatusAttribute()
    {
        $value = $this->estado;
        switch ($value) {
            case 0:
                return '<i class="fas fa-circle has-text-warning"></i>';
                break;
            case 1:
                return '<i class="fas fa-circle has-text-success"></i>';
                break;
            case 2:
                return '<i class="fas fa-circle has-text-danger"></i>';
                break;
        }
    }
}

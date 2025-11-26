<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CronogramaPagos extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status', 'vencimiento'];

    public function getStatusAttribute()
    {
        $now = date('Y-m-d');
        $fecha_inicio = $this->fecha_inicio;
        $fecha_vencimiento = $this->fecha_vencimiento;

        if($now >= $fecha_inicio && $now <= $fecha_vencimiento)
        {
            return '<i class="fas fa-circle has-text-success"></i>';
        }else if ($now >= $fecha_inicio && $now > $fecha_vencimiento){
            return '<i class="fas fa-circle has-text-danger"></i>';
        }else {
            return '<i class="fas fa-circle has-text-warning"></i>';
        }
    }

    public function getVencimientoAttribute()
    {
        $now = date('Y-m-d');
        $fecha_inicio = $this->fecha_inicio;
        $fecha_vencimiento = $this->fecha_vencimiento;

         if ($now >= $fecha_inicio && $now > $fecha_vencimiento){
            return true;
        }else {
             return false;
         }
    }
}

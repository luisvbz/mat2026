<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matricula extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['status', 'statusletter'];

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function pagos()
    {
        return $this->hasMany(Pago::class, 'codigo_matricula', 'codigo')->orderBy('id', 'DESC');
    }

    public function salud()
    {
        return $this->hasOne(Salud::class, 'codigo_matricula', 'codigo');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'alumno_id', 'alumno_id');
    }

    public function getStatusAttribute()
    {
        $value = $this->estado;
        switch ($value) {
            case 0:
                return '<i class="ph ph-circle text-yellow-600"></i>';
                break;
            case 1:
                return '<i class="ph ph-check-circle text-green-600"></i>';
                break;
            case 2:
                return '<i class="ph ph-prohibit text-red-600"></i>';
                break;
        }
    }
    public function getStatusletterAttribute()
    {
        $value = $this->estado;
        switch ($value) {
            case 0:
                return '<i class="fas fa-circle has-text-warning"></i> Pendiente';
                break;
            case 1:
                return '<i class="fas fa-circle has-text-success"></i> Confirmada';
                break;
            case 2:
                return '<i class="fas fa-circle has-text-danger"></i> Anulada';
                break;
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'documento',
        'nombres',
        'apellidos',
        'email',
        'telefono',
        'estado',
        'horario_id',
    ];

    public function getStatusAttribute()
    {
        $value = $this->estado;
        switch ($value) {
            case 1:
                return '<i class="fas fa-circle has-text-success"></i>';
                break;
            case 0:
                return '<i class="fas fa-circle has-text-danger"></i>';
                break;
        }
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'horario_id');
    }

    public function permisos()
    {
        return $this->hasMany(PermisosPersonal::class, 'teacher_id');
    }

    public function getFotoAttribute()
    {

        return asset("/images/fotos/p/{$this->documento}.jpg");
    }


    public function asistencias()
    {
        return $this->hasMany(AsistenciaProfesor::class, 'teacher_id');
    }

    public function getNombreCompletoAttribute()
    {
        $nombres = ucwords(strtolower($this->nombres));
        return trim("{$this->apellidos}, {$nombres}");
    }

    public function user()
    {
        return $this->hasOne(TeacherUser::class, 'teacher_id');
    }
}

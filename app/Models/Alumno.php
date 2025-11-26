<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $guarded = [];

    protected $appends = ['nombre_completo', 'foto', 'edad'];

    public function padres()
    {
        return $this->belongsToMany(Padre::class, 'alumnos_padres');
    }


    public function apoderados()
    {
        return $this->belongsToMany(Apoderado::class, 'alumnos_apoderados');
    }

    public function departamento()
    {
        return $this->belongsTo(UbigeoDepartamento::class, 'departamento_id');
    }

    public function provincia()
    {
        return $this->belongsTo(UbigeoProvincia::class, 'provincia_id');
    }

    public function distrito()
    {
        return $this->belongsTo(UbigeoDistrito::class, 'distrito_id');
    }

    /*public function getNombreCompletoAttribute()
    {
        $nombres = ucwords(strtolower($this->nombres));
        return trim("{$this->apellido_paterno} {$this->apellido_materno}, {$nombres}");
    }*/

    public function getNombreCompletoAttribute()
    {
        $nombres = mb_convert_case($this->nombres, MB_CASE_TITLE, "UTF-8");
        $apellidoPaterno = mb_strtoupper($this->apellido_paterno, "UTF-8");
        $apellidoMaterno = mb_strtoupper($this->apellido_materno, "UTF-8");

        return trim("{$apellidoPaterno} {$apellidoMaterno}, {$nombres}");
    }

    public function getFotoAttribute()
    {
        if ($this->has_foto) {
            return "/images/fotos/{$this->numero_documento}.jpg";
        }
        return $this->genero == 'F' ? '/images/default_profile_female.png' : '/images/default_profile_male.png';
    }

    public function getEdadAttribute()
    {
        $b = Carbon::createFromFormat('Y-m-d', $this->fecha_nacimiento);
        $hoy = Carbon::now();

        return $hoy->diffInYears($b);
    }

    public function matricula()
    {
        return $this->hasOne(Matricula::class, 'alumno_id');
    }
}

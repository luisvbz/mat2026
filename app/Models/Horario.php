<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $table = "schedules";


    public function dias()
    {
        return $this->hasMany(HorarioDias::class, 'schedule_id')->orderBy('day_number');
    }
}

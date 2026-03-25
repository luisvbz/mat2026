<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HorarioDias extends Model
{
    use HasFactory;

    protected $table = "schedule_days";

    public $timestamps = false;

    protected $guarded = [];
}

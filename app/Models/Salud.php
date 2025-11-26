<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salud extends Model
{
    use HasFactory;

    protected $table = 'salud';

    public $timestamps = false;

    public $guarded = [];
}

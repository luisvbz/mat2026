<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermisoArchivo extends Model
{
    use HasFactory;

    public $table = "permisos_archivos";
    public $timestamps = "false";

    public $fillable = [
        'permiso_id',
        'archivo'
    ];


}

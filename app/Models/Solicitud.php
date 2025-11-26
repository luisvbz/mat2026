<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model
{
    use HasFactory;
    protected $table = 'solicitudes';
    protected $guarded = [];

    protected $appends = ['status'];

    public function usuario()
    {
        return $this->belongsTo(User::class);
    }

    public function documentos(){
        return $this->belongsToMany(TipoDocumento::class,'solicitudes_documentos', 'solicitud_id', 'documento_id');
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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationAttachment extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'communication_id',
        'name',
        'url',
        'type',
        'size',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    
    public function communication()
    {
        return $this->belongsTo(Communication::class, 'communication_id');
    }
}

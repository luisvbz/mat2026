<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'description',
        'type',
        'link',
        'attachment',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

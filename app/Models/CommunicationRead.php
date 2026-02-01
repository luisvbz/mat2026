<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationRead extends Model
{
    use HasFactory;

    protected $fillable = [
        'communication_id',
        'parent_user_id',
        'read_at',
    ];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function communication()
    {
        return $this->belongsTo(Communication::class);
    }

    public function parentUser()
    {
        return $this->belongsTo(ParentUser::class);
    }
}

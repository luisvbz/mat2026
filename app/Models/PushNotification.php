<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PushNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'role',
        'title',
        'message',
        'image',
        'url',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function user()
    {
        if ($this->role === 'parent') {
            return $this->belongsTo(ParentUser::class, 'user_id');
        }
        return $this->belongsTo(TeacherUser::class, 'user_id');
    }
}

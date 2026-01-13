<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'matricula_id',
        'teacher_user_id',
        'date',
        'subject',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'date' => 'date',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    public function matricula()
    {
        return $this->belongsTo(Matricula::class, 'matricula_id');
    }

    public function teacherUser()
    {
        return $this->belongsTo(TeacherUser::class, 'teacher_user_id');
    }

    public function replies()
    {
        return $this->hasMany(AgendaReply::class, 'message_id');
    }

    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}

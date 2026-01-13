<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeacherUser extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'teacher_users';

    protected $fillable = [
        'teacher_id',
        'document_number',
        'password',
        'is_active',
        'last_login_at',
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];


    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }
}

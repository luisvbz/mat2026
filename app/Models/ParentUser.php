<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ParentUser extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'padre_id',
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

    // Relación con Padre
    public function padre()
    {
        return $this->belongsTo(Padre::class, 'padre_id');
    }

    public function children()
    {
        return $this->padre->alumnos();
    }

    public function communicationReads()
    {
        return $this->hasMany(CommunicationRead::class, 'parent_user_id');
    }

    public function hasReadCommunication($communicationId)
    {
        return $this->communicationReads()
            ->where('communication_id', $communicationId)
            ->exists();
    }
}

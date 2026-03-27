<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
    protected $table = 'appointments';
    protected $fillable = [
        'type',
        'status',
        'parent_id',
        'teacher_id',
        'student_id',
        'date',
        'time',
        'duration',
        'subject',
        'notes',
        'location',
        'created_by',
        'confirmed_at',
        'cancelled_at',
        'cancelled_by',
        'cancellation_reason',
        'absented_notes'
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
    ];

    public function parent()
    {
        return $this->belongsTo(Padre::class, 'parent_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function student()
    {
        return $this->belongsTo(Alumno::class, 'student_id');
    }

    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function reject()
    {
        $this->update(['status' => 'rejected']);
    }
    
    public function complete()
    {
        $this->update(['status' => 'completed']);
    }

    public function absent($notes)
    {
        $this->update(['status' => 'absented', 'absented_notes' => $notes]);
    }

    public function cancel($by, $reason = null)
    {
        $this->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancelled_by' => $by,
            'cancellation_reason' => $reason,
        ]);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'confirmed')
            ->where('date', '>=', now()->toDateString());
    }
}

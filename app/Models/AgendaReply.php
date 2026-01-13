<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaReply extends Model
{
    use HasFactory;

    protected $table = 'agenda_replies';

    protected $fillable = [
        'agenda_message_id',
        'author_type',
        'author_id',
        'message',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    // Mensaje original
    public function agendaMessage()
    {
        return $this->belongsTo(AgendaMessage::class, 'agenda_message_id');
    }

    // Autor polimórfico
    public function author()
    {
        if ($this->author_type === 'parent') {
            return Padre::find($this->author_id);
        }
        return Teacher::find($this->author_id);
    }

    // Marcar como leído
    public function markAsRead()
    {
        $this->update([
            'is_read' => true,
            'read_at' => now(),
        ]);
    }
}

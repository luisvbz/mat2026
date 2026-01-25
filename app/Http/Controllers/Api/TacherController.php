<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AgendaMessage;
use App\Models\AgendaReply;
use App\Models\Matricula;
use Illuminate\Http\Request;

class TacherController extends Controller
{
    public function getStats()
    {
        $allAgendasMessagesCount = AgendaMessage::whereHas('teacherUser', function ($query) {
            $query->where('teacher_id', auth()->user()->teacher->id);
        })->count();

        $pendingAgendasMessagesCount = AgendaReply::whereHas('agendaMessage', function ($query) {
            $query->where('teacher_user_id', auth()->user()->id);
        })->where('is_read', false)->count();

        $allMyAgendas =  $students = Matricula::whereIn('id', AgendaMessage::where('teacher_user_id', auth()->user()->id)->pluck('matricula_id'))
            ->where('estado', 1)
            ->with('alumno')
            ->orderBy('nivel', 'ASC')
            ->orderBy('grado', 'ASC')
            ->count();

        $lastFiMessageUnread = AgendaReply::with('agendaMessage', 'agendaMessage.matricula', 'agendaMessage.matricula.alumno')->whereHas('agendaMessage', function ($query) {
            $query->where('teacher_user_id', auth()->user()->id);
        })->where('author_type', 'parent')
            ->where('is_read', false)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($reply) {
                return [
                    'reply_id' => $reply->id,
                    'message' => substr($reply->message, 0, 50) . (strlen($reply->message) > 50 ? '...' : ''),
                    'sent_at' => $reply->created_at,
                    'student_name' => $reply->agendaMessage->matricula->alumno->nombre_completo,
                    'student_photo' => url($reply->agendaMessage->matricula->alumno->foto),
                    'subjetct' => $reply->agendaMessage->subject
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'totalClasses' => 0,
                'messagesSent' => $allAgendasMessagesCount,
                'unreadReplies' => $pendingAgendasMessagesCount,
                'totalStudents' => $allMyAgendas,
            ],
            'lastUnreadReplies' => $lastFiMessageUnread
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api;

use Mpdf\Tag\A;
use App\Models\Matricula;
use App\Models\AgendaReply;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\AgendaMessage;
use App\Http\Controllers\Controller;

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

        $totalPendingAppoinements = Appointment::where('teacher_id', auth()->user()->teacher->id)
            ->where('status', 'pending')
            ->count();

        $totalEvents = \App\Models\Event::whereBetween('date', [now()->startOfDay(), now()->endOfMonth()])
            ->count();

        $hasNewEvents = \App\Models\Event::where('created_at', '>=', now()->subDay())->exists();

        // Today's attendance summary for teacher's students
        $teacherUserId = auth()->user()->id;
        $studentIds = Matricula::whereIn('id', AgendaMessage::where('teacher_user_id', $teacherUserId)->pluck('matricula_id'))
            ->where('estado', 1)
            ->pluck('alumno_id');

        $todayAttendance = [
            'total' => $studentIds->count(),
            'present' => \App\Models\Asistencia::whereIn('alumno_id', $studentIds)
                ->where('anio', now()->year)
                ->where('mes', now()->month)
                ->where('dia', now()->day)
                ->whereIn('tipo', ['N', 'T', 'TJ'])
                ->count(),
            'absent' => \App\Models\Asistencia::whereIn('alumno_id', $studentIds)
                ->where('anio', now()->year)
                ->where('mes', now()->month)
                ->where('dia', now()->day)
                ->whereIn('tipo', ['FI', 'FJ'])
                ->count(),
        ];

        $nextEvent = \App\Models\Event::where('date', '>=', now()->startOfDay())
            ->orderBy('date', 'asc')
            ->first(['description', 'date', 'time']);

        $unreadNotifications = \App\Models\PushNotification::where('user_id', auth()->user()->id)
            ->where('role', 'teacher')
            ->whereNull('read_at')
            ->count();

        return response()->json([
            'success' => true,
            'data' => [
                'totalClasses' => $totalPendingAppoinements,
                'messagesSent' => $allAgendasMessagesCount,
                'unreadReplies' => $pendingAgendasMessagesCount,
                'totalStudents' => $allMyAgendas,
                'totalEvents' => $totalEvents,
                'hasNewEvents' => $hasNewEvents,
                'todayAttendance' => $todayAttendance,
                'nextEvent' => $nextEvent,
                'unreadNotifications' => $unreadNotifications,
            ],
            'lastUnreadReplies' => $lastFiMessageUnread
        ]);
    }
}

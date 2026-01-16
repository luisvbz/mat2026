<?php

namespace App\Http\Controllers\Api;

use App\Models\Matricula;
use App\Models\AgendaReply;
use Illuminate\Http\Request;
use App\Models\AgendaMessage;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    public function getMessages(Request $request, $childId)
    {
        $padre = $request->user()->padre;

        // Verificar que el hijo pertenece al padre
        $alumno = $padre->alumnos()->findOrFail($childId);
        $matricula = $alumno->matricula->where('estado', 1)->first();

        if (!$matricula) {
            return response()->json([
                'success' => false,
                'error' => ['message' => 'No se encontró matrícula activa'],
            ], 404);
        }

        $query = AgendaMessage::where('matricula_id', $matricula->id)
            ->with(['teacherUser.teacher', 'replies']);

        // Filtros opcionales
        if ($request->has('month')) {
            $query->whereMonth('date', date('m', strtotime($request->month)));
            $query->whereYear('date', date('Y', strtotime($request->month)));
        }

        $messages = $query->orderBy('date', 'desc')->get()->map(function ($message) {
            return [
                'id' => $message->id,
                'date' => $message->date->format('Y-m-d'),
                'teacher' => $message->teacherUser->teacher->nombres . ' ' . $message->teacherUser->teacher->apellidos,
                'subject' => $message->subject,
                'preview' => substr(strip_tags($message->message), 0, 100),
                'fullText' => $message->message,
                'isRead' => $message->is_read,
                'replies' => $message->replies->map(function ($reply) {
                    return [
                        'id' => $reply->id,
                        'author' => $reply->author_type === 'parent' ? 'Padre' : 'Profesor',
                        'text' => $reply->message,
                        'isRead' => $reply->is_read,
                        'date' => $reply->created_at->toIso8601String(),
                    ];
                }),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    /**
     * Responder a mensaje (Padres)
     */
    public function replyToMessage(Request $request, $childId, $messageId)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $padre = $request->user()->padre;
        $message = AgendaMessage::findOrFail($messageId);

        // Crear respuesta
        $reply = AgendaReply::create([
            'agenda_message_id' => $messageId,
            'author_type' => 'parent',
            'author_id' => $padre->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $reply->id,
                'messageId' => $messageId,
                'author' => 'Padre',
                'message' => $reply->message,
                'date' => $reply->created_at->toIso8601String(),
            ],
        ]);
    }

    /**
     * Marcar mensaje como leído
     */
    public function markAsRead(Request $request, $childId, $messageId)
    {
        $message = AgendaMessage::findOrFail($messageId);
        $message->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Mensaje marcado como leído',
        ]);
    }

    /**
     * Escribir mensaje en agenda (Profesores)
     */

    public function getMyAgendasTeacher(Request $request)
    {
        $students = Matricula::whereIn('id', AgendaMessage::where('teacher_user_id', auth()->user()->id)->pluck('matricula_id'))
            ->where('estado', 1)
            ->with('alumno')
            ->orderBy('nivel', 'ASC')
            ->orderBy('grado', 'ASC')
            ->get()
            ->map(function ($matricula) {
                return [
                    'id' => $matricula->id,
                    'name' => $matricula->alumno->nombre_completo,
                    'photo' => url($matricula->alumno->foto),
                    'grade' => $matricula->grado,
                    'level' => $matricula->nivel,
                    'replies_unread_count' => AgendaReply::whereHas('agendaMessage', function ($query) use ($matricula) {
                        $query->where('matricula_id', $matricula->id)
                            ->where('teacher_user_id', auth()->user()->id);
                    })->where('author_type', 'parent')
                        ->where('is_read', false)
                        ->count(),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    public function writeMessage(Request $request, $studentId)
    {

        $request->validate([
            'date' => 'required|date',
            'subject' => 'required|string|max:191',
            'message' => 'required|string',
        ]);

        $teacher = auth()->user();


        $matricula = Matricula::find($studentId)
            ->where('estado', 1)
            ->firstOrFail();

        $agendaMessage = AgendaMessage::create([
            'matricula_id' => $matricula->id,
            'teacher_user_id' => $teacher->id,
            'date' => $request->date,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $agendaMessage->id,
                'message' => 'Mensaje enviado a la agenda del estudiante',
            ],
        ]);
    }
}

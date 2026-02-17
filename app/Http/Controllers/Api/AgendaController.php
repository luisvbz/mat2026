<?php

namespace App\Http\Controllers\Api;

use App\Models\Matricula;
use App\Models\AgendaReply;
use Illuminate\Http\Request;
use App\Models\AgendaMessage;
use App\Models\Player;
use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    public function getMessages(Request $request, $childId)
    {
        $padre = $request->user()->padre;

        // Verificar que el hijo pertenece al padre
        $alumno = $padre->alumnos()->findOrFail($childId);

        if (!$alumno) {
            return response()->json([
                'success' => false,
                'error' => ['message' => 'No se encontró matrícula activa'],
            ], 404);
        }

        $matricula = Matricula::where('alumno_id', $childId)->where('estado', 1)->first();

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
            $query->whereMonth('date', $request->month);
        }

        if ($request->has('year')) {
            $query->whereYear('date', $request->year);
        }

        $messages = $query->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($message) {
                return [
                    'id' => $message->id,
                    'date' => $message->date->format('Y-m-d'),
                    'teacher' => $message->teacherUser->teacher->nombres . ' ' . $message->teacherUser->teacher->apellidos,
                    'subject' => $message->subject,
                    'preview' => substr(strip_tags($message->message), 0, 100),
                    'fullText' => $message->message,
                    'isRead' => $message->is_read,
                    'time_created' => $message->created_at->format('h:i a'),
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

        $matricula = Matricula::where('id', $message->matricula_id)->where('estado', 1)->first();

        $playerIds = Player::where('user_id', $message->teacher_user_id)->pluck('player_id')->toArray();

        if (!empty($playerIds)) {
            \Log::info("PlayerIds: " . json_encode($playerIds));
            $oneSignal = new \App\Tools\OneSignalService();
           $result = $oneSignal->sendToPlayers(
                $playerIds,
                'Nueva Respuesta en Agenda',
                "Nuevo mensaje en la agenda de {$matricula->alumno->nombre_completo}.", 
                "https://app.iepdivinosalvador.net.pe/profesor/agendas/{$matricula->id}"
            );
            \Log::info("Result: " . json_encode($result));
        }

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
            ->with('alumno')
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
                    'unreadCount' => AgendaReply::whereHas('agendaMessage', function ($query) use ($matricula) {
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

    public function getAgendaByTeacher(Request $request, $studentId)
    {
        $matricula = Matricula::where('id', $studentId)
            ->where('estado', 1)
            ->firstOrFail();

        $messages = AgendaMessage::where('matricula_id', $matricula->id)
            ->where('teacher_user_id', auth()->user()->id)
            ->when($request->has('month'), function ($query) use ($request) {
                $query->whereMonth('date', $request->month);
            })
            ->with(['teacherUser.teacher', 'replies'])
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($message) {
                return [
                    'id' => $message->id,
                    'date' => $message->date->format('Y-m-d'),
                    'teacher' => $message->teacherUser->teacher->nombres . ' ' . $message->teacherUser->teacher->apellidos,
                    'subject' => $message->subject,
                    'preview' => substr(strip_tags($message->message), 0, 100),
                    'fullText' => $message->message,
                    'isRead' => $message->is_read,
                    'time_created' => $message->created_at->format('h:i a'),
                    'replies' => $message->replies->map(function ($reply) {
                        return [
                            'id' => $reply->id,
                            'author' => $reply->author_type === 'parent' ? 'Padre' : 'Profesor',
                            'text' => $reply->message,
                            'isRead' => $reply->is_read,
                            'readAt' => $reply->read_at ? $reply->read_at->toIso8601String() : null,
                            'date' => $reply->created_at->toIso8601String(),
                        ];
                    }),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $messages,
            'student' => [
                'id' => $matricula->alumno->id,
                'name' => $matricula->alumno->nombre_completo,
                'photo' => url($matricula->alumno->foto),
                'grade' => $matricula->grado,
                'level' => $matricula->nivel,
            ],
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

        $matricula = Matricula::where('id', $studentId)
            ->with('alumno', 'alumno.padres')
            ->where('estado', 1)
            ->firstOrFail();

        $agendaMessage = AgendaMessage::create([
            'matricula_id' => $matricula->id,
            'teacher_user_id' => $teacher->id,
            'date' => $request->date,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        $padresId = $matricula->alumno->padres->pluck('user_id')->toArray();

        $playerIds = Player::whereIn('user_id', $padresId)
                            ->where('role', 'parent')
                            ->pluck('player_id')->toArray();

        if (!empty($playerIds)) {
            $oneSignal = new \App\Tools\OneSignalService();
            $oneSignal->sendToPlayers(
                $playerIds,
                'Nuevo mensaje en agenda',
                "El profesor/a {$teacher->teacher->nombre_completo} ha escrito un mensaje en la agenda del estudiante {$matricula->alumno->nombre_completo}.", 
                "https://app.iepdivinosalvador.net.pe/agenda/{$matricula->alumno->id}"
            );
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $agendaMessage->id,
                'message' => 'Mensaje enviado a la agenda del estudiante',
            ],
        ]);
    }

    public function markMessageAsRead(Request $request, $messageId)
    {
        $message = AgendaMessage::findOrFail($messageId);

        $message->replies()
            ->where('author_type', 'parent')
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return response()->json(['success' => true]);
    }
}

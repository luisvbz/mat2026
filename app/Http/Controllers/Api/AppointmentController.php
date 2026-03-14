<?php

namespace App\Http\Controllers\Api;

use App\Models\Matricula;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AppointmentController extends Controller
{
    public function parentIndex(Request $request)
    {
        $padre = $request->user()->padre;

        $query = Appointment::where('parent_id', $padre->id)
            ->with(['teacher', 'student']);
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        $appointments = $query->orderBy('date', 'desc')->get()->map(function ($apt) {
            return [
                'id' => $apt->id,
                'type' => $apt->type,
                'status' => $apt->status,
                'teacherId' => $apt->teacher_id,
                'teacherName' => $apt->teacher->nombres . ' ' . $apt->teacher->apellidos,
                'studentId' => $apt->student_id,
                'studentName' => $apt->student->nombres . ' ' . $apt->student->apellido_paterno,
                'date' => $apt->date ? $apt->date->format('Y-m-d') : null,
                'time' => $apt->time ? $apt->time->format('H:i') : null,
                'duration' => $apt->duration,
                'subject' => $apt->subject,
                'notes' => $apt->notes,
                'location' => $apt->location,
                'createdAt' => $apt->created_at->toIso8601String(),
                'createdBy' => $apt->created_by,
            ];
        });
        return response()->json([
            'success' => true,
            'data' => $appointments,
        ]);
    }
    /**
     * Solicitar cita (Padres)
     */
    public function parentStore(Request $request)
    {
        $request->validate([
            'studentId' => 'required|exists:alumnos,id',
            'teacherId' => 'required|exists:teachers,id',
            'subject' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $padre = $request->user()->padre;

        $pendingAppointments = Appointment::where('parent_id', $padre->id)
            ->where('status', 'pending')
            ->exists();

        if ($pendingAppointments) {
            return response()->json([
                'success' => false,
                'message' => 'No puedes crear nuevas citas mientras tengas citas pendientes',
            ], 422);
        }
        $appointment = Appointment::create([
            'type' => 'parent_request',
            'status' => 'pending',
            'parent_id' => $padre->id,
            'teacher_id' => $request->teacherId,
            'student_id' => $request->studentId,
            'date' => $request->date,
            'time' => $request->time,
            'subject' => $request->subject,
            'notes' => $request->notes,
            'created_by' => 'parent',
        ]);

        $teacherEmail = $appointment->teacher->user->email ?? 'ing.luisvasquez89@gmail.com';
        Mail::to($teacherEmail)->queue(new \App\Mail\NuevaCitaDocente($appointment));

        // Enviar notificación background job
        $teacherUser = $appointment->teacher->user;
        if ($teacherUser) {
            \App\Jobs\SendPushNotificationJob::dispatch(
                [$teacherUser->id],
                'teacher',
                'Nueva Solicitud de Cita',
                "{$padre->nombres} {$padre->apellidos} ha solicitado una cita para el alumno {$appointment->student->nombres}.",
                "https://app.iepdivinosalvador.net.pe/profesor/citas"
            );
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $appointment->id,
                'status' => 'pending',
                'message' => 'Solicitud enviada al profesor',
            ],
        ]);
    }
    /**
     * Confirmar cita (Padres)
     */
    public function parentConfirm($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->confirm();
        return response()->json([
            'success' => true,
            'message' => 'Cita confirmada',
        ]);
    }
    /**
     * Rechazar cita (Padres)
     */
    public function parentReject(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->reject();
        return response()->json([
            'success' => true,
            'message' => 'Cita rechazada',
        ]);
    }
    /**
     * Listar citas (Profesores)
     */
    public function teacherIndex(Request $request)
    {
        $teacher = $request->user()->teacher;

        $query = Appointment::where('teacher_id', $teacher->id)
            ->with(['parent', 'student']);
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        $appointments = $query->orderBy('date', 'desc')->get()->map(function ($apt) {
            return [
                'id' => $apt->id,
                'type' => $apt->type,
                'status' => $apt->status,
                'parentId' => $apt->parent_id,
                'parentName' => $apt->parent->nombres . ' ' . $apt->parent->apellidos,
                'studentId' => $apt->student_id,
                'studentName' => $apt->student->nombres . ' ' . $apt->student->apellido_paterno,
                'date' => $apt->date ? $apt->date->format('Y-m-d') : null,
                'time' => $apt->time ? $apt->time->format('H:i') : null,
                'duration' => $apt->duration,
                'subject' => $apt->subject,
                'notes' => $apt->notes,
                'location' => $apt->location,
                'createdAt' => $apt->created_at->toIso8601String(),
                'createdBy' => $apt->created_by,
            ];
        });
        return response()->json([
            'success' => true,
            'data' => $appointments,
        ]);
    }
    /**
     * Crear cita (Profesores)
     */
    public function teacherStore(Request $request)
    {
        $request->validate([
            'studentId' => 'required|exists:matriculas,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'subject' => 'required|string',
            'notes' => 'nullable|string',
            'location' => 'nullable|string',
        ]);
        $teacher = $request->user()->teacher;

        // Obtener padre del estudiante
        $matricula = Matricula::where('id', $request->studentId)
            ->where('estado', 1)
            ->firstOrFail();

        $alumno = $matricula->alumno;
        $padre = $alumno->padres()->first();
        $appointment = Appointment::create([
            'type' => 'teacher_invite',
            'status' => 'pending',
            'parent_id' => $padre->id,
            'teacher_id' => $teacher->id,
            'student_id' => $alumno->id,
            'date' => $request->date,
            'time' => $request->time,
            'subject' => $request->subject,
            'notes' => $request->notes,
            'location' => $request->location,
            'created_by' => 'teacher',
        ]);
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $appointment->id,
                'status' => 'pending',
                'message' => 'Invitación enviada al padre',
            ],
        ]);
    }
    /**
     * Confirmar cita (Profesores)
     */
    public function teacherConfirm(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date',
            'time' => 'required',
        ]);
        $appointment = Appointment::findOrFail($id);
        $teacher = $request->user()->teacher;

        $exists = Appointment::where('teacher_id', $teacher->id)
            ->where('id', '!=', $id)
            ->where('status', 'confirmed')
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes una cita confirmada en este horario.',
            ], 422);
        }
        $appointment->update([
            'status' => 'confirmed',
            'date' => $request->date,
            'time' => $request->time,
        ]);

        $parentEmail = $appointment->parent->user->email ?? null;
        if ($parentEmail) {
            Mail::to($parentEmail)->queue(new \App\Mail\ConfirmacionCitaPadre($appointment));
        }

        $parentUser = $appointment->parent->user;
        if ($parentUser) {
            \App\Jobs\SendPushNotificationJob::dispatch(
                [$parentUser->id],
                'parent',
                'Cita Confirmada',
                "El profesor {$teacher->nombres} {$teacher->apellidos} ha confirmado la cita para el alumno {$appointment->student->nombres}. Toque para ver los detalles",
                "https://app.iepdivinosalvador.net.pe/citas"
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Cita confirmada',
        ]);
    }
    /**
     * Completar cita (Profesores)
     */
    public function teacherComplete($id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->complete();

        return response()->json([
            'success' => true,
            'message' => 'Cita marcada como completada',
        ]);
    }

    /**
     * Crear cita directa y confirmada (Profesores)
     */
    public function teacherCreateDirect(Request $request)
    {
        $request->validate([
            'parentId' => 'required|exists:padres,id',
            'date' => 'required|date',
            'time' => 'required',
            'subject' => 'required|string',
            'notes' => 'nullable|string',
            'location' => 'nullable|string',
        ]);

        $teacher = $request->user()->teacher;
        // Verificar que el padre pertenece al estudiante
        $matricula = Matricula::where('id', $request->studentId)
            ->where('estado', 1)
            ->firstOrFail();

        $alumno = $matricula->alumno;
        $padre = $alumno->padres()->findOrFail($request->parentId);

        // Verificar conflicto de horario
        $exists = Appointment::where('teacher_id', $teacher->id)
            ->where('status', 'confirmed')
            ->where('date', $request->date)
            ->where('time', $request->time)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Ya tienes una cita confirmada en este horario.',
            ], 422);
        }

        $appointment = Appointment::create([
            'type' => 'teacher_invite',
            'status' => 'confirmed',
            'parent_id' => $padre->id,
            'teacher_id' => $teacher->id,
            'student_id' => $alumno->id,
            'date' => $request->date,
            'time' => $request->time,
            'subject' => $request->subject,
            'notes' => $request->notes,
            'created_by' => 'teacher',
        ]);

        // Enviar notificación al padre por email
        $parentEmail = $padre->user->email ?? null;
        if ($parentEmail) {
            Mail::to($parentEmail)->queue(new \App\Mail\ConfirmacionCitaPadre($appointment));
        }

        if ($padre->user) {
            \App\Jobs\SendPushNotificationJob::dispatch(
                [$padre->user->id],
                'parent',
                'Cita Agendada',
                "El profesor/a {$teacher->nombres} {$teacher->apellidos} ha agendado una cita para el alumno {$alumno->nombre_completo}.",
                "https://app.iepdivinosalvador.net.pe/citas"
            );
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $appointment->id,
                'status' => 'confirmed',
                'message' => 'Cita agendada correctamente',
            ],
        ]);
    }
}

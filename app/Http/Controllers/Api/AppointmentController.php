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

        Mail::to("ing.luisvasquez89@gmacil.com")->queue(new \App\Mail\NuevaCitaDocente($appointment));

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
            'studentId' => 'required|exists:alumnos,id',
            'date' => 'required|date|after:today',
            'time' => 'required',
            'subject' => 'required|string',
            'notes' => 'nullable|string',
            'location' => 'nullable|string',
        ]);
        $teacher = $request->user()->teacher;

        // Obtener padre del estudiante
        $matricula = Matricula::where('alumno_id', $request->studentId)
            ->where('estado', 1)
            ->firstOrFail();

        $alumno = $matricula->alumno;
        $padre = $alumno->padres()->first();
        $appointment = Appointment::create([
            'type' => 'teacher_invite',
            'status' => 'pending',
            'parent_id' => $padre->id,
            'teacher_id' => $teacher->id,
            'student_id' => $request->studentId,
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
        return response()->json([
            'success' => true,
            'message' => 'Cita confirmada',
        ]);
    }
    /**
     * Rechazar cita (Profesores)
     */
    public function teacherReject(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        $appointment->reject();
        return response()->json([
            'success' => true,
            'message' => 'Solicitud rechazada',
        ]);
    }
}

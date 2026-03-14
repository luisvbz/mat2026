<?php

namespace App\Http\Controllers\Api;

use App\Models\Grado;
use App\Http\Controllers\Controller;
use App\Models\Matricula;
use App\Models\TeacherUser;

class CommonController extends Controller
{
    public function getGrades($level)
    {
        $grades = Grado::where('nivel', $level)->orderBy('numero', 'ASC')->get();

        return response()->json([
            'success' => true,
            'data' => $grades
        ]);
    }

    public function getTeacherUsers()
    {
        $teachers = TeacherUser::with('teacher')
            ->where('is_active', true)
            ->get()
            ->map(function ($teachers) {
                return [
                    'id' => $teachers->teacher->id,
                    'name' => $teachers->teacher->nombres . ' ' . $teachers->teacher->apellidos,
                    'email' => $teachers->email,
                    'photo' => $teachers->teacher->foto,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $teachers
        ]);
    }

    public function getStudentsByGrade($gradeId)
    {
        $grade = Grado::find($gradeId);
        if (!$grade) {
            return response()->json([
                'success' => false,
                'error' => ['message' => "El grado no existe."]
            ], 422);
        }

        $students = Matricula::where('nivel', $grade->nivel)->where('grado', $grade->numero)
            ->where('estado', 1)
            ->with('alumno')
            ->get()
            ->map(function ($matricula) {
                return [
                    'id' => $matricula->id,
                    'name' => $matricula->alumno->nombre_completo,
                    'photo' => url($matricula->alumno->foto),
                    'grade' => $matricula->grado,
                    'level' => $matricula->nivel,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $students
        ]);
    }

    public function getParentsByStudent($studentId)
    {
        // Find the matricula (enrollment record)
        $matricula = Matricula::find($studentId);

        if (!$matricula) {
            return response()->json([
                'success' => false,
                'error' => ['message' => 'El estudiante no existe.']
            ], 422);
        }

        // Get the student and their parents
        $alumno = $matricula->alumno;
        $padres = $alumno->padres()->whereHas('user', function ($query) {
            $query->where('is_active', true);
        })->get()->map(function ($padre) {
            return [
                'id' => $padre->id,
                'name' => $padre->nombres . ' ' . $padre->apellidos,
                'email' => $padre->user->email ?? null,
                'phone' => $padre->telefono ?? null,
                'relation' => $padre->pivot->relacion ?? 'Padre/Madre'
            ];
        });

        if ($padres->isEmpty()) {
            return response()->json([
                'success' => false,
                'error' => ['message' => 'Este estudiante no tiene padres registrados.']
            ], 422);
        }

        return response()->json([
            'success' => true,
            'data' => $padres
        ]);
    }
}

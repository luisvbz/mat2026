<?php

namespace App\Http\Controllers\Api;

use App\Models\Grado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Matricula;

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
}
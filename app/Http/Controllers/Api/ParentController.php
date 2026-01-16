<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function children(Request $request)
    {
        $padre = $request->user()->padre;

        $children = $padre->alumnos()
            ->with('matricula')
            ->get()
            ->map(function ($alumno) {
                $matricula = $alumno->matricula->where('estado', 1)->first();
                return [
                    'id' => $alumno->id,
                    'name' => $alumno->nombres . ' ' . $alumno->apellido_paterno . ' ' . $alumno->apellido_materno,
                    'grade' => $matricula->grado ?? null,
                    'level' => $matricula->nivel ?? null,
                    'academicYear' => $matricula->anio ?? null,
                    'age' => $alumno->edad,
                    'photo' => url($alumno->foto),
                    'accountBalance' => 0,
                    'pendingPayments' => 0,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $children,
        ]);
    }
}

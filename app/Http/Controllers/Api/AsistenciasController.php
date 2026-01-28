<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asistencia;

class AsistenciasController extends Controller
{
    public function getAttendanceByChild(Request $request, $childId)
    {

        $padre = $request->user()->padre;
        $alumno = $padre->alumnos()->findOrFail($childId);


        $asistencias = Asistencia::where('alumno_id', $alumno->id)
            ->orderBy('dia', 'desc')
            ->where('anio', $request->get('year', date('Y')))
            ->where('mes', $request->get('month', date('m')))
            ->get()
            ->mapWithKeys(function ($asistencia) {
                $estadoMap = [
                    'N' => 'present',
                    'T' => 'late',
                    'F' => 'virtual',
                    'FI' => 'absent',
                    'FJ' => 'justified',
                ];

                $data = [
                    'status' => $estadoMap[$asistencia->tipo] ?? 'present',
                    'note' => null,
                ];

                if ($asistencia->tipo === 'F') {
                    $data['note'] = $asistencia->feriado->descripcion ?? 'Feriado';
                }

                $data['entryTime'] = date('h:i a', strtotime($asistencia->entrada)) ?? null;
                $data['exitTime'] = date('h:i a', strtotime($asistencia->salida)) ?? null;
                $data['exitNote'] = $asistencia->comentario_salida ?? null;


                return [$asistencia->dia => $data];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'attendances' => $asistencias,
                'stats' => [
                    'present' => $asistencias->filter(fn($item) => $item['status'] === 'present')->count(),
                    'absent' => $asistencias->filter(fn($item) => $item['status'] === 'absent')->count(),
                    'justified' => $asistencias->filter(fn($item) => $item['status'] === 'justified')->count(),
                ]
            ],
        ]);
    }
}

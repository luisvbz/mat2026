<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Teacher;
use App\Models\Matricula;
use App\Models\Asistencia;
use Illuminate\Http\Request;
use App\Tools\AsistenciaAlumno;
use App\Tools\AsistenciaProfesor;
use Illuminate\Support\Facades\Log;
use App\Models\AsistenciaProfesor as AsisP;

class AsistenciaController extends Controller
{
    public function handShake(Request $request)
    {
        return "OK";
    }

    public function cdata(Request $request)
    {
        $content = $request->getContent();
        $lineas = explode("\n", trim($content));
        foreach ($lineas as $linea) {
            $datos = explode("\t", trim($linea));

            if (count($datos) >= 2) {
                $usuarioId = trim($datos[0]);
                $fechaHora = $datos[1];
                list($fecha, $hora) = explode(" ", trim($fechaHora));
                $this->proccessAttendance($usuarioId, $fecha, $hora);
            }
        }

        return response("OK")->header('Content-Type', 'text/plain');
    }


    private function proccessAttendance($usuarioId, $fecha, $hora)
    {
        if (strlen($usuarioId) < 8) {
            $usuarioId = str_pad($usuarioId, 9, '0', STR_PAD_LEFT);
        }

        $alumno = Alumno::where('numero_documento', $usuarioId)->first();

        if (!$alumno) {
            $this->procesarProfesor($usuarioId, $fecha, $hora);
        } else {
            $this->procesarAlumno($alumno, $fecha, $hora);
        }
    }

    private function procesarProfesor($usuarioId, $fecha, $hora)
    {
        $profesor = Teacher::where('documento', $usuarioId)->first();

        if (!$profesor) {
            Log::warning("Documento no encontrado en alumnos ni profesores: {$usuarioId}");
            return;
        }

        Log::info("Intento de marcación para profesor {$usuarioId}", [
            'fecha' => $fecha,
            'hora'  => $hora
        ]);

        $this->marcarEntradaSalidaPersonal($profesor, $fecha, $hora);
    }

    private function procesarAlumno($alumno, $fecha, $hora)
    {
        $matricula = Matricula::where('alumno_id', $alumno->id)
            ->where('estado', 1)
            ->first();

        if (!$matricula) {
            Log::warning("Alumno {$alumno->id} sin matrícula activa");
            return;
        }

        $marcacion = Asistencia::where('alumno_id', $alumno->id)
            ->where('dia', $fecha)
            ->first();

        // Ya tiene entrada y salida - no hacer nada
        if ($marcacion && $marcacion->entrada !== null && $marcacion->salida !== null) {
            return;
        }

        // Sin registro o le falta entrada/salida - marcar
        $asistencia = new AsistenciaAlumno(
            $alumno,
            $fecha,
            $matricula->hora_entrada,
            $matricula->hora_salida,
            $hora
        );
        $asistencia->setMarcacion();
    }

    private function marcarEntradaSalidaPersonal($profesor, $fecha, $hora)
    {
        $ap = AsisP::where('teacher_id', $profesor->id)
            ->where('dia', $fecha)
            ->first();


        if (!$ap) {
            $asistencia = new AsistenciaProfesor($profesor, $fecha, $hora);
            $asistencia->setMarcacion();
            return;
        }

        if ($ap->entrada !== null && $ap->salida !== null) {
            return;
        }

        $asistencia = new AsistenciaProfesor($profesor, $fecha, $hora);
        $asistencia->setMarcacion();
    }
}
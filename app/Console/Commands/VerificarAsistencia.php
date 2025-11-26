<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Matricula;
use App\Models\Asistencia;
use App\Models\PermisoAlumno;
use Illuminate\Console\Command;
use App\Models\AsistenciaFeriado;


class VerificarAsistencia extends Command
{
    protected $signature = 'asistencia:verificar';
    protected $description = 'Verifica asistencia de los estudiantes y actualiza registros';

    public function handle()
    {
        $fechaHoy = Carbon::now()->format('Y-m-d');

        // Verificar solo de lunes a viernes
        if (in_array(Carbon::now()->dayOfWeek, [Carbon::SATURDAY, Carbon::SUNDAY])) {
            $this->info('Hoy no es un día hábil para marcar asistencia.');
            return;
        }

        // Obtener alumnos con matrícula activa

        $alumnos = Matricula::where('estado', 1)->with('alumno')->get();


        foreach ($alumnos as $matricula) {

            $alumno = $matricula->alumno;
            if (is_null($alumno)) continue;
            $asistencia = Asistencia::where('alumno_id', $alumno->id)->where('dia', $fechaHoy)->first();

            if ($asistencia && $asistencia->tipo != Asistencia::FALTA_JUSTIFICADA) {
                if ($asistencia->entrada && !$asistencia->salida) {
                    // Marcar salida automática
                    $asistencia->update([
                        'salida' => $fechaHoy . ' ' . $matricula->hora_salida,
                        'comentario_salida' => 'Salida marcada por el sistema',
                    ]);
                    $this->info("Salida marcada para: {$alumno->nombre}");
                }
            } else {
                // Registrar falta injustificada
                if (AsistenciaFeriado::where('fecha_feriado', $fechaHoy)->exists()) {
                    Asistencia::create([
                        'alumno_id' => $alumno->id,
                        'tipo' => Asistencia::FERIADO,
                        'anio' => Carbon::now()->year,
                        'mes' => Carbon::now()->month,
                        'dia' => $fechaHoy,
                    ]);
                } else {

                    $permiso =  PermisoAlumno::where('alumno_id', $alumno->id)->where('tipo', 'SS')
                        ->whereDate('desde', '>=', $fechaHoy)
                        ->whereDate('hasta', '<=', $fechaHoy)
                        ->first();

                    if ($permiso) {
                        Asistencia::create([
                            'alumno_id' => $alumno->id,
                            'tipo' => Asistencia::FALTA_JUSTIFICADA,
                            'anio' => Carbon::now()->year,
                            'mes' => Carbon::now()->month,
                            'permiso_id' => $permiso->id,
                            'dia' => $fechaHoy,
                        ]);
                    } else {

                        Asistencia::create([
                            'alumno_id' => $alumno->id,
                            'tipo' => Asistencia::FALTA_INJUSTIFICADA,
                            'anio' => Carbon::now()->year,
                            'mes' => Carbon::now()->month,
                            'dia' => $fechaHoy,
                        ]);
                    }
                }
                $this->info("Falta injustificada registrada para: {$alumno->nombre}");
            }
        }

        $this->info('Proceso de verificación de asistencia completado.');
    }
}

<?php

namespace App\Console\Commands;

use App\Models\AsistenciaProfesor as Asistencia;
use Carbon\Carbon;
use App\Models\Teacher;
use App\Tools\AsistenciaProfesor;
use Illuminate\Console\Command;

class VerificarAsistenciaPersonal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'verificar:asistencia-profesores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


    public function handle()
    {
        $fechaHoy = Carbon::now()->format('Y-m-d');

        $profesores = Teacher::where('estado', true)->get();

        foreach ($profesores as $p) {
            $asistencia = $p->asistencias()->where('dia', $fechaHoy)->first();
            if ($asistencia && in_array($asistencia->tipo, [Asistencia::NORMAL, Asistencia::TARDANZA])) {
                $diaDesdeHorario = $p->horario->dias->where('day_number', Carbon::now()->format('N'))->first();
                if ($asistencia->salida == null) {
                    Asistencia::where('teacher_id', $p->id)
                        ->where('dia', $fechaHoy)
                        ->update([
                            'salida' => $fechaHoy . ' ' . $diaDesdeHorario->end_time,
                            'comentario_salida' => 'Marcada por Sistema'
                        ]);
                }
            } else {
                $a = new AsistenciaProfesor($p, $fechaHoy);
                $a->setMarcacion(true);
            }
        }
    }
}

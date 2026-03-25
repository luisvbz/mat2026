<?php

namespace App\Http\Livewire\Dashboard\Asistencias\Personal\Asistencias;

use Carbon\Carbon;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\AsistenciaProfesor;
use PDF;

class Lista extends Component
{

    public $date = '';
    public $mes;
    public $anio;
    public $meses;

    public function mount()
    {
        $this->date = date('Y-m-d');
        $this->mes = (int) date('m');
        $this->anio = 2026;
        $this->setMeses();
    }

    public function setMeses()
    {
        // Los meses del año escolar (marzo a diciembre)
        $meses = [
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        $mes_actual = (int) date('m');

        // Solo habilitar los meses desde marzo hasta el mes actual
        foreach ($meses as $numero => $nombre) {
            if ($numero >= 2 && $numero <= $mes_actual) {
                $this->meses[] = ['numero' => $numero, 'nombre' => $nombre];
            }
        }

        // Establecer el mes por defecto como el actual
        $this->mes = $mes_actual;
    }

    public function generarReporte()
    {
        $meses = [
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];


        $profes = Teacher::orderBy('apellidos', 'ASC')
            ->with(['asistencias' => function ($q) {
                $q->where('mes', $this->mes);
            }])
            ->get()
            ->map(function ($profe) {
                // Contar tardanzas
                $profe->total_tardanzas = $profe->asistencias->where('tipo', 'T')->count();

                // Sumar el total de tardanzas en formato HH:MM:SS
                $profe->total_tiempo_tardanza = $profe->asistencias
                    ->where('tipo', 'T')
                    ->sum(function ($asistencia) {
                        return strtotime($asistencia->tardanza_entrada) - strtotime('00:00:00');
                    });


                $profe->total_tiempo_tardanza = gmdate("H:i:s", $profe->total_tiempo_tardanza);

                return $profe;
            });

        $pdf = PDF::loadView('pdfs.asistencia-profesores', ['profes' => $profes, 'mes' => $meses[$this->mes]]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "asistencia-personal-{$this->mes}.pdf");
    }

    public function render()
    {
        $dia =  Carbon::createFromFormat('Y-m-d', $this->date);
        $profesores = Teacher::orderBy('apellidos', 'ASC')
            ->orderBy('nombres', 'ASC')
            ->where('estado', 1)
            ->get()
            ->transform(function ($t) use ($dia) {
                if (is_null($t->horario)) {
                    $t->tipo = AsistenciaProfesor::NO_LABORABLE;
                } else {
                    $diaTrabajo = $t->horario->dias->where('day_number', $dia->format('N'))->first();
                    $t->asistencia = null;
                    $t->tipo = null;
                    if (is_null($diaTrabajo)) {
                        $t->tipo = AsistenciaProfesor::NO_LABORABLE;
                    } else {
                        if ($diaTrabajo && $diaTrabajo->active) {
                            $asistencia = $t->asistencias()->where('dia', $this->date)->first();
                            if ($asistencia) {
                                $t->asistencia = $asistencia;
                                $t->tipo = $asistencia->tipo;
                            } else {
                                $t->tipo = AsistenciaProfesor::FALTA_INJUSTIFICADA;
                            }
                        } else {
                            $t->tipo = AsistenciaProfesor::NO_LABORABLE;
                        }
                    }
                }
                return $t;
            });

        return view('livewire.dashboard.asistencias.personal.asistencias.lista', ['profesores' => $profesores])
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

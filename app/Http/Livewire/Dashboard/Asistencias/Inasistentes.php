<?php

namespace App\Http\Livewire\Dashboard\Asistencias;

use App\Models\Grado;
use Livewire\Component;
use App\Models\Matricula;
use App\Models\Asistencia;
use App\Tools\AsistenciaAlumno;

class Inasistentes extends Component
{
    public $date;
    public $grado = '';
    public $nivel = '';
    public $grados = [];

    protected $listeners = [
        'marcar:asistencia' => 'marcarAsistencia',
        'marcar:asistencia-todos' => 'marcarAsistenciaTodos',
    ];

    public function mount()
    {
        $this->date = date('Y-m-d');
    }



    public function updatedNivel()
    {

        $this->grados = Grado::where('nivel', $this->nivel)
            ->orderBy('numero')
            ->get();
    }

    public function showDialogMarcarAsistencia($id, $actual = false)
    {
        $mensaje = $actual ? 'Esta acción marcara la entrada del estudiante con la hora actual' : 'Esta acción marcara la entrada del estudiante con la hora registrada en su matricula';
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => $mensaje,
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'marcar:asistencia',
            'params'      => [$id, $actual], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function showDialogMarcaTodos()
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta acción marcara la entrada de todos en la lista",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'marcar:asistencia-todos',
        ]);
    }

    public function marcarAsistencia($params)
    {
        $mat = Matricula::find($params[0]);
        $actual = $params[1];

        if (!$actual) {
            $tipo = Asistencia::NORMAL;
            Asistencia::updateOrCreate(
                [
                    'dia' => $this->date,
                    'alumno_id' => $mat->alumno_id
                ],
                [
                    'tipo'            => $tipo,
                    'anio'            => date('Y'),
                    'mes'             => (int) date('m'),
                    'dia'             => $this->date,
                    'entrada'         => $this->date . ' ' . $mat->hora_entrada,
                ]
            );

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "Se ha registrado con exito",
            ]);

            $this->render();
        } else {
            $asistencia = new AsistenciaAlumno(
                $mat->alumno,
                date('Y-m-d'),
                $mat->hora_entrada,
                $mat->hora_salida
            );
            $asistencia->setMarcacion();

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "Se ha registrado con exito",
            ]);

            $this->render();
        }
    }

    public function marcarAsistenciaTodos()
    {
        $matriculas = Matricula::with(['alumno'])
            ->where('estado', 1)
            ->whereNotIn('alumno_id', Asistencia::where('dia', $this->date)->get()->pluck('alumno_id')->toArray())
            ->whereHas('alumno')
            ->when($this->nivel != '', function ($q) {
                $q->where('nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('nivel', $this->grado);
            })
            ->get();

        foreach ($matriculas as $mat) {
            $tipo = Asistencia::NORMAL;
            Asistencia::updateOrCreate(
                [
                    'dia' => $this->date,
                    'alumno_id' => $mat->alumno_id
                ],
                [
                    'tipo'            => $tipo,
                    'anio'            => date('Y'),
                    'mes'             => (int) date('m'),
                    'dia'             => $this->date,
                    'entrada'         => $this->date . ' ' . $mat->hora_entrada,
                ]
            );
        }


        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "Se ha registrado con exito",
        ]);

        $this->render();
    }

    public function render()
    {
            
            $inasistentes = Matricula::with(['alumno'])
            ->join('alumnos', 'matriculas.alumno_id', '=', 'alumnos.id')
            ->where('matriculas.estado', 1)
            ->whereNotIn('matriculas.alumno_id', Asistencia::where('dia', $this->date)->get()->pluck('alumno_id')->toArray())
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas.grado', $this->grado);
            })
            ->orderBy('matriculas.nivel')
            ->orderBy('matriculas.grado')
            ->orderBy('alumnos.apellido_paterno')
            ->orderBy('alumnos.apellido_materno')
            ->orderBy('alumnos.nombres')
            ->select('matriculas.*')
            ->get();

        return view('livewire.dashboard.asistencias.inasistentes', ['inasistentes' => $inasistentes])
            ->extends('layouts.panel')
            ->section('content');
    }
}

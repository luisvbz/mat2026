<?php

namespace App\Http\Livewire\Asistencia;

use App\Models\Alumno;
use App\Models\Teacher;
use Livewire\Component;
use App\Models\Matricula;
use App\Models\Asistencia;
use App\Models\AsistenciaProfesor as AsisP;
use App\Models\EntradaToken;
use App\Tools\AsistenciaAlumno;
use App\Tools\AsistenciaProfesor;

class Index extends Component
{
    public $dni = '';
    public $marcacion;
    public $alumno;
    public $matricula;
    public $profesor;

    protected $listeners = ['reiniciar' => 'resetPage'];

    public function mount($token)
    {
        if (!EntradaToken::where('token', $token)->first()) abort(404);
    }

    public function resetPage()
    {
        $this->reset(['matricula', 'profesor', 'marcacion', 'dni', 'alumno']);
    }

    public function marcarAsistencia()
    {
        $text = $this->dni;
        $clean_text = preg_replace('/[^\p{L}\p{N}\s]/u', '', $text);


        $this->alumno = Alumno::where('numero_documento', $clean_text)->first();

        if (!$this->alumno) {

            $this->profesor = Teacher::where('documento', $clean_text)->first();

            if ($this->profesor) {
                $this->reset(['matricula']);
                $this->marcarEntradaSalidaPersonal();
                $this->reset('dni');
                $this->emit('resetPage');

                return;
            }

            session()->flash('error', 'Alumno no encontrado.');
            return;
        }


        $this->matricula = Matricula::where('alumno_id', $this->alumno->id)->where('estado', 1)->first();

        if (!$this->matricula) {

            session()->flash('error', 'El alumno no tiene matrícula activa.');
            return;
        }

        $this->reset('profesor');


        $this->loadMarcacion();


        if (!$this->marcacion) {
            $this->registrarAsistencia();
        } else {

            if ($this->marcacion->entrada != null && $this->marcacion->salida == null) {
                $this->registrarAsistencia();
            }
        }


        $this->reset('dni');
        $this->emit('resetPage');
    }

    private function loadMarcacionProfesor()
    {

        $this->marcacion = AsisP::where('teacher_id', $this->profesor->id)
            ->where('dia', date('Y-m-d'))
            ->first();
    }

    private function marcarEntradaSalidaPersonal()
    {

        $ap = AsisP::where('teacher_id', $this->profesor->id)
            ->where('dia', date('Y-m-d'))
            ->exists();

        $horaActual = date('H:i');
        $horaLimite = '13:00';

        if ($horaActual > $horaLimite && !$ap) {
            session()->flash('error', 'No puedes marcar entrada después de la 1:00 p.m.');
            return;
        }

        $asistencia = new AsistenciaProfesor(
            $this->profesor,
            date('Y-m-d')
        );
        $asistencia->setMarcacion();
        $this->loadMarcacionProfesor();
    }

    private function registrarAsistencia()
    {

        $asistencia = new AsistenciaAlumno(
            $this->alumno,
            date('Y-m-d'),
            $this->matricula->hora_entrada,
            $this->matricula->hora_salida
        );
        $asistencia->setMarcacion();
        $this->loadMarcacion();
    }

    private function loadMarcacion()
    {

        $this->marcacion = Asistencia::where('alumno_id', $this->alumno->id)
            ->where('dia', date('Y-m-d'))
            ->first();
    }

    public function render()
    {
        return view('livewire.asistencia.index');
    }
}

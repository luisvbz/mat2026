<?php

namespace App\Http\Livewire\Dashboard\Profesores;

use App\Models\Teacher;
use App\Models\Appointment;
use App\Models\AgendaMessage;
use Livewire\Component;

class Detalle extends Component
{
    public $teacher;
    public $activeTab = 'info';

    // Filters for activity tabs
    public $filterNivel = '';
    public $filterGrado = '';
    public $filterFecha = '';

    // Modal state
    public $showAgendaModal = false;
    public $selectedAgenda = null;

    public function mount($id)
    {
        $this->teacher = Teacher::with(['horario', 'user'])->findOrFail($id);
    }

    public function openAgendaModal($id)
    {
        $this->selectedAgenda = \App\Models\AgendaMessage::with(['matricula.alumno', 'replies.agendaMessage.teacherUser.teacher'])->findOrFail($id);
        $this->showAgendaModal = true;
    }

    public function closeAgendaModal()
    {
        $this->showAgendaModal = false;
        $this->selectedAgenda = null;
    }

    public function crearUsuario()
    {
        if ($this->teacher->user) {
            session()->flash('error', 'El profesor ya tiene un usuario asociado.');
            return;
        }

        \App\Models\TeacherUser::create([
            'teacher_id' => $this->teacher->id,
            'document_number' => $this->teacher->documento,
            'password' => \Illuminate\Support\Facades\Hash::make($this->teacher->documento),
            'is_active' => true,
        ]);

        $this->teacher->load('user');
        session()->flash('success', 'Usuario creado exitosamente con el DNI como clave.');
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->reset(['filterNivel', 'filterGrado', 'filterFecha']);
    }

    public function render()
    {
        $appointments = [];
        $messages = [];

        if ($this->activeTab === 'appointments') {
            $appointments = Appointment::where('teacher_id', $this->teacher->id)
                ->when($this->filterFecha != '', function ($q) {
                    $q->whereDate('date', $this->filterFecha);
                })
                ->when($this->filterNivel != '' || $this->filterGrado != '', function ($q) {
                    $q->whereHas('student.matricula', function ($mq) {
                        if ($this->filterNivel != '') $mq->where('nivel', $this->filterNivel);
                        if ($this->filterGrado != '') $mq->where('grado', $this->filterGrado);
                    });
                })
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get();
        }

        if ($this->activeTab === 'messages') {
            if ($this->teacher->user) {
                $messages = AgendaMessage::where('teacher_user_id', $this->teacher->user->id)
                    ->with('matricula.alumno')
                    ->when($this->filterFecha != '', function ($q) {
                        $q->whereDate('date', $this->filterFecha);
                    })
                    ->when($this->filterNivel != '' || $this->filterGrado != '', function ($q) {
                        $q->whereHas('matricula', function ($mq) {
                            if ($this->filterNivel != '') $mq->where('nivel', $this->filterNivel);
                            if ($this->filterGrado != '') $mq->where('grado', $this->filterGrado);
                        });
                    })
                    ->orderBy('date', 'desc')
                    ->get();
            }
        }

        return view('livewire.dashboard.profesores.detalle', [
            'appointments' => $appointments,
            'messages' => $messages,
        ])
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

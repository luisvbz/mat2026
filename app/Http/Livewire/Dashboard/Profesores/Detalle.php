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

    public function mount($id)
    {
        $this->teacher = Teacher::with(['horario', 'user'])->findOrFail($id);
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function render()
    {
        $appointments = [];
        $messages = [];

        if ($this->activeTab === 'appointments') {
            $appointments = Appointment::where('teacher_id', $this->teacher->id)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get();
        }

        if ($this->activeTab === 'messages') {
            if ($this->teacher->user) {
                $messages = AgendaMessage::where('teacher_user_id', $this->teacher->user->id)
                    ->with('matricula.alumno')
                    ->orderBy('date', 'desc')
                    ->get();
            }
        }

        return view('livewire.dashboard.profesores.detalle', [
            'appointments' => $appointments,
            'messages' => $messages,
        ])
            ->extends('layouts.panel')
            ->section('content');
    }
}

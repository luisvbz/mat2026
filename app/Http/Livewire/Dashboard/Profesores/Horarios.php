<?php

namespace App\Http\Livewire\Dashboard\Profesores;

use App\Models\Horario;
use App\Models\HorarioDias;
use Livewire\Component;

class Horarios extends Component
{
    public $name;
    public $horarioId;
    public $isEditing = false;
    public $showModal = false;

    public $dias = [];

    protected $rules = [
        'name' => 'required|min:3',
        'dias.*.active' => 'boolean',
        'dias.*.start_time' => 'required_if:dias.*.active,true',
        'dias.*.end_time' => 'required_if:dias.*.active,true',
    ];

    public function mount()
    {
        $this->resetDias();
    }

    public function resetDias()
    {
        $this->dias = [];
        $nombresDias = [1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado', 7 => 'Domingo'];
        for ($i = 1; $i <= 7; $i++) {
            $this->dias[$i] = [
                'day_number' => $i,
                'name' => $nombresDias[$i],
                'active' => ($i <= 5), // Lunes a Viernes por defecto
                'start_time' => '08:00',
                'end_time' => '13:00',
            ];
        }
    }

    public function create()
    {
        $this->reset(['name', 'horarioId']);
        $this->resetDias();
        $this->isEditing = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $horario = Horario::with('dias')->findOrFail($id);
        $this->horarioId = $id;
        $this->name = $horario->name;
        
        $this->resetDias();
        foreach ($horario->dias as $dia) {
            $this->dias[$dia->day_number]['active'] = $dia->active;
            $this->dias[$dia->day_number]['start_time'] = substr($dia->start_time, 0, 5);
            $this->dias[$dia->day_number]['end_time'] = substr($dia->end_time, 0, 5);
        }

        $this->isEditing = true;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        if ($this->isEditing) {
            $horario = Horario::find($this->horarioId);
            $horario->update(['name' => $this->name]);
        } else {
            $horario = Horario::create(['name' => $this->name]);
        }

        // Sync days
        foreach ($this->dias as $diaData) {
            HorarioDias::updateOrCreate(
                ['schedule_id' => $horario->id, 'day_number' => $diaData['day_number']],
                [
                    'active' => $diaData['active'],
                    'start_time' => $diaData['start_time'],
                    'end_time' => $diaData['end_time'],
                ]
            );
        }

        session()->flash('success', 'Horario guardado correctamente.');
        $this->showModal = false;
    }

    public function delete($id)
    {
        $horario = Horario::findOrFail($id);
        // Check if in use by teachers
        if (\App\Models\Teacher::where('horario_id', $id)->exists()) {
            session()->flash('error', 'No se puede eliminar un horario que está siendo usado por profesores.');
            return;
        }
        
        $horario->dias()->delete();
        $horario->delete();
        session()->flash('success', 'Horario eliminado correctamente.');
    }

    public function render()
    {
        $horarios = Horario::with('dias')->get();
        return view('livewire.dashboard.profesores.horarios', ['horarios' => $horarios])
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

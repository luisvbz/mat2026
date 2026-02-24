<?php

namespace App\Http\Livewire\Dashboard\Profesores;

use App\Models\Teacher;
use App\Models\Horario;
use Livewire\Component;

class Editar extends Component
{
    public $teacherId;
    public $nombres;
    public $apellidos;
    public $documento;
    public $correo;
    public $telefono;
    public $horario_id;

    protected $rules = [
        'nombres' => 'required|min:3',
        'apellidos' => 'required|min:3',
        'documento' => 'required|numeric',
        'horario_id' => 'required|exists:schedules,id',
        'correo' => 'nullable|email',
        'telefono' => 'nullable|numeric|digits:9',
    ];

    public function mount($id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->teacherId = $id;
        $this->nombres = $teacher->nombres;
        $this->apellidos = $teacher->apellidos;
        $this->documento = $teacher->documento;
        $this->correo = $teacher->email;
        $this->telefono = $teacher->telefono;
        $this->horario_id = $teacher->horario_id;
    }

    public function update()
    {
        $this->validate([
            'documento' => 'required|numeric|unique:teachers,documento,' . $this->teacherId,
        ]);

        $teacher = Teacher::find($this->teacherId);
        $teacher->update([
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'documento' => $this->documento,
            'email' => $this->correo,
            'telefono' => $this->telefono,
            'horario_id' => $this->horario_id,
        ]);

        // Sync with TeacherUser
        if ($teacher->user) {
            $teacher->user->update([
                'document_number' => $this->documento,
            ]);
        }

        session()->flash('success', 'Profesor actualizado correctamente.');
        return redirect()->route('dashboard.profesores');
    }

    public function render()
    {
        $horarios = Horario::all();
        return view('livewire.dashboard.profesores.editar', ['horarios' => $horarios])
            ->extends('layouts.panel')
            ->section('content');
    }
}

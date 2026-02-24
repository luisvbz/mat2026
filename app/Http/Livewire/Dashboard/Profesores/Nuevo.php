<?php

namespace App\Http\Livewire\Dashboard\Profesores;

use App\Models\Teacher;
use App\Models\TeacherUser;
use App\Models\Horario;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Nuevo extends Component
{
    public $nombres;
    public $apellidos;
    public $documento;
    public $correo;
    public $telefono;
    public $horario_id;

    protected $rules = [
        'nombres' => 'required|min:3',
        'apellidos' => 'required|min:3',
        'documento' => 'required|numeric|unique:teachers,documento',
        'correo' => 'nullable|email',
        'telefono' => 'nullable|numeric|digits:9',
        'horario_id' => 'required|exists:schedules,id',
    ];

    public function save()
    {
        $this->validate();

        $teacher = new Teacher();
        $teacher->nombres = $this->nombres;
        $teacher->apellidos = $this->apellidos;
        $teacher->documento = $this->documento;
        $teacher->email = $this->correo;
        $teacher->telefono = $this->telefono;
        $teacher->horario_id = $this->horario_id;
        $teacher->estado = 1;
        $teacher->save();

        // Create associated TeacherUser
        TeacherUser::create([
            'teacher_id' => $teacher->id,
            'document_number' => $this->documento,
            'password' => Hash::make($this->documento),
            'is_active' => true,
        ]);

        session()->flash('success', 'Profesor y usuario creados exitosamente.');
        return redirect()->route('dashboard.profesores');
    }

    public function render()
    {
        $horarios = Horario::all();
        return view('livewire.dashboard.profesores.nuevo', ['horarios' => $horarios])
            ->extends('layouts.panel')
            ->section('content');
    }
}

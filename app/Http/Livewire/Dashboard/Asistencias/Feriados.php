<?php

namespace App\Http\Livewire\Dashboard\Asistencias;

use App\Models\AsistenciaFeriado;
use Livewire\Component;
use Carbon\Carbon;

class Feriados extends Component
{
    public $fecha_feriado;
    public $descripcion;

    protected $listeners = ['eliminar:feriado' => 'eliminar'];

    protected $rules = [
        'fecha_feriado' => 'required|date|unique:asistencias_feriados,fecha_feriado',
        'descripcion' => 'required|string|max:255',
    ];

    public function guardat()
    {
        $this->validate();

        AsistenciaFeriado::create([
            'fecha_feriado' => $this->fecha_feriado,
            'descripcion' => $this->descripcion,
        ]);

        $this->reset(['fecha_feriado', 'descripcion']);
        $this->emit('swal:modal', [
            'icon'  => 'success',
            'title' => '¡Éxito!',
            'text'  => 'Feriado agregado correctamente.',
        ]);
    }

    public function showDialogEliminar($id)
    {
        $feriado = AsistenciaFeriado::find($id);
        
        if (!$feriado) return;

        // Check if the holiday has already passed
        // Note: Use raw attribute if accessor is present
        $fecha = Carbon::parse($feriado->getRawOriginal('fecha_feriado'));
        if ($fecha->isPast() && !$fecha->isToday()) {
            $this->emit('swal:modal', [
                'icon'  => 'error',
                'title' => '¡Error!',
                'text'  => 'No puedes eliminar un feriado que ya ha pasado.',
            ]);
            return;
        }

        $this->emit("swal:confirm", [
            'icon'        => 'warning',
            'title'       => '¿Estás seguro?',
            'text'        => "¿Deseas eliminar este feriado?",
            'confirmText' => 'Sí, Eliminar!',
            'method'      => 'eliminar:feriado',
            'params'      => [$id],
            'callback'    => '',
        ]);
    }

    public function eliminar($params)
    {
        $id = $params[0];
        $feriado = AsistenciaFeriado::find($id);

        if ($feriado) {
            $fecha = Carbon::parse($feriado->getRawOriginal('fecha_feriado'));
            if ($fecha->isPast() && !$fecha->isToday()) {
                $this->emit('swal:modal', [
                    'icon'  => 'error',
                    'title' => '¡Error!',
                    'text'  => 'No puedes eliminar un feriado que ya ha pasado.',
                ]);
                return;
            }

            $feriado->delete();
            $this->emit('swal:modal', [
                'icon'  => 'success',
                'title' => '¡Éxito!',
                'text'  => 'Feriado eliminado.',
            ]);
        }
    }

    public function render()
    {
        $feriados = AsistenciaFeriado::orderBy('fecha_feriado', 'DESC')->get();

        return view('livewire.dashboard.asistencias.feriados', [
            'feriados' => $feriados
        ])
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

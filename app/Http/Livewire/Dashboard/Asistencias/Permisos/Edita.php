<?php

namespace App\Http\Livewire\Dashboard\Asistencias\Permisos;

use Livewire\Component;

class Edita extends Component
{
    public function render()
    {
        return view('livewire.dashboard.asistencias.permisos.edita')
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

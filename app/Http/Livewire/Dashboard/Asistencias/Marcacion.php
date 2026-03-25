<?php

namespace App\Http\Livewire\Dashboard\Asistencias;

use Livewire\Component;

class Marcacion extends Component
{
    public function render()
    {
        return view('livewire.dashboard.asistencias.marcacion')
                ->extends('layouts.tailwind')
                ->section('content');
    }
}

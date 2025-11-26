<?php

namespace App\Http\Livewire\Dashboard\Contabilidad;

use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.dashboard.contabilidad.index')
            ->extends('layouts.panel')
            ->section('content');
    }
}

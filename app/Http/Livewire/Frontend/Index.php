<?php

namespace App\Http\Livewire\Frontend;

use App\Models\Configuracion;
use Livewire\Component;

class Index extends Component
{

    public function render()
    {
        $citas = Configuracion::where('key', 'citas_activas')->first();
        return view('livewire.frontend.index', ['citas' => $citas->valor])
            ->extends('layouts.front-tailwind')
            ->section('content');
    }
}

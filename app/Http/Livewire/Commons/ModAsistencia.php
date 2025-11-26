<?php

namespace App\Http\Livewire\Commons;

use Livewire\Component;
use Illuminate\Support\Facades\Route;

class ModAsistencia extends Component
{
    public $route;

    public function mount()
    {
        $this->route = Route::currentRouteName();
    }

    public function render()
    {
        return view('livewire.commons.mod-asistencia');
    }
}

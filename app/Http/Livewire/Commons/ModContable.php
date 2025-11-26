<?php

namespace App\Http\Livewire\Commons;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class ModContable extends Component
{
    public $route;

    public function mount()
    {
        $this->route = Route::currentRouteName();
    }

    public function render()
    {
        return view('livewire.commons.mod-contable');
    }
}

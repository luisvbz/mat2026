<?php

namespace App\Http\Livewire\Dashboard\Contabilidad;

use App\Models\CronogramaPagos;
use Livewire\Component;

class Cronograma extends Component
{
    public $cronograma;

    public function mount()
    {
        $this->cronograma = CronogramaPagos::orderBy('orden', 'ASC')->get();
    }

    public function render()
    {
        return view('livewire.dashboard.contabilidad.cronograma')
            ->extends('layouts.panel')
            ->section('content');
    }
}

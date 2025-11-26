<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Matricula;
use App\Models\Recordatorio;
use Livewire\Component;

class Recordatorios extends Component
{
    public $grado = '';
    public $nivel = '';
    public $search = '';
    public $estado = '';

    protected $queryString = [
        'estado' =>  ['except' => ''],
        'grado' =>  ['except' => ''],
        'nivel' =>  ['except' => ''],
        'search' => ['except' => '']
    ];

    public function paginationView()
    {
        return 'bulma-pagination';
    }

    public function buscar()
    {
        $this->render();
    }

    public function limpiar()
    {
        $this->reset(['search', 'grado', 'nivel', 'estado']);
        $this->render();
    }


    public function render()
    {
        $recodatorios = Recordatorio::orderBy('id', 'DESC')->paginate(30);

        return view('livewire.dashboard.recordatorios', ['recordatorios' => $recodatorios])
            ->extends('layouts.panel')
            ->section('content');
    }
}

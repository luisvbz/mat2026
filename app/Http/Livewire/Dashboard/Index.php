<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Matricula;
use App\Models\Pension;
use Livewire\Component;

class Index extends Component
{

    public function render()
    {
        $primaria = collect();
        $secundaria = collect();

        for ($i = 1; $i <= 6; $i++) {

            $itemGrade = new \stdClass();
            $itemGrade->grado = $i;
            $itemGrade->alumnos =  Matricula::where('nivel', 'P')->where('grado', $i)->whereEstado(1)->count();

            $primaria->push($itemGrade);
        }

        for ($i = 1; $i <= 5; $i++) {

            $itemGrade = new \stdClass();
            $itemGrade->grado = $i;
            $itemGrade->alumnos =  Matricula::where('nivel', 'S')
                ->when(auth()->user()->id == 4, function ($q) {
                    $q->where('codigo', '<>', 'IEPDS-61140703-2026');
                })
                ->where('grado', $i)->whereEstado(1)->count();

            $secundaria->push($itemGrade);
        }

        return view('livewire.dashboard.index', ['primaria' => $primaria, 'secundaria' => $secundaria])
            ->extends('layouts.panel')
            ->section('content');
    }
}

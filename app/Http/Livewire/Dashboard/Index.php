<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Matricula;
use App\Models\Pension;
use Livewire\Component;

class Index extends Component
{

   /*  public function mount()
    {
        $ids = ['da6e8048-ed49-4b42-9f6e-d97c1b148dbe', '0b9655f4-e5e7-4348-a376-87ac13d072f6', '84ca4e47-c738-469d-80e0-a2813b585010', 'f7dc7837-897a-4719-b256-37d7ffbf9d3a'];
        $oneSignal = new \App\Tools\OneSignalService();
               $result = $oneSignal->sendToPlayers(
                    $ids,
                    'Nueva Solicitud de Cita',
                    "Prueba de cita."
                );
                dd($result);
    } */
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
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

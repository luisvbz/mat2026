<?php

namespace App\Http\Livewire\Dashboard\Profesores;

use PDF;
use App\Models\Teacher;
use Livewire\Component;

class Index extends Component
{

    public function getCarnet()
    {
        $teachers = Teacher::orderBy('apellidos', 'ASC')->get();

        $pdf = PDF::loadView(
            'pdfs.profesores',
            ['teachers' => $teachers],
            [],
            [
                'format' => [55, 85],
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_top' => 0,
                'margin_bottom' => 0
            ]
        );
        $fecha = date('d-m-Y');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "fotocheck-personal-{$fecha}.pdf");
    }

    public function render()
    {
        $teachers = Teacher::orderBy('apellidos', 'ASC')->get();

        return view('livewire.dashboard.profesores.index', ['teachers' => $teachers])
            ->extends('layouts.panel')
            ->section('content');
    }
}

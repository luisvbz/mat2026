<?php

namespace App\Http\Livewire\Dashboard\Profesores;

use PDF;
use App\Models\Teacher;
use Livewire\Component;

class Index extends Component
{

    public $search;
    protected $queryString = ['search'];

    public function activar($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            $teacher->update(['estado' => 1]);
            if ($teacher->user) {
                $teacher->user->update(['is_active' => true]);
            }
            session()->flash('success', 'Profesor activado exitosamente.');
        }
    }

    public function desactivar($id)
    {
        $teacher = Teacher::find($id);
        if ($teacher) {
            $teacher->update(['estado' => 0]);
            if ($teacher->user) {
                $teacher->user->update(['is_active' => false]);
            }
            session()->flash('success', 'Profesor desactivado exitosamente.');
        }
    }

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
        $teachers = Teacher::where(function ($query) {
            $query->where('nombres', 'like', '%' . $this->search . '%')
                ->orWhere('apellidos', 'like', '%' . $this->search . '%')
                ->orWhere('documento', 'like', '%' . $this->search . '%');
        })
            ->orderBy('apellidos', 'ASC')
            ->get();

        return view('livewire.dashboard.profesores.index', ['teachers' => $teachers])
            ->extends('layouts.panel')
            ->section('content');
    }
}

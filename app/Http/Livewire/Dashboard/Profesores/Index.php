<?php

namespace App\Http\Livewire\Dashboard\Profesores;

use PDF;
use App\Models\Teacher;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public $estado = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'estado' => ['except' => '']
    ];

    public function buscar()
    {
        // Manual search trigger for deferred models
    }

    public function limpiar()
    {
        $this->reset(['search', 'estado']);
    }

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
            ->when($this->estado !== '', function ($query) {
                $query->where('estado', $this->estado);
            })
            ->orderBy('apellidos', 'ASC')
            ->get();

        return view('livewire.dashboard.profesores.index', ['teachers' => $teachers])
            ->extends('layouts.panel')
            ->section('content');
    }
}

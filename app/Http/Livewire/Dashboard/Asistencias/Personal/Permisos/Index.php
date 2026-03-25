<?php

namespace App\Http\Livewire\Dashboard\Asistencias\Personal\Permisos;

use App\Models\AsistenciaProfesor;
use App\Models\Teacher;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PermisosPersonal;

class Index extends Component
{

    use WithPagination;

    public $profesor = '';
    public $profesores;

    protected $listeners = [
        'eliminar:permiso' => 'eliminarPermiso'
    ];

    public function mount()
    {
        $this->profesores = Teacher::orderBy('apellidos')
            ->where('estado', 1)
            ->orderBy('nombres')->get();
    }

    public function showDialogEliminarPermiso($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta eliminara el permiso",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'eliminar:permiso',
            'params'      => [$id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function eliminarPermiso($params)
    {
        if (AsistenciaProfesor::where('permiso_id', $params[0])->exists()) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!!',
                'text'  => "El permiso ya fue utilizado",
            ]);

            return;
        }

        PermisosPersonal::find($params[0])->delete();

        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "El permiso se ha eliminado con éxito",
        ]);

        $this->resetPage();
    }

    public function render()
    {
        $permisos = PermisosPersonal::when($this->profesor != '', function ($q) {
            $q->where('teacher_id', $this->profesor);
        })
            ->orderBy('created_at', 'DESC')
            ->paginate(50);

        return view('livewire.dashboard.asistencias.personal.permisos.index', ['permisos' => $permisos])
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

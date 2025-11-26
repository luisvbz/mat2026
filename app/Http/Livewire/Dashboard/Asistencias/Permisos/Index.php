<?php

namespace App\Http\Livewire\Dashboard\Asistencias\Permisos;

use Livewire\Component;
use App\Models\Asistencia;
use App\Models\PermisoAlumno;

class Index extends Component
{

    public $alumno = '';
    protected $listeners = [
        'eliminar:permiso' => 'eliminarPermiso'
    ];

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
        if (Asistencia::where('permiso_id', $params[0])->exists()) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!!',
                'text'  => "El permiso ya fue utilizado",
            ]);

            return;
        }

        PermisoAlumno::find($params[0])->delete();

        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "El permiso se ha eliminado con éxito",
        ]);

        $this->resetPage();
    }




    public function render()
    {
        $permisos = PermisoAlumno::when($this->alumno != '', function ($q) {
            $q->where('alumno_id', $this->alumno);
        })
            ->orderBy('created_at', 'DESC')
            ->paginate(50);

        return view('livewire.dashboard.asistencias.permisos.index', ['permisos' => $permisos])
            ->extends('layouts.panel')
            ->section('content');
    }
}

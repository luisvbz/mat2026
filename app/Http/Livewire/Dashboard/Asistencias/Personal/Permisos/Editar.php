<?php

namespace App\Http\Livewire\Dashboard\Asistencias\Personal\Permisos;

use App\Models\PermisosPersonal;
use Carbon\Carbon;
use App\Models\Teacher;
use Livewire\Component;

class Editar extends Component
{
    public $permisoId;
    public $tipo = '';
    public $profesores;
    public $profesor = '';
    public $desde = '';
    public $desde_hora = '';
    public $hasta = '';
    public $hasta_hora = '';
    public $motivo = '';

    public function mount($id)
    {
        $this->permisoId = $id;
        $this->profesores = Teacher::orderBy('apellidos')
            ->where('estado', 1)
            ->orderBy('nombres')->get();

        $permiso = PermisosPersonal::find($this->permisoId);
        if ($permiso) {
            $this->profesor = $permiso->teacher_id;
            $this->tipo = $permiso->tipo;
            $this->desde = Carbon::parse($permiso->desde)->format('Y-m-d');
            $this->desde_hora = Carbon::parse($permiso->desde)->format('H:i');
            $this->hasta = Carbon::parse($permiso->hasta)->format('Y-m-d');
            $this->hasta_hora = Carbon::parse($permiso->hasta)->format('H:i');
            $this->motivo = $permiso->comentario;
        }
    }

    public function guardarPermiso()
    {
        $this->validate([
            'profesor' => 'required',
            'tipo' => 'required',
            'hasta' => 'required_if:tipo,E,SS',
            'desde' => 'required_if:tipo,S,SS',
            'hasta_hora' => 'required_if:tipo,E',
            'desde_hora' => 'required_if:tipo,S',
            'motivo' => 'required'
        ], [
            'profesor.required' => 'Debe seleccionar el profesor',
            'tipo.required' => 'Seleccione el tipo',
            'hasta.required_if' => 'Indique fecha',
            'desde.required_if' => 'Indique fecha',
            'hasta_hora.required_if' => 'Indique hora',
            'desde_hora.required_if' => 'Indique Hora',
            'motivo.required' => 'Indique el motivo'
        ]);

        $profe = Teacher::find($this->profesor);

        if ($this->tipo == 'E') {
            $diaDesde = Carbon::createFromFormat('Y-m-d', $this->hasta);
            $diaHorario = $profe->horario->dias->where('day_number', $diaDesde->format('N'))->first();

            if (!$diaHorario->active) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El personal no labora ese dia",
                ]);
                return;
            }

            PermisosPersonal::where('id', $this->permisoId)->update([
                'teacher_id' => $this->profesor,
                'tipo' => $this->tipo,
                'desde' => $this->hasta . ' ' . $diaHorario->start_time,
                'hasta' => $this->hasta . ' ' . $this->hasta_hora,
                'comentario' =>  $this->motivo,
            ]);
        } elseif ($this->tipo == 'S') {
            $diaDesde = Carbon::createFromFormat('Y-m-d', $this->desde);
            $diaHorario = $profe->horario->dias->where('day_number', $diaDesde->format('N'))->first();

            if (!$diaHorario->active) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El personal no labora ese dia",
                ]);
                return;
            }

            PermisosPersonal::where('id', $this->permisoId)->update([
                'teacher_id' => $this->profesor,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $this->desde_hora,
                'hasta' => $this->desde . ' ' . $diaHorario->end_time,
                'comentario' =>  $this->motivo,
            ]);
        } elseif ($this->tipo == 'SS') {
            $diaDesde = Carbon::createFromFormat('Y-m-d', $this->desde);
            $diaHasta = Carbon::createFromFormat('Y-m-d', $this->hasta);
            $diaDesdeHorario = $profe->horario->dias->where('day_number', $diaDesde->format('N'))->first();
            $diaHastaHorario = $profe->horario->dias->where('day_number', $diaHasta->format('N'))->first();

            PermisosPersonal::where('id', $this->permisoId)->update([
                'teacher_id' => $this->profesor,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $diaDesdeHorario->start_time,
                'hasta' => $this->hasta . ' ' . $diaHastaHorario->end_time,
                'comentario' =>  $this->motivo,
            ]);
        }

        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "Se ha actualizado el permiso con éxito",
        ]);

        return redirect()->route('permisos-profesores.index');
    }

    public function render()
    {
        return view('livewire.dashboard.asistencias.personal.permisos.editar')
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

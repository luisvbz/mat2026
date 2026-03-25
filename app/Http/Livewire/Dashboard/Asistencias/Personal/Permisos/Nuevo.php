<?php

namespace App\Http\Livewire\Dashboard\Asistencias\Personal\Permisos;

use App\Models\PermisosPersonal;
use Carbon\Carbon;
use App\Models\Teacher;
use Livewire\Component;

class Nuevo extends Component
{
    public $tipo = '';
    public $profesores;
    public $profesor = '';
    public $undia = true;
    public $desde = '';
    public $desde_hora = '';
    public $hasta = '';
    public $hasta_hora = '';
    public $motivo = '';


    public function mount()
    {
        $this->profesores = Teacher::orderBy('apellidos')
            ->where('estado', 1)
            ->orderBy('nombres')->get();
    }


    /*  public function guardarPermiso()
    {
        $this->validate([
            'profesor' => 'required',
            'tipo' => 'required',
            'hasta' => 'required_if:tipo,E',
            'desde' => 'required_if:tipo,S',
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

            PermisosPersonal::create([
                'teacher_id' => $this->profesor,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->hasta . ' ' . $diaHorario->start_time,
                'hasta' => $this->hasta . ' ' . $this->hasta_hora,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);
        } else if ($this->tipo == 'S') {
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

            PermisosPersonal::create([
                'teacher_id' => $this->profesor,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $this->desde_hora,
                'hasta' => $this->desde . ' ' . $diaHorario->end_time,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);
        } else if ($this->tipo == 'SS') {
            $diaDesde = Carbon::createFromFormat('Y-m-d', $this->desde);
            $diaHasta = Carbon::createFromFormat('Y-m-d', $this->hasta);
            $diaDesdeHorario = $profe->horario->dias->where('day_number', $diaDesde->format('N'))->first();
            $diaHastaHorario = $profe->horario->dias->where('day_number', $diaHasta->format('N'))->first();

            PermisosPersonal::create([
                'teacher_id' => $this->profesor,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $diaDesdeHorario->start_time,
                'hasta' => $this->hasta . ' ' . $diaHastaHorario->end_time,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);
        }


        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "Se ha generado el permiso con éxito",
        ]);

        return redirect()->route('permisos-profesores.index');
    }*/

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

            // Verificar si ya existe un permiso del mismo tipo en la misma fecha
            if (PermisosPersonal::where('teacher_id', $this->profesor)
                ->where('tipo', 'E')
                ->whereDate('desde', $this->hasta)
                ->exists()
            ) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El personal ya tiene un permiso de entrada en esta fecha",
                ]);
                return;
            }

            PermisosPersonal::create([
                'teacher_id' => $this->profesor,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->hasta . ' ' . $diaHorario->start_time,
                'hasta' => $this->hasta . ' ' . $this->hasta_hora,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
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

            // Verificar si ya existe un permiso del mismo tipo en la misma fecha
            if (PermisosPersonal::where('teacher_id', $this->profesor)
                ->where('tipo', 'S')
                ->whereDate('desde', $this->desde)
                ->exists()
            ) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El personal ya tiene un permiso de salida en esta fecha",
                ]);
                return;
            }

            PermisosPersonal::create([
                'teacher_id' => $this->profesor,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $this->desde_hora,
                'hasta' => $this->desde . ' ' . $diaHorario->end_time,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);
        } elseif ($this->tipo == 'SS') {
            $diaDesde = Carbon::createFromFormat('Y-m-d', $this->desde);
            $diaHasta = Carbon::createFromFormat('Y-m-d', $this->hasta);
            $diaDesdeHorario = $profe->horario->dias->where('day_number', $diaDesde->format('N'))->first();
            $diaHastaHorario = $profe->horario->dias->where('day_number', $diaHasta->format('N'))->first();

            // Verificar si ya existe un permiso del mismo tipo en el rango de fechas
            if (PermisosPersonal::where('teacher_id', $this->profesor)
                ->whereBetween('desde', [$this->desde, $this->hasta])
                ->exists()
            ) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El personal ya tiene un permiso en este rango de fechas",
                ]);
                return;
            }

            PermisosPersonal::create([
                'teacher_id' => $this->profesor,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $diaDesdeHorario->start_time,
                'hasta' => $this->hasta . ' ' . $diaHastaHorario->end_time,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);
        }

        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "Se ha generado el permiso con éxito",
        ]);

        return redirect()->route('permisos-profesores.index');
    }


    public function render()
    {
        return view('livewire.dashboard.asistencias.personal.permisos.nuevo')
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

<?php

namespace App\Http\Livewire\Dashboard\Asistencias\Permisos;

use Carbon\Carbon;
use App\Models\Grado;
use App\Models\Alumno;
use Livewire\Component;
use Carbon\CarbonPeriod;
use App\Models\Matricula;
use App\Models\Asistencia;
use App\Models\PermisoAlumno;

class Nuevo extends Component
{

    public $nivel = "";
    public $grado = "";
    public $grados = [];
    public $tipo = '';
    public $alumnos = [];
    public $alumno = '';
    public $undia = true;
    public $desde = '';
    public $desde_hora = '';
    public $hasta = '';
    public $hasta_hora = '';
    public $motivo = '';

    public function updatedNivel()
    {

        $this->grados = Grado::where('nivel', $this->nivel)
            ->orderBy('numero')
            ->get();
    }

    public function updatedGrado()
    {
        $matIds = Matricula::where('estado', 1)
            ->whereHas('alumno')
            ->where('nivel', $this->nivel)
            ->where('grado', $this->grado)
            ->get()
            ->pluck('alumno_id')
            ->toArray();

        $this->alumnos = Alumno::whereIn('id', $matIds)
            ->orderBy('apellido_paterno')
            ->orderBy('apellido_materno')
            ->orderBy('nombres')
            ->get();
    }

    public function guardarPermiso()
    {
        $this->validate([
            'alumno' => 'required',
            'tipo' => 'required',
            'hasta' => 'required_if:tipo,E,SS',
            'desde' => 'required_if:tipo,S,SS',
            'hasta_hora' => 'required_if:tipo,E',
            'desde_hora' => 'required_if:tipo,S',
            'motivo' => 'required'
        ], [
            'alumno.required' => 'Debe seleccionar el alumno',
            'tipo.required' => 'Seleccione el tipo',
            'hasta.required_if' => 'Indique fecha',
            'desde.required_if' => 'Indique fecha',
            'hasta_hora.required_if' => 'Indique hora',
            'desde_hora.required_if' => 'Indique Hora',
            'motivo.required' => 'Indique el motivo'
        ]);

        $mat = Matricula::where('alumno_id', $this->alumno)->first();

        if ($this->tipo == 'E') {

            if (PermisoAlumno::where('alumno_id', $this->alumno)
                ->where('tipo', 'E')
                ->whereDate('desde', $this->hasta)
                ->exists()
            ) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El alumno ya tiene un permiso de entrada en esta fecha",
                ]);
                return;
            }

            PermisoAlumno::create([
                'alumno_id' => $this->alumno,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->hasta . ' ' . $mat->hora_entrada,
                'hasta' => $this->hasta . ' ' . $this->hasta_hora,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);
        } elseif ($this->tipo == 'S') {

            if (PermisoAlumno::where('alumno_id', $this->alumno)
                ->where('tipo', 'S')
                ->whereDate('desde', $this->desde)
                ->exists()
            ) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El alumno ya tiene un permiso de salida en esta fecha",
                ]);
                return;
            }

            PermisoAlumno::create([
                'alumno_id' => $this->alumno,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $this->desde_hora,
                'hasta' => $this->desde . ' ' . $mat->hora_salida,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);
        } elseif ($this->tipo == 'SS') {
            // Verificar si ya existe un permiso del mismo tipo en el rango de fechas
            if (PermisoAlumno::where('alumno_id', $this->alumno)
                ->whereBetween('desde', [$this->desde, $this->hasta])
                ->exists()
            ) {
                $this->emit('swal:modal', [
                    'type'  => 'warning',
                    'title' => 'Error!!',
                    'text'  => "El alumno ya tiene un permiso en este rango de fechas",
                ]);
                return;
            }

            $dias = $this->obtenerFechasHabiles($this->desde, $this->hasta);

            $permiso = PermisoAlumno::create([
                'alumno_id' => $this->alumno,
                'estado' => 1,
                'tipo' => $this->tipo,
                'desde' => $this->desde . ' ' . $mat->hora_entrada,
                'hasta' => $this->hasta . ' ' . $mat->hora_salida,
                'comentario' =>  $this->motivo,
                'creado_por' => auth()->user()->id
            ]);

            foreach ($dias as $dia) {
                $diaC = Carbon::createFromFormat('Y-m-d', $dia);
                Asistencia::updateOrCreate(
                    [
                        'alumno_id' => $this->alumno,
                        'dia' => $dia
                    ],
                    [
                        'alumno_id' => $this->alumno,
                        'tipo' => Asistencia::FALTA_JUSTIFICADA,
                        'anio' => $diaC->year,
                        'entrada' => null,
                        'salida' => null,
                        'tardanza_entrada' => null,
                        'salida_anticipada' => null,
                        'mes' => $diaC->month,
                        'dia' => $dia,
                        'permiso_id' => $permiso->id
                    ]
                );
            }
        }

        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "Se ha generado el permiso con éxito",
        ]);

        return redirect()->route('permisos-alumnos.index');
    }

    private function obtenerFechasHabiles($desde, $hasta)
    {
        $fechas = [];
        $periodo = CarbonPeriod::create($desde, $hasta);

        foreach ($periodo as $fecha) {
            if (!$fecha->isWeekend()) { // Excluye sábados y domingos
                $fechas[] = $fecha->toDateString();
            }
        }

        return $fechas;
    }

    public function render()
    {
        return view('livewire.dashboard.asistencias.permisos.nuevo')
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

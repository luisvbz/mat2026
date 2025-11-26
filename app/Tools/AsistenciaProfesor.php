<?php

namespace App\Tools;

use DateTime;
use Carbon\Carbon;
use App\Models\AsistenciaFeriado;
use App\Models\AsistenciaProfesor as Profesor;
use App\Models\PermisosPersonal;

class AsistenciaProfesor
{
    private $profesor;
    private $date;
    private $laboral = true;
    private $entrada;
    private $entrada_tolerancia;
    private $salida;
    private $dia;
    private $registroBase;
    private $feriado = false;


    public function __construct($profesor, $date)
    {
        $this->profesor = $profesor;
        $this->date = $date;
        $this->getDiaHorario();
        $this->checkHorario();
        if ($this->laboral) {
            $this->initializeTiempos($this->date);
        }
        $this->registroBase = Profesor::where('teacher_id', $this->profesor->id)
            ->where('dia', $date)
            ->first();
    }

    private function initializeTiempos($date)
    {

        if (!$this->laboral) return;
        $this->entrada = Carbon::createFromFormat('Y-m-d H:i:s', "$date " . $this->dia->start_time);
        $this->entrada_tolerancia = Carbon::createFromFormat('Y-m-d H:i:s', "$date " . $this->dia->start_time);
        $this->entrada_tolerancia = $this->entrada_tolerancia->addMinutes(15);
        $this->salida = Carbon::createFromFormat('Y-m-d H:i:s', "$date " . $this->dia->end_time);
    }

    private function getDiaHorario()
    {
        $dia = Carbon::createFromFormat('Y-m-d', $this->date);
        $this->dia = $this->profesor->horario->dias->where('day_number', $dia->format('N'))->first();
    }

    private function checkHorario()
    {
        if (is_null($this->dia)) {
            $this->laboral = false;
        } else {
            if (!$this->dia->active) {
                $this->laboral = false;
            }
        }
    }

    private function checkFeriado()
    {
        $feriado = AsistenciaFeriado::where('fecha_feriado', $this->date->format('Y-m-d'))->exists();
        $this->feriado = $feriado;
    }

    public function setMarcacion($consola = false)
    {
        if ($this->feriado) {
            $this->registrarFeriado();
            return;
        }

        if (!$this->laboral) {
            $this->registerNoLaborable();
            return;
        }

        if ($consola) {

            $permiso = $this->profesor->permisos()
                ->whereDate('hasta', $this->date)
                ->whereTime('hasta', '>=', $this->entrada_tolerancia->format('H:i:s'))
                ->first();

            if ($permiso) {
                $this->registerFaltajustificada();
            } else {
                $this->registerFaltaInjustificada();
            }
        } else {
            if (!$this->registroBase) {
                $this->registrarEntrada();
            } else if (is_null($this->registroBase->salida)) {
                $this->registrarSalida($this->registroBase);
            }
        }
    }

    private function registerNoLaborable()
    {
        if ($this->registroBase) return;
        $dia = Carbon::createFromFormat('Y-m-d', $this->date);

        Profesor::create([
            'teacher_id'       => $this->profesor->id,
            'tipo'            => Profesor::NO_LABORABLE,
            'anio'            => $dia->year,
            'mes'             => $dia->month,
            'dia'             => $dia->format('Y-m-d')
        ]);
    }

    private function registerFaltaInjustificada()
    {
        if ($this->registroBase) return;
        $dia = Carbon::createFromFormat('Y-m-d', $this->date);

        Profesor::create([
            'teacher_id'       => $this->profesor->id,
            'tipo'            => Profesor::FALTA_INJUSTIFICADA,
            'anio'            => $dia->year,
            'mes'             => $dia->month,
            'dia'             => $dia->format('Y-m-d')
        ]);
    }

    private function registerFaltaJustificada()
    {
        if ($this->registroBase) return;
        $dia = Carbon::createFromFormat('Y-m-d', $this->date);

        Profesor::create([
            'teacher_id'       => $this->profesor->id,
            'tipo'            => Profesor::FALTA_JUSTIFICADA,
            'anio'            => $dia->year,
            'mes'             => $dia->month,
            'dia'             => $dia->format('Y-m-d')
        ]);
    }

    private function registrarFeriado()
    {
        if ($this->registroBase) return;
        $dia = Carbon::createFromFormat('Y-m-d', $this->date);

        Profesor::create([
            'teacher_id'       => $this->profesor->id,
            'tipo'            => Profesor::FERIADO,
            'anio'            => $dia->year,
            'mes'             => $dia->month,
            'dia'             => $dia->format('Y-m-d')
        ]);
    }

    private function registrarEntrada()
    {
        $tardanza = null;

        $entrada = Carbon::now();

        $dia = Carbon::createFromFormat('Y-m-d', $this->date);
        $tipo = Profesor::NORMAL;

        $permiso = $this->profesor->permisos()->where('tipo', 'E')
            ->whereDate('hasta', $this->date)
            ->whereTime('hasta', '>=', $this->entrada_tolerancia->format('H:i:s'))
            ->first();


        if ($dia->gt($this->entrada_tolerancia) && !$permiso) {
            $tardanza = $dia->diff($this->entrada_tolerancia)->format('%H:%I:%S');
            $tipo = Profesor::TARDANZA;
        }

        if ($permiso) {
            $entrada_permiso = Carbon::createFromFormat('Y-m-d H:i:s', $permiso->hasta);

            if ($entrada->gt($entrada_permiso)) {
                $tardanza = $entrada->diff($entrada_permiso)->format('%H:%I:%S');
                $tipo = Profesor::TARDANZA;
            }
        }

        Profesor::create([
            'teacher_id'       => $this->profesor->id,
            'tipo'            => $tipo,
            'anio'            => $dia->year,
            'mes'             => $dia->month,
            'dia'             => $dia->format('Y-m-d'),
            'entrada'         => $entrada,
            'permiso_id'      => $permiso->id ?? null,
            'tardanza_entrada' => $tardanza,
        ]);
    }


    private function registrarSalida($marcacion)
    {
        $anticipado = null;

        $dia = Carbon::createFromFormat('Y-m-d', $this->date);

        $permiso = $this->profesor->permisos()->where('tipo', 'S')
            ->whereDate('desde', $this->date)
            ->whereTime('desde', '<=', $this->salida->format('H:i:s'))
            ->first();

        if ($this->salida->gt($dia) && !$permiso) {
            $anticipado = $this->salida->diff($dia)->format('%H:%I:%S');
        }

        $marcacion->update([
            'salida'           => Carbon::now(),
            'salida_anticipada' => $anticipado,
            'permiso_id' => $permiso->id ?? null
        ]);
    }
}

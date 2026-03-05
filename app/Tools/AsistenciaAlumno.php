<?php

namespace App\Tools;

use Carbon\Carbon;
use App\Models\Alumno;
use App\Models\Asistencia;
use App\Models\AsistenciaFeriado;
use App\Models\PermisoAlumno;

class AsistenciaAlumno
{

    private $alumno;
    private $date;
    private $laboral = true;
    private $entrada;
    private $entrada_tolerancia;
    private $hora_entrada;
    private $hora_salida;
    private $salida;
    private $horaMarcacion;

    /* private const HORA_ENTRADA = '07:15:00';
    private const HORA_ENTRADA_TOLERANCIA = '07:30:00';
    private const HORA_SALIDA = '17:00:00';*/

    public function __construct(Alumno $alumno, $date, $hora_entrada, $hora_salida, $horaMarcacion = null)
    {
        $this->alumno = $alumno;
        $this->date = Carbon::createFromFormat('Y-m-d H:i:s', $date . " " . $horaMarcacion);
        $this->hora_entrada = $hora_entrada;
        $this->hora_salida = $hora_salida;
        $this->horaMarcacion = $horaMarcacion;
        $this->initializeTiempos($date);
    }

    private function initializeTiempos($date)
    {
        $this->entrada = Carbon::createFromFormat('Y-m-d H:i:s', "$date " . $this->hora_entrada);
        $this->entrada_tolerancia = Carbon::createFromFormat('Y-m-d H:i:s', "$date " . $this->hora_entrada)->addMinutes(15);
        $this->salida = Carbon::createFromFormat('Y-m-d H:i:s', "$date " . $this->hora_salida);
    }

    public function setMarcacion()
    {
        $marcacion = $this->obtenerMarcacion();

        if (!$marcacion) {
            $this->registrarEntrada();
        } else if (is_null($marcacion->salida)) {
            $this->registrarSalida($marcacion);
        }
    }

    private function checkFeriado()
    {
        return AsistenciaFeriado::where('fecha_feriado', $this->date->format('Y-m-d'))->exists();
    }

    private function obtenerMarcacion()
    {
        return Asistencia::where('alumno_id', $this->alumno->id)
            ->where('dia', $this->date->format('Y-m-d'))
            ->first();
    }

    private function registrarEntrada()
    {
        $tipo = Asistencia::NORMAL;
        $tardanza = null;
        $entrada = Carbon::createFromFormat('Y-m-d H:i:s', $this->date->format('Y-m-d') . ' ' . $this->horaMarcacion);

        $permiso = PermisoAlumno::where('alumno_id', $this->alumno->id)->where('tipo', 'E')
            ->whereDate('hasta', $this->date)
            ->whereTime('hasta', '>=', $this->entrada_tolerancia->format('H:i:s'))
            ->first();


        if ($this->date->gt($this->entrada_tolerancia) && !$permiso) {

            $tipo = Asistencia::TARDANZA;
            $tardanza = $this->date->diff($this->entrada_tolerancia)->format('%H:%I:%S');
        }

        if ($permiso) {
            $entrada_permiso = Carbon::createFromFormat('Y-m-d H:i:s', $permiso->hasta);

            if ($entrada->gt($entrada_permiso)) {
                $tardanza = $entrada->diff($entrada_permiso)->format('%H:%I:%S');
                $tipo = Asistencia::TARDANZA;
            }
        }

        Asistencia::create([
            'alumno_id'       => $this->alumno->id,
            'tipo'            => $tipo,
            'anio'            => $this->date->year,
            'mes'             => $this->date->month,
            'dia'             => $this->date->format('Y-m-d'),
            'entrada'         => $entrada,
            'permiso_id'      => $permiso->id ?? null,
            'tardanza_entrada' => $tardanza,
        ]);

        // Notify parents
        $padresId = $this->alumno->padres->pluck('user.id')->filter()->toArray();
        if (!empty($padresId)) {
            $label = $tipo === Asistencia::NORMAL ? 'A tiempo' : ($tipo === Asistencia::TARDANZA ? 'Tardanza' : 'Asistencia');
            \App\Jobs\SendPushNotificationJob::dispatch(
                $padresId,
                'parent',
                'Registro de Asistencia',
                "Se ha registrado la entrada de {$this->alumno->nombre_completo}. Estado: {$label}.",
                "https://app.iepdivinosalvador.net.pe/asistencias/{$this->alumno->id}"
            );
        }
    }

    private function registrarSalida($marcacion)
    {
        $anticipado = null;


        $permiso = PermisoAlumno::where('alumno_id', $this->alumno->id)->where('tipo', 'S')
            ->whereDate('desde', $this->date)
            ->whereTime('desde', '<=', $this->salida->format('H:i:s'))
            ->first();

        if ($this->salida->gt($this->date) && !$permiso) {
            $anticipado = $this->salida->diff($this->date)->format('%H:%I:%S');
        }

        $marcacion->update([
            'salida'           => Carbon::createFromFormat('Y-m-d H:i:s', $this->date->format('Y-m-d') . ' ' . $this->horaMarcacion),
            'salida_anticipada' => $anticipado,
            'permiso_id'      => $permiso->id ?? null,
        ]);

         $padresId = $this->alumno->padres->pluck('user.id')->filter()->toArray();
        if (!empty($padresId)) {
            \App\Jobs\SendPushNotificationJob::dispatch(
                $padresId,
                'parent',
                'Registro de Asistencia',
                "Se ha registrado la salida de {$this->alumno->nombre_completo}.",
                "https://app.iepdivinosalvador.net.pe/asistencias/{$this->alumno->id}"
            );
        }
    }
}

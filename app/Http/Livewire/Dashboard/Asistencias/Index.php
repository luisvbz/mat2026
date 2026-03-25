<?php

namespace App\Http\Livewire\Dashboard\Asistencias;

use PDF;
use DateTime;
use Carbon\Carbon;
use App\Models\Grado;
use Livewire\Component;
use App\Models\Matricula;
use App\Models\Asistencia;
use App\Models\AsistenciaFeriado;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    public $nivel = "";
    public $grado = "";
    public $grados = [];
    public $vista = 'dia';
    public $vistas = [
        'dia' => 'Dia',
        'semana' => 'Semana',
        'mes' => 'Mes'
    ];

    public $day;
    public $anio_reporte;
    public $mes_reporte;

    public $alumnos = [];

    public $dias;

    protected $listeners = [
        'justificar:tardanza' => 'justificarTardanza'
    ];


    public function mount()
    {
        $this->day = date('Y-m-d');
        $this->anio_reporte = date('Y');
        $this->mes_reporte = date('m');
    }

    public function updatedDay()
    {
        $this->obtenerAlumnosConAsistencias();
    }

    public function updatedNivel()
    {

        $this->grados = Grado::where('nivel', $this->nivel)
            ->orderBy('numero')
            ->get();

        $this->obtenerAlumnosConAsistencias();
    }

    public function updatedGrado()
    {
        $this->obtenerAlumnosConAsistencias();
    }


    public function updatedVista()
    {
        $this->obtenerAlumnosConAsistencias();
    }

    public function obtenerDias()
    {
        $this->reset('dias');
        $hoy = Carbon::createFromFormat('Y-m-d', $this->day);
        $diaActual = $hoy->format('Y-m-d');
        $diasSemana = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $diasSemanaL = ['D', 'L', 'M', 'M', 'J', 'V', 'S'];
        $mes = $hoy->format('m');
        $anio = $hoy->format('Y');
        $dias = [];

        if ($this->vista == 'dia') {
            // Devolver solo el día actual
            $dias[] = [
                'fecha' => $diaActual,
                'hoy' => true,
                'dia' => $diasSemana[$hoy->format('w')],
                'dia_letra' => $diasSemanaL[$hoy->format('w')],
            ];
        } elseif ($this->vista == 'semana') {
            // Devolver la semana actual resaltando el día de hoy
            $primerDiaSemana = clone $hoy;
            $primerDiaSemana->modify('this week'); // Comenzar desde el domingo de esta semana

            for ($i = 0; $i < 7; $i++) {
                $fecha = clone $primerDiaSemana;
                $fecha->modify("+$i days");
                if ($fecha->format('w') > 0 && $fecha->format('w') < 6) {
                    $dias[] = [
                        'fecha' => $fecha->format('Y-m-d'),
                        'hoy' => $fecha->format('Y-m-d') === $diaActual,
                        'dia' => $diasSemana[$fecha->format('w')],
                        'dia_letra' => $diasSemanaL[$fecha->format('w')],
                    ];
                }
            }
        } elseif ($this->vista == 'mes') {
            // Devolver todos los días del mes actual resaltando el día de hoy
            $diasDelMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

            for ($i = 1; $i <= $diasDelMes; $i++) {
                $fecha = new DateTime("$anio-$mes-$i");
                if ($fecha->format('w') > 0 && $fecha->format('w') < 6) {
                    $dias[] = [
                        'fecha' => $fecha->format('Y-m-d'),
                        'hoy' => $fecha->format('Y-m-d') === $diaActual,
                        'dia' => $diasSemana[$fecha->format('w')],
                        'dia_letra' => $diasSemanaL[$fecha->format('w')],
                    ];
                }
            }
        }

        $this->dias = $dias;
    }

    public function obtenerAlumnosConAsistencias()
    {
        $this->obtenerDias();
        $fechas = collect($this->dias)->pluck('fecha')->toArray();
        $this->alumnos = Matricula::with(['alumno', 'asistencias' => function ($query) use ($fechas) {
            $query->whereIn('dia', $fechas);
        }])
            ->where('estado', 1)
            ->whereHas('alumno')
            ->where('nivel', $this->nivel)
            ->where('grado', $this->grado)
            ->get()
            ->map(function ($matricula) {
                return [
                    'nombre' => $matricula->alumno->nombre_completo,
                    'grado' => $matricula->grado->nombre ?? '',
                    'nivel' => $matricula->grado->nivel ?? '',
                    'dias' => collect($this->dias)->map(function ($dia) use ($matricula) {

                        $asistencia = Asistencia::where('alumno_id', $matricula->alumno->id)
                            ->where('dia', $dia['fecha'])
                            ->first();
                        return array_merge($dia, [
                            'asistencia_id' => $asistencia->id ?? null,
                            'entrada' => $asistencia->entrada ?? null,
                            'tardanza_entrada' => $asistencia->tardanza_entrada ?? null,
                            'salida' => $asistencia->salida ?? null,
                            'salida_anticipada' => $asistencia->salda_anticipaa ?? null,
                            'tipo' => $asistencia->tipo ?? null,
                            'permiso' => $this->buscarPermiso($matricula->alumno->id, $dia['fecha']),
                            'comentario' => $asistencia->comentario ?? null,
                        ]);
                    })->toArray()
                ];
            })->toArray();

        //dd($this->alumnos); // Para depuración
    }


    public function mostrarJustificarTardanza($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Justificar tardanza del alumno",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'justificar:tardanza',
            'params'      => [$id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }


    public function justificarTardanza($params)
    {
        Asistencia::find($params[0])
            ->update([
                'tipo' => Asistencia::TARDANZA_JUSTIFICADA
            ]);


        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "La tardanza se ha justificado",
        ]);

        $this->obtenerAlumnosConAsistencias();
    }

    private function buscarPermiso() {}

    public function generarReporteAsistencia()
    {
        if (empty($this->nivel)) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error',
                'text'  => 'Debe seleccionar el nivel',
            ]);
            return;
        }

        try {
            // Si no hay grado seleccionado, generar reporte para todos los grados
            if (empty($this->grado)) {
                $datosReporte = $this->obtenerDatosReporteTodosGrados();
                $nombreArchivo = "reporte_asistencia_{$this->nivel}_todos_grados_{$this->anio_reporte}_{$this->mes_reporte}.pdf";
                $vista = 'pdfs.asistencia-todos-grados-mes';
            } else {
                $datosReporte = $this->obtenerDatosReporte();
                $nombreArchivo = "reporte_asistencia_{$this->nivel}_{$this->grado}_{$this->anio_reporte}_{$this->mes_reporte}.pdf";
                $vista = 'pdfs.asistencia-grado-mes';
            }

            $feriados = AsistenciaFeriado::whereYear('fecha_feriado', $this->anio_reporte)
                ->whereMonth('fecha_feriado', $this->mes_reporte)
                ->orderBy('fecha_feriado', 'ASC')
                ->get();

            $pdf = PDF::loadView($vista, compact('datosReporte', 'feriados'));

            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->stream();
            }, $nombreArchivo);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error',
                'text'  => 'Error al generar el reporte: ' . $e->getMessage(),
            ]);
        }
    }

    public function exportarExcelAsistencia()
    {
        if (empty($this->nivel)) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error',
                'text'  => 'Debe seleccionar el nivel',
            ]);
            return;
        }

        try {
            if (empty($this->grado)) {
                $datosReporte = $this->obtenerDatosReporteTodosGrados();
                $nombreArchivo = "reporte_asistencia_{$this->nivel}_todos_grados_{$this->anio_reporte}_{$this->mes_reporte}.xls";
                $vista = 'excel.asistencia-todos-grados-mes';
            } else {
                $datosReporte = $this->obtenerDatosReporte();
                $nombreArchivo = "reporte_asistencia_{$this->nivel}_{$this->grado}_{$this->anio_reporte}_{$this->mes_reporte}.xls";
                $vista = 'excel.asistencia-grado-mes';
            }

            $feriados = AsistenciaFeriado::whereYear('fecha_feriado', $this->anio_reporte)
                ->whereMonth('fecha_feriado', $this->mes_reporte)
                ->orderBy('fecha_feriado', 'ASC')
                ->get();

            $html = view($vista, compact('datosReporte', 'feriados'))->render();

            return response()->streamDownload(function () use ($html) {
                echo $html;
            }, $nombreArchivo, [
                'Content-Type' => 'application/vnd.ms-excel',
                'Content-Disposition' => 'attachment; filename="' . $nombreArchivo . '"',
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error',
                'text'  => 'Error al generar el reporte Excel: ' . $e->getMessage(),
            ]);
        }
    }

    private function obtenerDatosReporte()
    {
        $fechaInicio = "{$this->anio_reporte}-{$this->mes_reporte}-01";
        $diasDelMes = cal_days_in_month(CAL_GREGORIAN, $this->mes_reporte, $this->anio_reporte);
        $fechaFin = "{$this->anio_reporte}-{$this->mes_reporte}-{$diasDelMes}";

        // Obtener información del grado
        $gradoInfo = Grado::where('nivel', $this->nivel)
            ->where('numero', $this->grado)
            ->first();

        // Obtener solo los días laborables (lunes a viernes)
        $diasLaborables = [];
        for ($dia = 1; $dia <= $diasDelMes; $dia++) {
            $fecha = Carbon::createFromDate($this->anio_reporte, $this->mes_reporte, $dia);
            // Solo incluir días laborables (1=Lunes a 5=Viernes)
            if ($fecha->dayOfWeek >= 1 && $fecha->dayOfWeek <= 5) {
                $diasLaborables[] = $dia;
            }
        }

        // Construir query dinámico solo para días laborables
        $casosDias = '';
        $columnasDias = '';
        foreach ($diasLaborables as $dia) {
            $fecha = sprintf("%s-%02d-%02d", $this->anio_reporte, $this->mes_reporte, $dia);
            $casosDias .= "MAX(CASE WHEN ast.dia = '{$fecha}' THEN
            CASE
                WHEN ast.tipo = 'N' THEN 'A'
                WHEN ast.tipo = 'T' THEN 'T'
                WHEN ast.tipo = 'TJ' THEN 'U'
                WHEN ast.tipo = 'F' THEN 'FE'
                WHEN ast.tipo = 'FI' THEN 'F'
                WHEN ast.tipo = 'FJ' THEN 'J'
                ELSE '.'
            END
            ELSE '.'
        END) AS dia_{$dia},\n        ";
            $columnasDias .= "dia_{$dia}, ";
        }

        // Remover la última coma
        $casosDias = rtrim($casosDias, ",\n        ");
        $columnasDias = rtrim($columnasDias, ', ');

        $query = "
    SELECT
        CONCAT(a.apellido_paterno, ' ', COALESCE(a.apellido_materno, ''), ', ', a.nombres) AS nombre_completo,
        m.nivel,
        m.grado,
        {$casosDias}
    FROM alumnos a
    INNER JOIN matriculas m ON a.id = m.alumno_id
    LEFT JOIN asistencias ast ON a.id = ast.alumno_id
        AND ast.dia BETWEEN '{$fechaInicio}' AND '{$fechaFin}'
        AND DAYOFWEEK(ast.dia) BETWEEN 2 AND 6
    WHERE m.estado = 1
        AND m.nivel = '{$this->nivel}'
        AND m.grado = '{$this->grado}'
    GROUP BY a.id, a.apellido_paterno, a.apellido_materno, a.nombres, m.nivel, m.grado
    ORDER BY a.apellido_paterno, a.nombres
    ";

        $alumnos = DB::select($query);

        // Generar información de días de la semana solo para días laborables
        $diasSemana = [];
        foreach ($diasLaborables as $dia) {
            $fecha = Carbon::createFromDate($this->anio_reporte, $this->mes_reporte, $dia);
            $diasSemana[] = [
                'dia' => $dia,
                'letra' => ['D', 'L', 'M', 'X', 'J', 'V', 'S'][$fecha->dayOfWeek]
            ];
        }

        return [
            'alumnos' => $alumnos,
            'diasSemana' => $diasSemana,
            'diasLaborables' => $diasLaborables,
            'diasDelMes' => count($diasLaborables), // Ahora representa solo días laborables
            'gradoInfo' => $gradoInfo,
            'mes' => strtoupper($this->getNombreMes($this->mes_reporte)),
            'anio' => $this->anio_reporte,
            'fechaGeneracion' => now()->format('d/m/Y H:i:s')
        ];
    }

    private function obtenerDatosReporteTodosGrados()
    {
        $fechaInicio = "{$this->anio_reporte}-{$this->mes_reporte}-01";
        $diasDelMes = cal_days_in_month(CAL_GREGORIAN, $this->mes_reporte, $this->anio_reporte);
        $fechaFin = "{$this->anio_reporte}-{$this->mes_reporte}-{$diasDelMes}";

        // Obtener todos los grados del nivel seleccionado
        $grados = Grado::where('nivel', $this->nivel)
            ->orderBy('numero')
            ->get();

        // Obtener solo los días laborables (lunes a viernes)
        $diasLaborables = [];
        for ($dia = 1; $dia <= $diasDelMes; $dia++) {
            $fecha = Carbon::createFromDate($this->anio_reporte, $this->mes_reporte, $dia);
            // Solo incluir días laborables (1=Lunes a 5=Viernes)
            if ($fecha->dayOfWeek >= 1 && $fecha->dayOfWeek <= 5) {
                $diasLaborables[] = $dia;
            }
        }

        // Generar información de días de la semana solo para días laborables
        $diasSemana = [];
        foreach ($diasLaborables as $dia) {
            $fecha = Carbon::createFromDate($this->anio_reporte, $this->mes_reporte, $dia);
            $diasSemana[] = [
                'dia' => $dia,
                'letra' => ['D', 'L', 'M', 'X', 'J', 'V', 'S'][$fecha->dayOfWeek]
            ];
        }

        $datosGrados = [];

        foreach ($grados as $grado) {
            // Construir query dinámico solo para días laborables para cada grado
            $casosDias = '';
            foreach ($diasLaborables as $dia) {
                $fecha = sprintf("%s-%02d-%02d", $this->anio_reporte, $this->mes_reporte, $dia);
                $casosDias .= "MAX(CASE WHEN ast.dia = '{$fecha}' THEN
                CASE
                    WHEN ast.tipo = 'N' THEN 'A'
                    WHEN ast.tipo = 'T' THEN 'T'
                    WHEN ast.tipo = 'TJ' THEN 'U'
                    WHEN ast.tipo = 'F' THEN 'FE'
                    WHEN ast.tipo = 'FI' THEN 'F'
                    WHEN ast.tipo = 'FJ' THEN 'J'
                    ELSE '.'
                END
                ELSE '.'
            END) AS dia_{$dia},\n            ";
            }

            // Remover la última coma
            $casosDias = rtrim($casosDias, ",\n            ");

            $query = "
        SELECT
            CONCAT(a.apellido_paterno, ' ', COALESCE(a.apellido_materno, ''), ', ', a.nombres) AS nombre_completo,
            m.nivel,
            m.grado,
            {$casosDias}
        FROM alumnos a
        INNER JOIN matriculas m ON a.id = m.alumno_id
        LEFT JOIN asistencias ast ON a.id = ast.alumno_id
            AND ast.dia BETWEEN '{$fechaInicio}' AND '{$fechaFin}'
            AND DAYOFWEEK(ast.dia) BETWEEN 2 AND 6
        WHERE m.estado = 1
            AND m.nivel = '{$this->nivel}'
            AND m.grado = '{$grado->numero}'
        GROUP BY a.id, a.apellido_paterno, a.apellido_materno, a.nombres, m.nivel, m.grado
        ORDER BY a.apellido_paterno, a.nombres
        ";

            $alumnos = DB::select($query);

            // Solo agregar el grado si tiene alumnos
            if (!empty($alumnos)) {
                $datosGrados[] = [
                    'gradoInfo' => $grado,
                    'alumnos' => $alumnos
                ];
            }
        }

        return [
            'grados' => $datosGrados,
            'diasSemana' => $diasSemana,
            'diasLaborables' => $diasLaborables,
            'diasDelMes' => count($diasLaborables), // Ahora representa solo días laborables
            'mes' => strtoupper($this->getNombreMes($this->mes_reporte)),
            'anio' => $this->anio_reporte,
            'nivel' => $this->nivel,
            'fechaGeneracion' => now()->format('d/m/Y H:i:s')
        ];
    }

    private function getNombreMes($numeroMes)
    {
        $meses = [
            '01' => 'Enero',
            '02' => 'Febrero',
            '03' => 'Marzo',
            '04' => 'Abril',
            '05' => 'Mayo',
            '06' => 'Junio',
            '07' => 'Julio',
            '08' => 'Agosto',
            '09' => 'Septiembre',
            '10' => 'Octubre',
            '11' => 'Noviembre',
            '12' => 'Diciembre'
        ];

        return $meses[sprintf('%02d', $numeroMes)] ?? 'Mes';
    }



    public function render()
    {
        return view('livewire.dashboard.asistencias.index')
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

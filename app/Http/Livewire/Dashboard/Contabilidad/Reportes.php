<?php

namespace App\Http\Livewire\Dashboard\Contabilidad;

use PDF;
use App\Mail\RecordatorioPago;
use App\Models\CronogramaPagos;
use App\Models\Historial;
use App\Models\Matricula;
use App\Models\Pension;
use Livewire\Component;

class Reportes extends Component
{

    public function reporteDeudores()
    {
        $cronograma = CronogramaPagos::orderBy('orden', 'ASC')->get();
        $hoy = date('Y-m-d');
        $pagos = collect();
        $deudores = collect();
        //verificar quienes pagaron la pensión
        foreach ($cronograma as $crono) {
            if ($crono->vencimiento) {
                $pagadas = Pension::where('mes', $crono->mes)->where('estado', '<>', 2)->pluck('codigo_matricula');
                $item = new \stdClass();
                $item->mes = $crono->mes;
                $item->pagadas = $pagadas;
                $pagos->push($item);
            }
        }
        //buscar las matriculas que no ha pagado
        foreach ($pagos as $matPago) {
            $matriculas = Matricula::whereNotIn('codigo', $matPago->pagadas)
                ->when(auth()->user()->id == 4, function ($q) {
                    $q->where('codigo', '<>', 'IEPDS-61140703-2026');
                })
                ->where('estado', 1)
                ->orderBy('nivel', 'ASC')
                ->orderBy('grado', 'ASC')
                ->get();
            //dd($matriculas);

            foreach ($matriculas as $matricula) {
                $deudor  = $deudores->where('codigo', $matricula->codigo)->first();
                if ($deudor) {
                    array_push($deudor->meses, getMes($matPago->mes));
                    $deudor->total->push(['monto' => (CronogramaPagos::where('mes', $matPago->mes)->first())->costo]);
                } else {
                    $total = collect();
                    $ma = new \stdClass();
                    $ma->codigo = $matricula->codigo;
                    $ma->alumno = $matricula->alumno->nombre_completo;
                    $ma->nivel = $matricula->nivel;
                    $ma->grado = $matricula->grado;
                    $ma->order = $matricula->nivel . '-' . $matricula->grado;
                    $ma->meses = [getMes($matPago->mes)];
                    $ma->total = $total->push(['monto' => (CronogramaPagos::where('mes', $matPago->mes)->first())->costo]);
                    $deudores->push($ma);
                }
            }
        }

        if (count($deudores) == 0) {
            $this->emit('swal:modal', [
                'type'  => 'warning',
                'title' => 'No hay deudas',
                'text'  => 'No se han encontrado alumnos morosos hasta la fecha',
            ]);

            return;
        }

        $deudores = $deudores->sortBy('order');

        $fecha = date('d-m-Y');
        $pdf = PDF::loadView('pdfs.reporte-deudores', ['deudores' => $deudores], [],  ['format' => 'A4', 'orientation' => 'L']);
        Historial::create(['user_id' => auth()->user()->id, 'accion' => 'Generar reporte de deudores']);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "reporte-deudores-{$fecha}.pdf");
    }

    public function reporteDeudoresCSV()
    {
        $cronograma = CronogramaPagos::orderBy('orden', 'ASC')->get();
        $hoy = date('Y-m-d');
        $pagos = collect();
        $deudores = collect();
        //verificar quienes pagaron la pensión
        foreach ($cronograma as $crono) {
            if ($crono->vencimiento) {
                $pagadas = Pension::where('mes', $crono->mes)->where('estado', '<>', 2)->pluck('codigo_matricula');
                $item = new \stdClass();
                $item->mes = $crono->mes;
                $item->pagadas = $pagadas;
                $pagos->push($item);
            }
        }
        //buscar las matriculas que no ha pagado
        foreach ($pagos as $matPago) {
            $matriculas = Matricula::whereNotIn('codigo', $matPago->pagadas)
                ->when(auth()->user()->id == 4, function ($q) {
                    $q->where('codigo', '<>', 'IEPDS-61140703-2026');
                })
                ->where('estado', 1)
                ->orderBy('nivel', 'ASC')
                ->orderBy('grado', 'ASC')
                ->get();
            //dd($matriculas);

            foreach ($matriculas as $matricula) {
                $deudor  = $deudores->where('codigo', $matricula->codigo)->first();
                if ($deudor) {
                    array_push($deudor->meses, getMes($matPago->mes));
                    $deudor->total->push(['monto' => (CronogramaPagos::where('mes', $matPago->mes)->first())->costo]);
                } else {
                    $total = collect();
                    $ma = new \stdClass();
                    $ma->codigo = $matricula->codigo;
                    $ma->alumno = $matricula->alumno->nombre_completo;
                    $ma->distrito = $matricula->alumno->distrito->nombre;
                    $ma->madre = $matricula->alumno->padres()->where('parentesco', 'M')->first();
                    $ma->nivel = $matricula->nivel;
                    $ma->grado = $matricula->grado;
                    $ma->order = $matricula->nivel . '-' . $matricula->grado;
                    $ma->meses = [getMes($matPago->mes)];
                    $ma->total = $total->push(['monto' => (CronogramaPagos::where('mes', $matPago->mes)->first())->costo]);
                    $deudores->push($ma);
                }
            }
        }

        if (count($deudores) == 0) {
            $this->emit('swal:modal', [
                'type'  => 'warning',
                'title' => 'No hay deudas',
                'text'  => 'No se han encontrado alumnos morosos hasta la fecha',
            ]);

            return;
        }

        $deudores = $deudores->sortBy('order');

        $data = [['numero', 'nivel', 'grado', 'alumno', 'madre', 'direccion', 'correo', 'pensiones', 'total']];

        $i = 1;
        foreach ($deudores as $deudor) {
            $nivel = $deudor->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA';
            $grados = ['', 'PRIMERO', 'SEGUNDO', 'TERCERO', 'CUARTO', 'QUINTO', 'SEXTO'];
            $madre = $deudor->madre != null ?  $deudor->madre->apellidos . " " . ucwords(strtolower($deudor->madre->nombres)) : '';
            $direccion = $deudor->madre != null ?  $deudor->madre->domicilio . " - " . $deudor->distrito : '';
            $correo = $deudor->madre != null ?  strtolower($deudor->madre->correo_electronico) : '';
            array_push($data, [
                $i,
                $nivel,
                $grados[$deudor->grado],
                mb_convert_encoding($deudor->alumno, "UTF-8"),
                mb_convert_encoding($madre, "UTF-8"),
                mb_convert_encoding($direccion, "UTF-8"),
                $correo,
                implode(",", $deudor->meses),
                number_format($deudor->total->sum('monto'), 2, '.', ',')
            ]);
            ++$i;
        }



        $fp = fopen(public_path('output.csv'), 'wb');
        foreach ($data as $line) {
            fputcsv($fp, $line, ";");
        }
        fclose($fp);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="sample.csv"');
        return response()->download(public_path('output.csv'), 'reporte-deudores.csv')->deleteFileAfterSend();
    }

    public function resumenPagoGrados()
    {

        $meses = [
            ['mes' => '03', 'pagado' => null],
            ['mes' => '04', 'pagado' => null],
            ['mes' => '05', 'pagado' => null],
            ['mes' => '06', 'pagado' => null],
            ['mes' => '07', 'pagado' => null],
            ['mes' => '08', 'pagado' => null],
            ['mes' => '09', 'pagado' => null],
            ['mes' => '10', 'pagado' => null],
            ['mes' => '11', 'pagado' => null],
            ['mes' => '12', 'pagado' => null],
        ];


        $relacion = collect();

        //primaria

        for ($i = 1; $i <= 6; $i++) {
            $grado =  Matricula::where('matriculas.estado', 1)
                ->join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->where('matriculas.nivel', 'P')
                ->where('matriculas.grado', $i)
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'PRIMARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $pagos = [];
                    foreach ($meses as $mes) {
                        $pension = Pension::where('codigo_matricula', $matricula->codigo)
                            ->where('mes', $mes['mes'])
                            ->where('estado', '<>', 2)->first();
                        $mes['pagado'] = $pension ? $pension->estado : null;
                        array_push($pagos, $mes);
                    }

                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->meses =  $pagos;
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        //secundaria

        for ($i = 1; $i <= 5; $i++) {
            $grado =  Matricula::where('matriculas.estado', 1)
                ->join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->where('matriculas.nivel', 'S')
                ->where('matriculas.grado', $i)
                ->when(auth()->user()->id == 4, function ($q) {
                    $q->where('codigo', '<>', 'IEPDS-61140703-2026');
                })
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'SECUNDARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $pagos = [];
                    foreach ($meses as $mes) {
                        $pension = Pension::where('codigo_matricula', $matricula->codigo)
                            ->where('mes', $mes['mes'])
                            ->where('estado', '<>', 2)->first();
                        $mes['pagado'] = $pension ? $pension->estado : null;
                        array_push($pagos, $mes);
                    }

                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->meses =  $pagos;
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        $fecha = date('d-m-Y');
        $pdf = PDF::loadView('pdfs.resumen-pagos', ['relacion' => $relacion], [],  ['format' => 'A4', 'orientation' => 'L']);
        Historial::create(['user_id' => auth()->user()->id, 'accion' => 'Generar reporte de resumen de pagos']);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "reporte-resumen-de-pagos-{$fecha}.pdf");
    }

    public function render()
    {
        return view('livewire.dashboard.contabilidad.reportes')
            ->extends('layouts.panel')
            ->section('content');
    }
}

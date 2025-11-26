<?php

namespace App\Http\Livewire\Frontend;

use App\Mail\NuevaMatricula;
use App\Mail\NuevoPago;
use App\Mail\NuevoPagoPension;
use App\Models\CronogramaPagos;
use App\Models\Matricula;
use App\Models\Pago;
use App\Models\Pension;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Tools\Telegram;

class RegistrarPago extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $matricula;
    public $codigo;
    public $concepto = 'P';


    public $pago = [
        'concepto' => 'M',
        'tipo_pago' => '',
        'numero_operacion' => null,
        'monto_pagado' => null,
        'comprobante' => null,
        'fecha' => null
    ];


    public $pensiones = [];


    public $pagosPension = [];

    protected $listeners = ['goToStep'];

    public $rules = [
        'codigo' => 'required',
        'concepto' => 'required',

        'pago.tipo_pago' => 'required_if:concepto,M',
        'pago.numero_operacion' => 'required_if:concepto,M',
        'pago.fecha' => 'required_if:concepto,M|date_format:d/m/Y',
        'pago.monto_pagado' => 'required_if:concepto,M',
        'pago.comprobante' => 'required_if:concepto,M|image|max:2048',

        'pagosPension.*.mes' => 'required_if:concepto,P',
        'pagosPension.*.comprobante' => 'required_if:concepto,P|image|max:2048',
        'pagosPension.*.fecha_pago' => 'required_if:concepto,P|date',
    ];

    public $messages = [
        'codigo.required' => 'Debe ingresar el DNI del alumno',
        'concepto.required' => 'Debe seleccionar un concepto',

        'pago.tipo_pago.required_if' => 'Debe seleccionar el tipo de pago',
        'pago.numero_operacion.required_if' => 'Este campo es requerido',
        'pago.fecha.required_if' => 'Indique la fecha de pago',
        'pago.monto_pagado.required_if' => 'Debe ingresar el monto pagado',
        'pago.fecha.date_format' => 'El formato debe ser DD/MM/YYYY',
        'pago.comprobante.required_if' => 'Debe agregar una imagen del comprobante',
        'pago.comprobante.image' => 'Debe ser una imagen válida',
        'pago.comprobante.max' => 'La imagen no puede pesar más de 2MB',

        'pagosPension.*.mes.required_if' => 'Debe seleccionar el mes',
        'pagosPension.*.comprobante.required_if' => 'Debe agregar una imagen del comprobante',
        'pagosPension.*.comprobante.image' => 'Debe ser una imagen válida',
        'pagosPension.*.comprobante.max' => 'La imagen no puede pesar más de 2MB',
        'pagosPension.*.fecha_pago.required_if' => 'Indique la fecha de pago',
    ];

    public function mount()
    {

        $this->pagosPension = [
            [
                'mes' => '',
                'monto' => null,
                'comprobante' => null,
                'fecha_pago' => null
            ]
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field, $this->rules, $this->messages);
    }

    public function updatedPagosPension($value, $key)
    {
        $parts = explode('.', $key);
        $index = $parts[0];
        $campo = $parts[1] ?? '';


        if ($campo === 'mes') {
            $this->validarMesesDuplicados();
        }


        if ($campo === 'fecha_pago' && !empty($this->pagosPension[$index]['mes']) && !empty($this->pagosPension[$index]['fecha_pago'])) {
            $this->calcularMontoPension($index);
        }


        if ($campo === 'mes' && !empty($this->pagosPension[$index]['mes']) && !empty($this->pagosPension[$index]['fecha_pago'])) {
            $this->calcularMontoPension($index);
        }
    }


    private function validarMesesDuplicados()
    {
        $mesesSeleccionados = collect($this->pagosPension)->pluck('mes')->filter()->toArray();
        $mesesUnicos = array_unique($mesesSeleccionados);

        if (count($mesesSeleccionados) !== count($mesesUnicos)) {
            $this->emit('swal:alert', [
                'icon' => 'warning',
                'title' => 'Mes duplicado detectado',
                'timeout' => 3000
            ]);
        }
    }

    private function calcularMontoPension($index)
    {
        $costo = CronogramaPagos::where('mes', $this->pagosPension[$index]['mes'])->first();

        if (!$costo) return;

        $mesPago = strtotime($costo->fecha_vencimiento);
        $diaPago = strtotime($this->pagosPension[$index]['fecha_pago']);
        $previo = strtotime(date('Y-m-', $mesPago) . '26');

        if ($diaPago <= $previo) {
            $this->pagosPension[$index]['monto'] = $costo->pronto;
        } else {
            $this->pagosPension[$index]['monto'] = $costo->costo;
        }
    }

    public function buscarMatricula()
    {
        $this->validate(['codigo' => 'required'], ['codigo.required' => 'Debe ingresar el DNI']);

        try {
            $dni = trim($this->codigo);
            $COD = "IEPDS-{$dni}-2026";
            $this->matricula = Matricula::where('codigo', $COD)->first();

            if (!$this->matricula) {
                throw new \Exception("La matrícula con el DNI <b>{$dni}</b> no se ha encontrado, verifique e intente de nuevo");
            }


            if (Pago::where('codigo_matricula', $COD)->where('estado', '<>', 2)->exists()) {
                $this->concepto = 'P';
            }

            $this->step = 2;
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function seleccionarConcepto()
    {
        $this->validate(['concepto' => 'required']);

        $this->pensiones = [];

        if ($this->concepto == 'M') {
            $this->step = 3;
            $this->emit('paso:tres:pago');
        } else {

            $this->prepararPensionesDisponibles();
            $this->step = 3;
            $this->emit('paso:tres:pago');
        }
    }

    private function prepararPensionesDisponibles()
    {
        $cronograma = CronogramaPagos::orderBy('orden', 'ASC')->get();
        $pensionesExistentes = Pension::where('codigo_matricula', $this->matricula->codigo)->pluck('mes')->toArray();

        foreach ($cronograma as $crono) {
            $disabled = in_array($crono->mes, $pensionesExistentes);

            $item = [
                'value' => $crono->mes,
                'mes' => getMes($crono->mes),
                'costo' => $crono->costo,
                'pronto' => $crono->pronto,
                'disabled' => $disabled
            ];

            $this->pensiones[] = $item;
        }
    }

    public function agregarPago()
    {
        $this->pagosPension[] = [
            'mes' => '',
            'monto' => null,
            'comprobante' => null,
            'fecha_pago' => null
        ];
    }

    public function removerPago($index)
    {
        if (count($this->pagosPension) > 1) {
            unset($this->pagosPension[$index]);
            $this->pagosPension = array_values($this->pagosPension);
        }
    }

    public function registrarPagoMatricula()
    {
        $this->validate([
            'pago.tipo_pago' => 'required',
            'pago.numero_operacion' => 'required_unless:pago.tipo_pago,E',
            'pago.fecha' => 'required|date_format:d/m/Y',
            'pago.monto_pagado' => 'required',
            'pago.comprobante' => 'required|image|max:2048',
        ], $this->messages);

        try {
            $comprobanteName = strtoupper(Str::random(15)) . time() . "." . $this->pago['comprobante']->getClientOriginalExtension();
            $this->pago['comprobante']->storeAs("comprobantes", $comprobanteName);

            if (!Storage::exists("comprobantes/$comprobanteName")) {
                throw new \Exception('Ocurrió un error al subir el comprobante');
            }

            DB::beginTransaction();

            $pago = Pago::create([
                'estado' => 0,
                'concepto' => $this->pago['concepto'],
                'codigo_matricula' => $this->matricula->codigo,
                'tipo_pago' => $this->pago['tipo_pago'],
                'monto_pagado' => $this->pago['monto_pagado'],
                'numero_operacion' => $this->pago['numero_operacion'],
                'fecha_deposito' => date_to_datedb($this->pago['fecha'], "/"),
                'comprobante' => $comprobanteName,
            ]);

            DB::commit();

            $grado = $pago->matricula->nivel == 'P' ? 'PRIMARIA / ' . $pago->matricula->grado : 'SECUNDARIA / ' . $pago->matricula->grado;
            $mensaje = "Se ha generado un nuevo pago de matrícula en la plataforma:
<b>Matrícula COD:</b> {$pago->matricula->codigo}
<b>Alumno:</b> {$pago->matricula->alumno->nombre_completo}
<b>Nivel/Grado:</b> {$grado}";

            Telegram::meesage($mensaje);

            $this->step = 4;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function registrarPagosPension()
    {

        if (empty($this->pagosPension)) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Debe agregar al menos un mes de pensión',
            ]);
            return;
        }


        $pagosValidos = collect($this->pagosPension)->filter(function ($pago) {
            return !empty($pago['mes']) && !empty($pago['fecha_pago']) && !empty($pago['comprobante']);
        })->toArray();

        if (empty($pagosValidos)) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'Debe completar al menos un pago válido',
            ]);
            return;
        }


        foreach ($pagosValidos as $index => $pago) {
            $this->validate([
                "pagosPension.{$index}.mes" => 'required',
                "pagosPension.{$index}.comprobante" => 'required|image|max:2048',
                "pagosPension.{$index}.fecha_pago" => 'required|date',
            ], [
                "pagosPension.{$index}.mes.required" => "Debe seleccionar el mes para el pago " . ($index + 1),
                "pagosPension.{$index}.comprobante.required" => "Debe agregar comprobante para el pago " . ($index + 1),
                "pagosPension.{$index}.comprobante.image" => "El comprobante debe ser una imagen válida",
                "pagosPension.{$index}.comprobante.max" => "La imagen no puede pesar más de 2MB",
                "pagosPension.{$index}.fecha_pago.required" => "Indique la fecha de pago " . ($index + 1),
            ]);
        }


        $mesesSeleccionados = collect($pagosValidos)->pluck('mes')->toArray();
        if (count($mesesSeleccionados) !== count(array_unique($mesesSeleccionados))) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => 'No puede seleccionar el mismo mes más de una vez',
            ]);
            return;
        }

        try {
            DB::beginTransaction();

            $pensionesRegistradas = [];

            foreach ($pagosValidos as $index => $pago) {

                if (Pension::where('codigo_matricula', $this->matricula->codigo)
                    ->where('mes', $pago['mes'])
                    ->exists()
                ) {
                    throw new \Exception("La pensión del mes " . getMes($pago['mes']) . " ya está registrada");
                }


                $comprobanteName = "{$this->matricula->codigo}-{$pago['mes']}-{$this->matricula->anio}-" . time() . $index . ".{$pago['comprobante']->getClientOriginalExtension()}";
                $pago['comprobante']->storeAs("comprobantes", $comprobanteName);

                if (!Storage::exists("comprobantes/$comprobanteName")) {
                    throw new \Exception('Ocurrió un error al subir el comprobante del mes ' . getMes($pago['mes']));
                }


                $pension = Pension::create([
                    'estado' => 0,
                    'codigo_matricula' => $this->matricula->codigo,
                    'mes' => $pago['mes'],
                    'costo' => $pago['monto'],
                    'comprobante' => $comprobanteName,
                    'fecha_pago' => $pago['fecha_pago']
                ]);

                $pensionesRegistradas[] = $pension;
            }

            DB::commit();


            $grado = $this->matricula->nivel == 'P' ? 'PRIMARIA / ' . $this->matricula->grado : 'SECUNDARIA / ' . $this->matricula->grado;
            $mesesRegistrados = collect($pensionesRegistradas)->map(function ($p) {
                return getMes($p->mes) . ' (S./ ' . $p->costo . ')';
            })->implode(', ');

            $mensaje = "Se han registrado nuevos pagos de pensión:
<b>Matrícula COD:</b> {$this->matricula->codigo}
<b>Alumno:</b> {$this->matricula->alumno->nombre_completo}
<b>Nivel/Grado:</b> {$grado}
<b>Meses pagados:</b> {$mesesRegistrados}
<b>Total:</b> S./ " . collect($pensionesRegistradas)->sum('costo');

            Telegram::meesage($mensaje);




            $this->step = 4;
        } catch (\Exception $e) {
            DB::rollBack();
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function nuevoPago()
    {
        $this->reset(['pago', 'pagosPension', 'step', 'codigo', 'concepto', 'matricula', 'pensiones']);
        $this->mount();
    }

    public function goToStep($paso)
    {
        $this->step = $paso;

        if ($paso == 3 && $this->concepto == 'P') {
            $this->emit('paso:tres:pago');
        }
    }



    public function render()
    {
        return view('livewire.frontend.registrar-pago')
            ->extends('layouts.front-tailwind')
            ->section('content');
    }
}

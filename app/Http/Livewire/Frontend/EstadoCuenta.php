<?php

namespace App\Http\Livewire\Frontend;

use App\Models\CronogramaPagos;
use App\Models\Matricula;
use App\Models\Pension;
use Livewire\Component;

class EstadoCuenta extends Component
{
    public $matricula;
    public $codigo;
    public $step = 1;
    public $misPensiones;

    public function mount()
    {
        $this->misPensiones = collect();
    }

    public function buscarMatricula()
    {
        $this->validate(['codigo' => 'required'], ['codigo.required' => 'Debe ingresar el código']);

        try {

            $COD = trim($this->codigo);
            $this->matricula = Matricula::where('codigo', "IEPDS-{$COD}-2026")->first();

            if (!$this->matricula) {
                throw new \Exception("La matricula con el DNI <b>{$this->codigo}</b> no se ha encontrado, verifique el código e intente de nuevo");
            }

            $cronograma = CronogramaPagos::orderBy('orden', 'ASC')->get();


            foreach ($cronograma as $crono) {
                $pago = Pension::where('codigo_matricula', $this->matricula->codigo)->where('estado', '<>', 2)->where('mes', $crono->mes)->first();

                $item = new \stdClass();
                $item->orden = $crono->orden;
                $item->nombre = "Pensión del mes de " . getMes($crono->mes);
                $item->costo = $crono->costo;
                $item->estado = $pago ? $pago->estado : null;
                $item->vencido = $crono->vencimiento;
                $item->fecha_vencimiento = $crono->fecha_vencimiento;
                $item->fecha_pago = $pago ? $pago->fecha_pago : null;
                $item->comprobante = $pago ? $pago->comprobante : null;

                $this->misPensiones->push($item);
            }

            $this->step = 2;
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!!',
                'text' => $e->getMessage(),
                'timeout' => 3000
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.estado-cuenta')
            ->extends('layouts.front-tailwind')
            ->section('content');
    }
}

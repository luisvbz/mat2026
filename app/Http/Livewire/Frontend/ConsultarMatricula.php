<?php

namespace App\Http\Livewire\Frontend;

use PDF;
use App\Models\Matricula;
use Livewire\Component;

class ConsultarMatricula extends Component
{
    public $matricula;
    public $codigo;


    public function buscarMatricula()
    {
        $this->validate(['codigo' => 'required'], ['codigo.required' => 'Debe ingresar el código']);

        try {
            $dni = trim($this->codigo);
            $COD = "IEPDS-{$dni}-2026";
            $this->matricula = Matricula::where('codigo', $COD)->first();

            if (!$this->matricula) {
                throw new \Exception("La matricula con el DNI <b>{$dni}</b> no se ha encontrado, verifique el código e intente de nuevo");
            }
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!!',
                'text' => $e->getMessage(),
                'timeout' => 3000
            ]);
        }
    }

    public function descargarFicha()
    {

        $pdf = PDF::loadView('pdfs.ficha', ['matricula' => $this->matricula]);
        //dd($pdf);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "FICHA-{$this->matricula->codigo}.pdf");
    }

    public function render()
    {
        return view('livewire.frontend.consultar-matricula')
            ->extends('layouts.front')
            ->section('content');
    }
}

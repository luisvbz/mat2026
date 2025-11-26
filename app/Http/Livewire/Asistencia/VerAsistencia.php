<?php

namespace App\Http\Livewire\Asistencia;

use App\Models\Asistencia;
use Livewire\Component;
use App\Models\Matricula;

class VerAsistencia extends Component
{
    public $dni = '';
    public $matricula;
    public $mes = '';
    public $anio = '';
    public $meses = [];
    public $asistencias;
    public $step = 1;
    public $fi;
    public $fj;
    public $tardanzas;

    public function mount()
    {
        $this->mes = (int) date('m');
        $this->anio = 2026;
        $this->setMeses();
    }

    public function setMeses()
    {
        // Los meses del año escolar (marzo a diciembre)
        $meses = [
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        $mes_actual = (int) date('m');

        // Solo habilitar los meses desde marzo hasta el mes actual
        foreach ($meses as $numero => $nombre) {
            if ($numero >= 3 && $numero <= $mes_actual) {
                $this->meses[] = ['numero' => $numero, 'nombre' => $nombre];
            }
        }

        // Establecer el mes por defecto como el actual
        $this->mes = $mes_actual;
    }

    public function updatedMes()
    {
        $this->buscarAsistencias();
    }

    public function buscarMatricula()
    {
        $this->validate(['dni' => 'required'], ['codigo.required' => 'Debe ingresar el DNI']);

        try {

            $COD = trim($this->dni);
            $this->matricula = Matricula::where('codigo', "IEPDS-{$COD}-2026")->first();

            if (!$this->matricula) {
                throw new \Exception("La matricula con el DNI <b>{$this->dni}</b> no se ha encontrado, verifique el DNI e intente de nuevo");
            }

            $this->buscarAsistencias();

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

    public function buscarAsistencias()
    {

        $this->asistencias = $this->commonQuery()->get();
        $this->fi = $this->commonQuery()->where('tipo', 'FI')->count();
        $this->fj = $this->commonQuery()->where('tipo', 'FJ')->count();
        $this->tardanzas = $this->commonQuery()->where('tipo', 'T')->count();
    }

    private function commonQuery()
    {
        return Asistencia::where('alumno_id', $this->matricula->alumno_id)
            ->where('anio', $this->anio)
            ->where('mes', $this->mes)
            ->where('dia', '>', $this->matricula->created_at)
            ->orderBy('dia', 'ASC');
    }


    public function render()
    {
        return view('livewire.asistencia.ver-asistencia')
            ->extends('layouts.front-tailwind')
            ->section('content');
    }
}

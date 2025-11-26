<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Configuracion as ConfigGeneral;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Configuracion extends Component
{
    public $configuraciones = [];

    public function mount()
    {
        $congs = ConfigGeneral::all();
        $congs->each(function ($item){
            array_push($this->configuraciones, [
               'id' => $item->id,
               'key' => $item->key,
               'type' => $item->type,
               'valor' => $item->valor,
               'descripcion' => $item->descripcion
            ]);
        });
    }

    public function actualizarConfiguracion()
    {

        try {

            DB::beginTransaction();
                foreach ($this->configuraciones as $configuracion)
                {
                    ConfigGeneral::where('id', $configuracion['id'])
                        ->update(['valor' => $configuracion['valor']]);
                }
            DB::commit();

            $this->emit('swal:alert', [
                'icon'    => 'success',
                'title'   => 'La configuración se ha guardado con éxito!!',
                'timeout' => 10000
            ]);

        }catch (\Exception $e)
        {
            $this->emit('swal:alert', [
                'icon'    => 'error',
                'title'   => $e->getMessage(),
                'timeout' => 10000
            ]);
        }

    }

    public function render()
    {
        return view('livewire.dashboard.configuracion')
            ->extends('layouts.panel')
            ->section('content');
    }
}

<?php

namespace App\Http\Livewire\Dashboard\Contabilidad;

use App\Models\Matricula;
use App\Models\Pago;
use App\Models\Pension;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class PagosPensiones extends Component
{
    use WithPagination;

    public $search = '';
    public $fecha = '';
    public $estado = '';
    public $showComprobante = false;
    public $imagenComprobante = '';

    protected $queryString = [
        'estado' => ['except' => ''],
        'search' => ['except' => ''],
        'fecha' => ['except' => ''],
    ];

    protected $listeners = [
        'confirm:pago-pension' => 'confirmPagoPension',
        'eliminar:pago-pension' => 'eliminarPagoPension',
        'confirm:todas' => 'confirmarTodas'
    ];

    protected $paginationTheme = 'tailwind';

    public function buscar()
    {
        $this->render();
    }

    public function limpiar()
    {
        $this->reset(['search', 'estado', 'fecha']);
        $this->render();
    }

    public function verComprobante($comprobante)
    {
        $extension = explode(".", $comprobante);
        $image = base64_encode(Storage::get("comprobantes/$comprobante"));
        $image = "data:image/{$extension[1]};base64,{$image}";

        $this->imagenComprobante = $image;
        $this->emit('mostrar:comprobante:pension');
    }

    public function showDialogConfirm($id, $codigo)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta acción marcará el pago como confirmado",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'confirm:pago-pension',
            'params'      => [$id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function marcarTodas()
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta acción marcará todos los pagos pendientes como confirmados",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'confirm:todas',
            'params'      => [], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function confirmarTodas()
    {

        Pension::whereEstado(0)
            ->update(['estado' => 1]);

        $this->emit('swal:modal', [
            'type'  => 'success',
            'title' => 'Exito!!',
            'text'  => "Todos los pagos han sido confirmados",
        ]);

        $this->resetPage();
    }

    public function showDialogEliminarPago($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta opción elimina este registro para que el padre pueda agregarlo nuevamente si hubo error",
            'confirmText' => 'Sí, eliminar!',
            'method'      => 'eliminar:pago-pension',
            'params'      => [$id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function eliminarPagoPension($params)
    {
        $pension =  Pension::find($params[0]);

        if (Storage::delete("comprobantes/{$pension->comprobante}")) {
            $pension->delete();
            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "El pago se ha eliminado con éxito",
            ]);

            $this->render();
        }
    }

    public function confirmPagoPension($params)
    {
        try {

            Pension::find($params[0])->update(['estado' => 1]);

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "El pago se han confirmado",
            ]);

            $this->render();
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function anularPagoPension($params)
    {
        try {

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "El pago se ha anulado y la matricula se ha marcado como pendiente",
            ]);

            $this->render();
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function closeComprobante()
    {
        $this->reset(['showComprobante', 'imagenComprobante']);
    }

    public function render()
    {
        $pagos = Pension::when($this->estado != '', function ($q) {
            $q->where('estado', $this->estado);
        })
            ->when($this->search != '', function ($q) {
                $q->where('codigo_matricula', 'like', "%{$this->search}%");
            })
            ->when($this->fecha != '', function ($q) {
                $q->whereDate('fecha_pago', $this->fecha);
            })
            ->when(auth()->user()->id == 4, function ($q) {
                $q->where('codigo_matricula', '<>', 'IEPDS-61140703-2026');
            })
            ->orderBy('id', 'DESC')
            ->paginate(30);

        $totalRegistros = Pension::count();
        $totalPendientes = Pension::whereEstado(0)->count();
        $totalConfirmados = Pension::whereEstado(1)->count();
        $totalAnulados = Pension::whereEstado(2)->count();

        return view('livewire.dashboard.contabilidad.pagos-pensiones', [
            'pagos' => $pagos,
            'total' => $totalRegistros,
            'pendientes' => $totalPendientes,
            'confirmados' => $totalConfirmados,
            'anulados' => $totalAnulados
        ])
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

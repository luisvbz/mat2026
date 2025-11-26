<?php

namespace App\Http\Livewire\Dashboard;

use PDF;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Solicitudes extends Component
{
    use WithPagination;
    public $search = '';
    public $estado = '';
    public $showComprobante = false;
    public $imagenComprobante = '';

    protected $queryString = [
      'search' => ['except' => ''],
      'estado' => ['except' => ''],
    ];

    protected $listeners = [
        'confirm:atender' => 'confirmar'
    ];

    public function paginationView()
    {
        return 'bulma-pagination';
    }

    public function buscar()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->reset(['search', 'estado']);
        $this->resetPage();
    }

    public function verComprobante($comprobante)
    {
        return Storage::download("comprobantes/$comprobante");
        /*
        $extension = explode(".", $comprobante);
        $ext = $extension[1] == 'jpg' ? 'jpeg' : $extension[1];
        $image = base64_encode(Storage::get("comprobantes/$comprobante"));
        $image = "data:image/{$ext};base64,{$image}";
        
        dd($image);
        $this->imagenComprobante = $image;
        $this->emit('mostrar:comprobante')
        ;*/
    }

    public function showDialogConfirmSolicitud($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta acción marcará la solicitud como atendida",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'confirm:atender',
            'params'      => [$id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function confirmar($params)
    {
        try {

            Solicitud::find($params[0])->update(['estado' => 1]);

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "La solicitud has si marcada como atendida",
            ]);

            $this->resetPage();

        } catch (\Exception $e)
        {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function descargarFicha($id)
    {

        $solicitud = Solicitud::find($id);
        $pdf = PDF::loadView('pdfs.solicitud-documentos', ['solicitud' => $solicitud]);
        $slug = Str::slug($solicitud->nombre_solicitante);
        $fileName = "SOLICITUD-{$slug}.pdf";
        return response()->streamDownload(function () use($pdf){
            echo $pdf->stream();
        }, $fileName);
    }

    public function render()
    {
        $pendientes = Solicitud::whereEstado(0)->count();
        $atendidas = Solicitud::whereEstado(1)->count();
        $total = Solicitud::count();
        $solicitudes = Solicitud::withCount('documentos')
                        ->when($this->estado != '', function ($q)
                        {
                            $q->where('estado', $this->estado);
                        })
                        ->orderBy('id', 'DESC')
                        ->paginate(20);

        return view('livewire.dashboard.solicitudes', [
                'solicitudes' => $solicitudes,
                'total' => $total,
                'pendientes' => $pendientes,
                'atendidas' => $atendidas])
            ->extends('layouts.panel')
            ->section('content');
    }
}

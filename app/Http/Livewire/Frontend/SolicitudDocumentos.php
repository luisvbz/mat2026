<?php

namespace App\Http\Livewire\Frontend;

use App\Mail\NuevaMatricula;
use App\Mail\NuevaSolicitud;
use DB;
use App\Models\TipoDocumento;
use App\Models\Solicitud;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class SolicitudDocumentos extends Component
{

    use WithFileUploads;
    public $tipos;

    public $form = [
        'is_apoderado' => false,
        'tipo_ducumento_solicitante' => 0,
        'numero_documento_solicitante' => '',
        'nombre_solicitante' => '',
        'tipo_documento_alumno' => 0,
        'numero_documento_alumno' => '',
        'nombre_alumno' => '',
        'telefono_celular' => '',
        'correo_electronico' => '',
        'documentos' => [],
        'archivo' => null
    ];

    public $rules = [
        'form.numero_documento_solicitante' => 'required|numeric',
        'form.nombre_solicitante' => 'required',
        'form.numero_documento_alumno' => 'required_if:form.is_apoderado,true|numeric',
        'form.nombre_alumno' => 'required_if:form.is_apoderado,true',
        'form.telefono_celular' => 'required|digits:9',
        'form.correo_electronico' => 'required|email',
        'form.documentos' => 'required',
        'form.archivo' => 'required|image|max:2048',
    ];

    public $messages = [
        'form.numero_documento_solicitante.required' => 'Debe llenar este campo',
        'form.numero_documento_solicitante.numeric' => 'Solo puede ingresa números',
        'form.nombre_solicitante.required' => 'Debe llenar este campo',
        'form.numero_documento_alumno.required_if' => 'Debe llenar este campo',
        'form.numero_documento_alumno.numeric' => 'Solo puede ingresa números',
        'form.nombre_alumno.required_if' => 'Debe llenar este campo',
        'form.telefono_celular.required' => 'Debe llenar este campo',
        'form.telefono_celular.digits' => 'Debe ingresar 9 dígitos',
        'form.correo_electronico.required' => 'Debe llenar este campo',
        'form.correo_electronico.email' => 'Debe ingresar un correo válido',
        'form.documentos.required' => 'Debe seleccionar al menos un documento',
        'form.archivo.required' => 'Debe adjuntar el voucher de pago',
        'form.archivo.image' => 'Solo se permite imagenes',
        'form.archivo.max' => 'Maximo 2MB',

    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function mount()
    {
        $this->tipos = TipoDocumento::all();
    }

    public function enviarSolicitud()
    {
        $this->validate();

        try {
            $voucherName = Str::random(20).time().".".$this->form['archivo']->getClientOriginalExtension();
            $this->form['archivo']->storeAs("comprobantes",$voucherName);

            if(!Storage::exists("comprobantes/$voucherName"))
            {
                throw new \Exception('Ocurrio un error al subir el comprobante');
            }

            DB::beginTransaction();
            $solicitud = Solicitud::create([
                'estado' => 0,
                'is_apoderado' => $this->form['is_apoderado'],
                'tipo_documento_solicitante' => $this->form['tipo_ducumento_solicitante'],
                'numero_documento_solicitante' => $this->form['numero_documento_solicitante'],
                'nombre_solicitante' => strtoupper($this->form['nombre_solicitante']),
                'tipo_documento_alumno' => $this->form['is_apoderado'] ? $this->form['tipo_documento_alumno'] : null,
                'numero_documento_alumno' => $this->form['is_apoderado'] ? $this->form['numero_documento_alumno'] : null,
                'nombre_alumno' => $this->form['is_apoderado'] ? strtoupper($this->form['nombre_alumno']) : null,
                'numero_celular' => $this->form['telefono_celular'],
                'correo_electronico' => $this->form['correo_electronico'],
                'voucher' => $voucherName,
            ]);

            $solicitud->documentos()->sync($this->form['documentos']);

            DB::commit();

          Mail::to('divinosalvador20072@gmail.com')->cc('brendaquerevalu40@gmail.com')->send(new NuevaSolicitud($solicitud));
         // Mail::to('divinosalvador20072@gmail.com')->cc('ycns1093@gmail.com')->send(new NuevaSolicitud($solicitud));

            $this->reset(['form']);


            $this->emit('swal:modal', [
                'icon' => 'success',
                'title' => 'Exito!!',
                'text' => 'Su solicitud fue registrada con éxito, pronto te contactaremos!',
                'timeout' => 5000
            ]);

        }catch(\Exception $e)
        {
            $this->emit('swal:modal', [
                'icon' => 'error',
                'title' => 'Error!!',
                'text' => $e->getMessage(),
                'timeout' => 5000
            ]);
        }
    }

    public function render()
    {
        return view('livewire.frontend.solicitud-documentos')
                ->extends('layouts.front')
                ->section('content');
    }
}


<?php

namespace App\Http\Livewire\Frontend;

use Livewire\Component;
use App\Models\Reclamo;
use App\Mail\ReclamoRegistrado;
use App\Mail\ReclamoNotificacion;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LibroReclamaciones extends Component
{
    public $form = [

        'tipoReclamo' => '',
        'fechaIncidente' => '',


        'nombre' => '',
        'apellido' => '',
        'tipoDocumento' => '',
        'numeroDocumento' => '',
        'direccion' => '',
        'departamento' => '',
        'provincia' => '',
        'distrito' => '',
        'telefono' => '',
        'email' => '',


        'esMenorEdad' => false,
        'nombreApoderado' => '',
        'apellidoApoderado' => '',
        'dniApoderado' => '',
        'telefonoApoderado' => '',


        'tipoBien' => '',
        'descripcionBien' => '',
        'montoReclamado' => '',
        'moneda' => 'soles',


        'detalleReclamo' => '',
        'pedido' => '',


        'observaciones' => '',
        'acciones' => '',


        'aceptoTerminos' => false,
    ];

    public $showSuccess = false;
    public $numeroRegistro = '';

    protected $rules = [

        'form.tipoReclamo' => 'required|in:reclamo,queja',
        'form.fechaIncidente' => 'required|date|before_or_equal:today',


        'form.nombre' => 'required|string|min:2|max:100',
        'form.apellido' => 'required|string|min:2|max:100',
        'form.tipoDocumento' => 'required|in:dni,ce,pasaporte,ruc',
        'form.numeroDocumento' => 'required|string|min:8|max:15',
        'form.direccion' => 'required|string|min:10|max:255',
        'form.departamento' => 'required|string|max:100',
        'form.provincia' => 'required|string|max:100',
        'form.distrito' => 'required|string|max:100',
        'form.telefono' => 'nullable|string|min:7|max:15',
        'form.email' => 'required|email|max:255',


        'form.esMenorEdad' => 'boolean',
        'form.nombreApoderado' => 'required_if:form.esMenorEdad,true|nullable|string|min:2|max:100',
        'form.apellidoApoderado' => 'required_if:form.esMenorEdad,true|nullable|string|min:2|max:100',
        'form.dniApoderado' => 'required_if:form.esMenorEdad,true|nullable|string|size:8',
        'form.telefonoApoderado' => 'nullable|string|min:7|max:15',


        'form.tipoBien' => 'required|string|max:100',
        'form.descripcionBien' => 'required|string|min:10|max:1000',
        'form.montoReclamado' => 'nullable|numeric|min:0|max:999999.99',
        'form.moneda' => 'required|in:soles,dolares',


        'form.detalleReclamo' => 'required|string|min:20|max:2000',
        'form.pedido' => 'required|string|min:10|max:1000',


        'form.observaciones' => 'nullable|string|max:1000',


        'form.aceptoTerminos' => 'accepted',
    ];

    protected $messages = [

        'form.tipoReclamo.required' => 'Debe seleccionar el tipo de reclamo.',
        'form.tipoReclamo.in' => 'El tipo de reclamo seleccionado no es válido.',
        'form.fechaIncidente.required' => 'La fecha del incidente es obligatoria.',
        'form.fechaIncidente.date' => 'La fecha del incidente debe ser una fecha válida.',
        'form.fechaIncidente.before_or_equal' => 'La fecha del incidente no puede ser posterior a hoy.',


        'form.nombre.required' => 'El nombre es obligatorio.',
        'form.nombre.min' => 'El nombre debe tener al menos 2 caracteres.',
        'form.nombre.max' => 'El nombre no puede exceder 100 caracteres.',
        'form.apellido.required' => 'El apellido es obligatorio.',
        'form.apellido.min' => 'El apellido debe tener al menos 2 caracteres.',
        'form.apellido.max' => 'El apellido no puede exceder 100 caracteres.',
        'form.tipoDocumento.required' => 'Debe seleccionar el tipo de documento.',
        'form.tipoDocumento.in' => 'El tipo de documento seleccionado no es válido.',
        'form.numeroDocumento.required' => 'El número de documento es obligatorio.',
        'form.numeroDocumento.min' => 'El número de documento debe tener al menos 8 caracteres.',
        'form.numeroDocumento.max' => 'El número de documento no puede exceder 15 caracteres.',
        'form.direccion.required' => 'La dirección es obligatoria.',
        'form.direccion.min' => 'La dirección debe tener al menos 10 caracteres.',
        'form.direccion.max' => 'La dirección no puede exceder 255 caracteres.',
        'form.departamento.required' => 'El departamento es obligatorio.',
        'form.provincia.required' => 'La provincia es obligatoria.',
        'form.distrito.required' => 'El distrito es obligatorio.',
        'form.telefono.min' => 'El teléfono debe tener al menos 7 dígitos.',
        'form.telefono.max' => 'El teléfono no puede exceder 15 dígitos.',
        'form.email.required' => 'El correo electrónico es obligatorio.',
        'form.email.email' => 'El correo electrónico debe ser válido.',


        'form.nombreApoderado.required_if' => 'El nombre del apoderado es obligatorio para menores de edad.',
        'form.apellidoApoderado.required_if' => 'El apellido del apoderado es obligatorio para menores de edad.',
        'form.dniApoderado.required_if' => 'El DNI del apoderado es obligatorio para menores de edad.',
        'form.dniApoderado.size' => 'El DNI del apoderado debe tener exactamente 8 dígitos.',


        'form.tipoBien.required' => 'Debe seleccionar el tipo de bien o servicio.',
        'form.descripcionBien.required' => 'La descripción del bien o servicio es obligatoria.',
        'form.descripcionBien.min' => 'La descripción debe tener al menos 10 caracteres.',
        'form.descripcionBien.max' => 'La descripción no puede exceder 1000 caracteres.',
        'form.montoReclamado.numeric' => 'El monto debe ser un número válido.',
        'form.montoReclamado.min' => 'El monto no puede ser negativo.',
        'form.montoReclamado.max' => 'El monto no puede exceder 999,999.99.',


        'form.detalleReclamo.required' => 'El detalle del reclamo es obligatorio.',
        'form.detalleReclamo.min' => 'El detalle debe tener al menos 20 caracteres.',
        'form.detalleReclamo.max' => 'El detalle no puede exceder 2000 caracteres.',
        'form.pedido.required' => 'El pedido es obligatorio.',
        'form.pedido.min' => 'El pedido debe tener al menos 10 caracteres.',
        'form.pedido.max' => 'El pedido no puede exceder 1000 caracteres.',


        'form.observaciones.max' => 'Las observaciones no pueden exceder 1000 caracteres.',


        'form.aceptoTerminos.accepted' => 'Debe aceptar la política de privacidad y tratamiento de datos personales.',
    ];

    public function mount()
    {
        $this->form['fechaIncidente'] = now()->format('Y-m-d');
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        try {
            DB::beginTransaction();


            $reclamo = Reclamo::create([
                'tipo_reclamo' => $this->form['tipoReclamo'],
                'fecha_incidente' => $this->form['fechaIncidente'],
                'nombre' => $this->form['nombre'],
                'apellido' => $this->form['apellido'],
                'tipo_documento' => $this->form['tipoDocumento'],
                'numero_documento' => $this->form['numeroDocumento'],
                'direccion' => $this->form['direccion'],
                'departamento' => $this->form['departamento'],
                'provincia' => $this->form['provincia'],
                'distrito' => $this->form['distrito'],
                'telefono' => $this->form['telefono'],
                'email' => $this->form['email'],
                'es_menor_edad' => $this->form['esMenorEdad'],
                'nombre_apoderado' => $this->form['nombreApoderado'],
                'apellido_apoderado' => $this->form['apellidoApoderado'],
                'dni_apoderado' => $this->form['dniApoderado'],
                'telefono_apoderado' => $this->form['telefonoApoderado'],
                'tipo_bien' => $this->form['tipoBien'],
                'descripcion_bien' => $this->form['descripcionBien'],
                'monto_reclamado' => $this->form['montoReclamado'] ?: null,
                'moneda' => $this->form['moneda'],
                'detalle_reclamo' => $this->form['detalleReclamo'],
                'pedido' => $this->form['pedido'],
                'observaciones' => $this->form['observaciones'],
                'acepto_terminos' => $this->form['aceptoTerminos'],
            ]);


            $this->enviarCorreos($reclamo);

            DB::commit();


            $this->numeroRegistro = $reclamo->numero_registro;
            $this->showSuccess = true;


            $this->resetForm();


            $this->dispatchBrowserEvent('scroll-to-top');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al crear reclamo: ' . $e->getMessage());

            session()->flash('error', 'Ocurrió un error al procesar su reclamo. Por favor, inténtelo nuevamente.');
        }
    }

    private function enviarCorreos($reclamo)
    {
        try {

            Mail::to($reclamo->email)->send(new ReclamoRegistrado($reclamo));


            $adminEmail = "divinosalvador_456@hotmail.com";
            Mail::to($adminEmail)->send(new ReclamoNotificacion($reclamo));
        } catch (\Exception $e) {
            Log::error('Error al enviar correos de reclamo: ' . $e->getMessage());
        }
    }

    public function limpiarFormulario()
    {
        $this->resetForm();
        $this->resetErrorBag();
        $this->showSuccess = false;
        session()->flash('message', 'Formulario limpiado correctamente.');
    }

    private function resetForm()
    {
        $this->form = [
            'tipoReclamo' => '',
            'fechaIncidente' => now()->format('Y-m-d'),
            'nombre' => '',
            'apellido' => '',
            'tipoDocumento' => '',
            'numeroDocumento' => '',
            'direccion' => '',
            'departamento' => '',
            'provincia' => '',
            'distrito' => '',
            'telefono' => '',
            'email' => '',
            'esMenorEdad' => false,
            'nombreApoderado' => '',
            'apellidoApoderado' => '',
            'dniApoderado' => '',
            'telefonoApoderado' => '',
            'tipoBien' => '',
            'descripcionBien' => '',
            'montoReclamado' => '',
            'moneda' => 'soles',
            'detalleReclamo' => '',
            'pedido' => '',
            'observaciones' => '',
            'acciones' => '',
            'aceptoTerminos' => false,
        ];
    }

    public function cerrarExito()
    {
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.frontend.libro-reclamaciones')
            ->extends('layouts.front-tailwind')
            ->section('content');
    }
}
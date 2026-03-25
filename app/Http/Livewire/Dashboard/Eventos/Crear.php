<?php

namespace App\Http\Livewire\Dashboard\Eventos;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;

class Crear extends Component
{
    use WithFileUploads;

    public $date;
    public $time;
    public $description;
    public $type = 'actividad';
    public $link;
    public $attachment;

    protected $rules = [
        'date' => 'required|date',
        'time' => 'required',
        'description' => 'required|string',
        'type' => 'required|string',
        'link' => 'nullable|url',
        'attachment' => 'nullable|file|max:10240', // 10MB
    ];

    protected $messages = [
        'date.required' => 'La fecha es obligatoria',
        'time.required' => 'La hora es obligatoria',
        'description.required' => 'La descripción es obligatoria',
        'attachment.max' => 'El archivo no debe superar los 10MB',
        'link.url' => 'El enlace debe ser una URL válida',
    ];

    public function render()
    {
        return view('livewire.dashboard.eventos.crear')
            ->extends('layouts.tailwind')
            ->section('content');
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'date' => $this->date,
                'time' => $this->time,
                'description' => $this->description,
                'type' => $this->type,
                'link' => $this->link,
                'created_by' => auth()->id(),
            ];

            if ($this->attachment) {
                $destinationPath = public_path('files-events');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $filename = time() . '_' . $this->attachment->getClientOriginalName();
                $this->attachment->storeAs('public/temp', $filename);
                
                // Move to public directory
                copy(storage_path('app/public/temp/' . $filename), $destinationPath . '/' . $filename);
                unlink(storage_path('app/public/temp/' . $filename));
                
                $data['attachment'] = 'files-events/' . $filename;
            }

            Event::create($data);

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => 'Evento creado exitosamente',
                'timeout' => 3000
            ]);

            return redirect()->route('dashboard.eventos');
        } catch (\Exception $e) {
            $this->emit('swal:alert', [
                'icon' => 'error',
                'title' => 'Error al guardar el evento: ' . $e->getMessage(),
                'timeout' => 5000
            ]);
        }
    }

    public function cancel()
    {
        return redirect()->route('dashboard.eventos');
    }
}

<?php

namespace App\Http\Livewire\Dashboard\Eventos;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithFileUploads;

class Editar extends Component
{
    use WithFileUploads;

    public $eventId;
    public $date;
    public $time;
    public $description;
    public $type;
    public $link;
    public $attachment;
    public $currentAttachment;

    protected $rules = [
        'date' => 'required|date',
        'time' => 'required',
        'description' => 'required|string',
        'type' => 'required|string',
        'link' => 'nullable|url',
        'attachment' => 'nullable|file|max:10240',
    ];

    public function mount($id)
    {
        $event = Event::findOrFail($id);
        $this->eventId = $event->id;
        $this->date = $event->date->format('Y-m-d');
        $this->time = $event->time->format('H:i');
        $this->description = $event->description;
        $this->type = $event->type;
        $this->link = $event->link;
        $this->currentAttachment = $event->attachment;
    }

    public function render()
    {
        return view('livewire.dashboard.eventos.editar')
            ->extends('layouts.dashboard')
            ->section('content');
    }

    public function save()
    {
        $this->validate();

        try {
            $event = Event::findOrFail($this->eventId);
            
            $data = [
                'date' => $this->date,
                'time' => $this->time,
                'description' => $this->description,
                'type' => $this->type,
                'link' => $this->link,
            ];

            if ($this->attachment) {
                // Delete old attachment
                if ($event->attachment && file_exists(public_path($event->attachment))) {
                    unlink(public_path($event->attachment));
                }

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

            $event->update($data);

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => 'Evento actualizado exitosamente',
                'timeout' => 3000
            ]);

            return redirect()->route('dashboard.eventos');
        } catch (\Exception $e) {
            $this->emit('swal:alert', [
                'icon' => 'error',
                'title' => 'Error al actualizar el evento: ' . $e->getMessage(),
                'timeout' => 5000
            ]);
        }
    }

    public function cancel()
    {
        return redirect()->route('dashboard.eventos');
    }
}

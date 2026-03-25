<?php

namespace App\Http\Livewire\Dashboard\Eventos;

use App\Models\Event;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $events = Event::where('description', 'like', '%' . $this->search . '%')
            ->orWhere('type', 'like', '%' . $this->search . '%')
            ->orderBy('date', 'desc')
            ->orderBy('time', 'desc')
            ->paginate(10);

        return view('livewire.dashboard.eventos.index', [
            'events' => $events
        ])
        ->extends('layouts.tailwind')
        ->section('content');
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        
        // Delete attachment if exists
        if ($event->attachment && file_exists(public_path($event->attachment))) {
            unlink(public_path($event->attachment));
        }

        $event->delete();

        $this->emit('swal:alert', [
            'icon' => 'success',
            'title' => 'Evento eliminado exitosamente',
            'timeout' => 3000
        ]);
    }
}

<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Communication;
use App\Models\CommunicationAttachment;
use App\Models\Player;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Comunicados extends Component
{
    use WithFileUploads;

    // Modal states
    public $deleteConfirmId = null;

    // Filters
    public $filterCategory = '';
    public $filterPublished = '';
    public $search = '';

    public function mount()
    {
        //
    }

    public function render()
    {
        $communications = Communication::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterCategory, function ($query) {
                $query->where('category', $this->filterCategory);
            })
            ->when($this->filterPublished !== '', function ($query) {
                $query->where('is_published', $this->filterPublished);
            })
            ->with('attachments')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view('livewire.dashboard.comunicados', [
            'communications' => $communications
        ])
            ->extends('layouts.dashboard')
            ->section('content');
    }

    public function create()
    {
        return redirect()->route('dashboard.comunicados.crear');
    }

    public function edit($id)
    {
        return redirect()->route('dashboard.comunicados.editar', $id);
    }

    public function togglePublish($id)
    {
        try {
            $communication = Communication::findOrFail($id);
            $communication->is_published = !$communication->is_published;

            if ($communication->is_published && !$communication->published_at) {
                $communication->published_at = now();
            }

            $communication->save();

            if ($communication->is_published) {
                $parents = \App\Models\ParentUser::where('is_active', true)->get();
                foreach ($parents as $parent) {
                    if ($parent->padre->correo_electronico) {
                        \Illuminate\Support\Facades\Mail::to($parent->padre->correo_electronico)->queue(new \App\Mail\NuevoComunicado($communication));
                    }
                }

                $playerIds = Player::where('role', 'parent')->get()->pluck('player_id')->toArray();

                if (!empty($playerIds)) {
                    $oneSignal = new \App\Tools\OneSignalService();
                    $oneSignal->sendToPlayers(
                        $playerIds,
                        'Nuevo Comunicado',
                        "Nuevo comunicado publicado en la app.",
                        "https://app.iepdivinosalvador.net.pe/comunicados/{$communication->id}"
                    );
                }
            }

            $status = $communication->is_published ? 'publicado' : 'despublicado';

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => "Comunicado {$status} exitosamente",
                'timeout' => 3000
            ]);
        } catch (\Exception $e) {
            $this->emit('swal:alert', [
                'icon' => 'error',
                'title' => 'Error al cambiar el estado',
                'timeout' => 5000
            ]);
        }
    }

    public function confirmDelete($id)
    {
        $this->deleteConfirmId = $id;
    }

    public function delete()
    {
        try {
            $communication = Communication::findOrFail($this->deleteConfirmId);

            // Delete all attachments
            foreach ($communication->attachments as $attachment) {
                $fullPath = public_path($attachment->url);
                if (file_exists($fullPath)) {
                    unlink($fullPath);
                }
                $attachment->delete();
            }

            $communication->delete();

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => 'Comunicado eliminado exitosamente',
                'timeout' => 3000
            ]);

            $this->deleteConfirmId = null;
        } catch (\Exception $e) {
            $this->emit('swal:alert', [
                'icon' => 'error',
                'title' => 'Error al eliminar el comunicado',
                'timeout' => 5000
            ]);
        }
    }


}
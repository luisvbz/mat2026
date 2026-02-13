<?php

namespace App\Http\Livewire\Dashboard\Comunicados;

use App\Models\Communication;
use App\Models\CommunicationAttachment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Crear extends Component
{
    use WithFileUploads;

    // Form fields
    public $title;
    public $content;
    public $category = 'general';
    public $is_published = false;
    public $published_at;

    // File uploads
    public $attachments = [];

    protected $rules = [
        'title' => 'required|string|max:191',
        'content' => 'required|string',
        'category' => 'required|in:general,academico,administrativo,evento,urgente,cobro,actividad,otro',
        'is_published' => 'boolean',
        'published_at' => 'nullable|date',
        'attachments.*' => 'nullable|file|max:10240', // 10MB max
    ];

    protected $messages = [
        'title.required' => 'El título es obligatorio',
        'content.required' => 'El contenido es obligatorio',
        'category.required' => 'La categoría es obligatoria',
        'attachments.*.max' => 'Cada archivo no debe superar 10MB',
    ];

    public function render()
    {
        return view('livewire.dashboard.comunicados.crear')
            ->extends('layouts.dashboard')
            ->section('content');
    }

    public function save()
    {
        $this->validate();

        try {
            $data = [
                'title' => $this->title,
                'content' => $this->content,
                'category' => $this->category,
                'is_published' => $this->is_published,
                'published_at' => $this->published_at,
                'author_id' => auth()->id(),
                'author_name' => auth()->user()->name,
            ];

            $communication = Communication::create($data);

            // Handle attachments
            if (!empty($this->attachments)) {
                $destinationPath = public_path('files-comunications');
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                foreach ($this->attachments as $file) {
                    $filename = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/temp', $filename); // Livewire temp store
                    
                    // Move to public directory
                    copy(storage_path('app/public/temp/' . $filename), $destinationPath . '/' . $filename);
                    unlink(storage_path('app/public/temp/' . $filename));
                    
                    $path = 'files-comunications/' . $filename;
                    
                    CommunicationAttachment::create([
                        'communication_id' => $communication->id,
                        'name' => $file->getClientOriginalName(),
                        'url' => $path,
                        'type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            // Send email notifications to parents if published
            if ($communication->is_published) {
                $parents = \App\Models\ParentUser::where('is_active', true)
                    ->get();
                foreach ($parents as $parent) {
                    if ($parent->padre->correo_electronico) {
                        \Illuminate\Support\Facades\Mail::to($parent->padre->correo_electronico)->queue(new \App\Mail\NuevoComunicado($communication));
                    }
                }
            }

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => 'Comunicado creado exitosamente',
                'timeout' => 3000
            ]);

            return redirect()->route('dashboard.comunicados');
        } catch (\Exception $e) {
            $this->emit('swal:alert', [
                'icon' => 'error',
                'title' => 'Error al guardar el comunicado: ' . $e->getMessage(),
                'timeout' => 5000
            ]);
        }
    }

    public function cancel()
    {
        return redirect()->route('dashboard.comunicados');
    }

    public function updatedAttachments()
    {
        $this->validate([
            'attachments.*' => 'file|max:10240',
        ]);
    }
}

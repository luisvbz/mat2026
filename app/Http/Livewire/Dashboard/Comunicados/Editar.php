<?php

namespace App\Http\Livewire\Dashboard\Comunicados;

use App\Models\Communication;
use App\Models\CommunicationAttachment;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class Editar extends Component
{
    use WithFileUploads;

    public $communicationId;

    // Form fields
    public $title;
    public $content;
    public $category = 'general';
    public $is_published = false;
    public $published_at;

    // File uploads
    public $attachments = [];
    public $existingAttachments = [];
    public $attachmentsToDelete = [];

    protected $rules = [
        'title' => 'required|string|max:191',
        'content' => 'required|string',
        'category' => 'required|in:general,academico,administrativo,evento,urgente,cobro,actividad,otro',
        'is_published' => 'boolean',
        'published_at' => 'nullable|date',
        'attachments.*' => 'nullable|file|max:10240',
    ];

    protected $messages = [
        'title.required' => 'El título es obligatorio',
        'content.required' => 'El contenido es obligatorio',
        'category.required' => 'La categoría es obligatoria',
        'attachments.*.max' => 'Cada archivo no debe superar 10MB',
    ];

    public function mount($id)
    {
        $communication = Communication::with('attachments')->findOrFail($id);

        $this->communicationId = $communication->id;
        $this->title = $communication->title;
        $this->content = $communication->content;
        $this->category = $communication->category;
        $this->is_published = $communication->is_published;
        $this->published_at = $communication->published_at ? $communication->published_at->format('Y-m-d\TH:i') : null;
        $this->existingAttachments = $communication->attachments->toArray();
    }

    public function render()
    {
        return view('livewire.dashboard.comunicados.editar')
            ->extends('layouts.dashboard')
            ->section('content');
    }

    public function save()
    {
        $this->validate();

        try {
            $communication = Communication::findOrFail($this->communicationId);

            $data = [
                'title' => $this->title,
                'content' => $this->content,
                'category' => $this->category,
                'is_published' => $this->is_published,
                'published_at' => $this->published_at,
                'author_id' => auth()->id(),
                'author_name' => auth()->user()->name,
            ];

            $wasPublished = $communication->is_published;
            $communication->update($data);

            // Send email notifications to parents if it just got published
            if ($communication->is_published && !$wasPublished) {
                $parents = \App\Models\ParentUser::where('is_active', true)->get();
                foreach ($parents as $parent) {
                    if ($parent->email) {
                        \Illuminate\Support\Facades\Mail::to($parent->email)->queue(new \App\Mail\NuevoComunicado($communication));
                    }
                }
            }

            // Delete marked attachments
            if (!empty($this->attachmentsToDelete)) {
                foreach ($this->attachmentsToDelete as $attachmentId) {
                    $attachment = CommunicationAttachment::find($attachmentId);
                    if ($attachment) {
                        Storage::disk('public')->delete($attachment->url);
                        $attachment->delete();
                    }
                }
            }

            // Handle new attachments
            if (!empty($this->attachments)) {
                foreach ($this->attachments as $file) {
                    $path = $file->store('communications', 'public');
                    
                    CommunicationAttachment::create([
                        'communication_id' => $communication->id,
                        'name' => $file->getClientOriginalName(),
                        'url' => $path,
                        'type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            $this->emit('swal:alert', [
                'icon' => 'success',
                'title' => 'Comunicado actualizado exitosamente',
                'timeout' => 3000
            ]);

            return redirect()->route('dashboard.comunicados');
        } catch (\Exception $e) {
            $this->emit('swal:alert', [
                'icon' => 'error',
                'title' => 'Error al actualizar el comunicado: ' . $e->getMessage(),
                'timeout' => 5000
            ]);
        }
    }

    public function markAttachmentForDeletion($attachmentId)
    {
        $this->attachmentsToDelete[] = $attachmentId;
        $this->existingAttachments = array_filter($this->existingAttachments, function ($att) use ($attachmentId) {
            return $att['id'] != $attachmentId;
        });
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

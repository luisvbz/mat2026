<?php

namespace App\Mail;

use App\Models\Communication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NuevoComunicado extends Mailable
{
    use Queueable, SerializesModels;

    public $communication;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Communication $communication)
    {
        $this->communication = $communication;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->subject("Nuevo comunicado: {$this->communication->title}")
            ->view('emails.app.nuevo-comunicado');

        // Attach files if they exist
        foreach ($this->communication->attachments as $attachment) {
            $fullPath = public_path($attachment->url);
            if (file_exists($fullPath)) {
                $email->attach($fullPath, [
                    'as' => $attachment->name,
                    'mime' => $attachment->type,
                ]);
            }
        }

        return $email;
    }
}

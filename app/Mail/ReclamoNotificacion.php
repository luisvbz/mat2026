<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Reclamo;

class ReclamoNotificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $reclamo;

    public function __construct(Reclamo $reclamo)
    {
        $this->reclamo = $reclamo;
    }

    public function build()
    {
        return $this->subject('Nuevo Reclamo Registrado - ' . $this->reclamo->numero_registro)
            ->view('emails.reclamo-notificacion')
            ->with([
                'reclamo' => $this->reclamo,
                'numeroRegistro' => $this->reclamo->numero_registro,
                'fechaRegistro' => $this->reclamo->created_at->format('d/m/Y H:i'),
                'nombreCompleto' => $this->reclamo->nombre_completo,
                'tipoReclamo' => $this->reclamo->tipo_reclamo_label,
            ]);
    }
}

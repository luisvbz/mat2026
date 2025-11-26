<?php

namespace App\Mail;

use App\Models\Reclamo;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReclamoRegistrado extends Mailable
{
    use Queueable, SerializesModels;

    public $reclamo;

    public function __construct(Reclamo $reclamo)
    {
        $this->reclamo = $reclamo;
    }

    public function build()
    {
        return $this->subject('Confirmación de Registro de Reclamo - ' . $this->reclamo->numero_registro)
            ->view('emails.reclamo-registrado')
            ->with([
                'reclamo' => $this->reclamo,
                'numeroRegistro' => $this->reclamo->numero_registro,
                'fechaRegistro' => $this->reclamo->created_at->format('d/m/Y H:i'),
                'nombreCompleto' => $this->reclamo->nombre_completo,
            ]);
    }
}

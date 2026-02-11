<?php

namespace App\Console\Commands;

use App\Models\CronogramaPagos;
use App\Models\Communication;
use App\Models\ParentUser;
use App\Mail\NuevoComunicado;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class EnviarRecordatorioProntoPago extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'recordatorio:pronto-pago';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envía recordatorios de pronto pago a los padres cuando se acerca la fecha límite';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {


        $this->info('Iniciando verificación de fechas de pronto pago...');

        // Buscar cronogramas con fecha de pronto pago en 3 días
        //$targetDate = Carbon::now()->addDays(3)->format('Y-m-d');
        $targetDate = date('Y-m-d');
        
        $cronogramas = CronogramaPagos::whereDate('fecha_pronto_pago', $targetDate)->get();

        if ($cronogramas->isEmpty()) {
            $this->info('No hay fechas de pronto pago próximas.');
            return 0;
        }

        $this->info("Se encontraron {$cronogramas->count()} cronogramas con pronto pago el {$targetDate}");

        foreach ($cronogramas as $cronograma) {
            try {
                // Crear comunicado
                $communication = Communication::create([
                    'title' => 'Recordatorio: Fecha de Pronto Pago',
                    'category' => 'administrativo',
                    'content' => $this->generateContent($cronograma),
                    'published_at' => now(),
                    'author_id' => 2,
                    'author_name' => 'Coordinación Administrativa',
                    'is_published' => true,
                ]);

                $this->info("Comunicado creado: {$communication->title}");

                // Enviar emails a todos los padres activos
                $padres = ParentUser::where('is_active', true)->get();
                $emailsSent = 0;

                foreach ($padres as $padre) {
                    try {
                        Mail::to($padre->padre->correo_electronico)
                            ->queue(new NuevoComunicado($communication));
                        $emailsSent++;
                    } catch (\Exception $e) {
                        $this->error("Error enviando email a {$padre->padre->correo_electronico}: {$e->getMessage()}");
                    }
                }

                $this->info("Emails enviados: {$emailsSent}");

            } catch (\Exception $e) {
                $this->error("Error procesando cronograma {$cronograma->id}: {$e->getMessage()}");
            }
        }

        $this->info('Proceso completado.');
        return 0;
    }

    /**
     * Generate email content for the payment reminder
     *
     * @param CronogramaPagos $cronograma
     * @return string
     */
    private function generateContent($cronograma)
    {
        $meses = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];

        $fechaProntoPago = Carbon::parse($cronograma->fecha_pronto_pago)->format('d/m/Y');
        $fechaVencimiento = Carbon::parse($cronograma->fecha_vencimiento)->format('d/m/Y');
        $concepto = "Pensión " . $meses[(int) $cronograma->mes] . " " . date('Y');
        
        return "<p>Estimado padre/madre de familia,</p>

<p>Le recordamos que se aproxima la <strong>fecha de pronto pago</strong> para el siguiente concepto:</p>

<ul>
    <li><strong>Concepto:</strong> {$concepto}</li>
    <li><strong>Monto:</strong> S/. {$cronograma->pronto}</li>
    <li><strong>Fecha de Pronto Pago:</strong> {$fechaProntoPago}</li>
    <li><strong>Fecha de Vencimiento:</strong> {$fechaVencimiento}</li>
</ul>

<p>Aproveche el beneficio del pronto pago realizando su pago antes de la fecha indicada.</p>

<p>Para más información sobre su estado de cuenta, por favor ingrese a la plataforma.</p>

<p>Atentamente,<br>
<strong>IEP Divino Salvador</strong><br>
Administración</p>";
    }
}

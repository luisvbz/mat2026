<?php

namespace App\Http\Controllers\Api;

use App\Models\Pension;
use App\Models\Matricula;
use Illuminate\Http\Request;
use App\Models\CronogramaPagos;
use App\Http\Controllers\Controller;

class CuentasController extends Controller
{
    public function getEstadoCuenta(Request $request, $childId)
    {
        $misPensiones = collect();
        $padre = $request->user()->padre;
        $alumno = $padre->alumnos()->findOrFail($childId);

        $matricula = Matricula::where('alumno_id', $alumno->id)->firstOrFail();

        /*   if (!$matricula) {
            throw new \Exception("La matricula con el DNI <b>{$this->codigo}</b> no se ha encontrado, verifique el código e intente de nuevo");
        } */

        $cronograma = CronogramaPagos::orderBy('orden', 'ASC')->get();

        $statuses = [
            0 => 'pending',
            1 => 'paid',
            2 => 'overdue',
        ];

        foreach ($cronograma as $crono) {
            $pago = Pension::where('codigo_matricula', $matricula->codigo)
                ->where('estado', '<>', 2)
                ->where('mes', $crono->mes)
                ->first();

            $item = new \stdClass();
            $item->order = $crono->orden;
            $item->concept = "Pensión del mes de " . getMes($crono->mes);
            $item->amount = $crono->costo;

            if ($pago && $pago->estado !== null) {
                if ($pago->estado == 1) {
                    $item->status = 'paid';
                } elseif ($pago->estado == 0) {
                    $item->status = 'processing';
                }
            } else {
                if ($crono->vencimiento || ($pago && $pago->vencido)) {
                    $item->status = 'overdue';
                } else {
                    $item->status = 'pending';
                }
            }

            $item->overDue = $crono->vencimiento;
            $item->dueDate = $crono->fecha_vencimiento;
            $item->paymentDate = $pago ? $pago->fecha_pago : null;
            $item->receiptUrl = $pago ? $pago->comprobante : null;

            $misPensiones->push($item);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'accountStatus' => $misPensiones,
            ]
        ]);
    }
}

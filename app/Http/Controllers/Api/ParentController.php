<?php

namespace App\Http\Controllers\Api;

use App\Models\Pension;
use App\Models\Matricula;
use Illuminate\Http\Request;
use App\Models\Communication;
use App\Models\CronogramaPagos;
use App\Http\Controllers\Controller;
use App\Models\AgendaMessage;

class ParentController extends Controller
{
    public function children(Request $request)
    {
        $padre = $request->user()->padre;

        $children = $padre->alumnos()
            ->with('matricula')
            ->get()
            ->map(function ($alumno) {
                $matricula = Matricula::where('alumno_id', $alumno->id)->where('estado', 1)->first();
                $accountBalance = $this->getAccountBalance($alumno->id);
                return [
                    'id' => $alumno->id,
                    'name' => $alumno->nombres . ' ' . $alumno->apellido_paterno . ' ' . $alumno->apellido_materno,
                    'grade' => $matricula->grado ?? null,
                    'level' => $matricula->nivel ?? null,
                    'academicYear' => $matricula->anio ?? null,
                    'age' => $alumno->edad,
                    'photo' => url($alumno->foto),
                    'accountBalance' => $accountBalance['accountBalance'],
                    'pendingPayments' => $accountBalance['overDuePayments'],
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $children,
        ]);
    }


    private function getAccountBalance($alumnoId)
    {
        $matricula = Matricula::where('alumno_id', $alumnoId)->firstOrFail();
        $cronograma = CronogramaPagos::orderBy('orden', 'ASC')->get();
        $misPensiones = collect();

        foreach ($cronograma as $crono) {
            $pago = Pension::where('codigo_matricula', $matricula->codigo)
                ->where('estado', '<>', 2)
                ->where('mes', $crono->mes)
                ->first();
            $item = new \stdClass();
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
            $misPensiones->push($item);
        }

        $accountBalance = $misPensiones->where('status', 'overdue')->sum('amount');
        $overDuePayments = $misPensiones->where('status', 'overdue')->count();

        return [
            'accountBalance' => $accountBalance,
            'overDuePayments' => $overDuePayments,
        ];
    }


    public function resumen(Request $request)
    {
        $padre = $request->user()->padre;

        $alumnos = $padre->alumnos;

        $totalAgendaMessages = AgendaMessage::whereIn('matricula_id', Matricula::whereIn('alumno_id', $alumnos->pluck('id'))->pluck('id'))
            ->where('is_read', false)
            ->count();

        $totalAccountBalance = 0;
        $totalPendingPayments = 0;
        $totalCommunication = Communication::published()
            ->whereDoesntHave('reads', function ($query) use ($request) {
                $query->where('parent_user_id', $request->user()->id);
            })
            ->count();

        foreach ($alumnos as $alumno) {
            $accountBalance = $this->getAccountBalance($alumno->id);
            $totalAccountBalance += $accountBalance['accountBalance'];
            $totalPendingPayments += $accountBalance['overDuePayments'];
        }

        return response()->json([
            'success' => true,
            'data' => [
                'totalAgendaMessages' => $totalAgendaMessages,
                'totalAccountBalance' => $totalAccountBalance,
                'totalPendingPayments' => $totalPendingPayments,
                'totalCommunication' => $totalCommunication,
            ]
        ]);
    }
}
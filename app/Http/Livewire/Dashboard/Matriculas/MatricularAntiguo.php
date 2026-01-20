<?php

namespace App\Http\Livewire\Dashboard\Matriculas;

use App\Models\Historial;
use App\Models\Matricula;
use App\Models\MatriculaOld;
use App\Models\Alumno;
use Livewire\Component;
use Livewire\WithPagination;

class MatricularAntiguo extends Component
{
    use WithPagination;

    public $grado = '';
    public $nivel = '';
    public $search = '';

    protected $queryString = [
        'grado' => ['except' => ''],
        'nivel' => ['except' => ''],
        'search' => ['except' => '']
    ];

    protected $listeners = ['confirmar:migracion' => 'migrarMatricula'];

    public function paginationView()
    {
        return 'bulma-pagination';
    }

    public function buscar()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->reset(['search', 'grado', 'nivel']);
        $this->resetPage();
    }

    public function verificarYMostrarDialog($matriculaOldId)
    {

        $matriculaOld = MatriculaOld::find($matriculaOldId);

        if (!$matriculaOld) {
            $this->emit('swal:modal', [
                'type' => 'error',
                'title' => 'Error!',
                'text' => 'No se encontró la matrícula del 2025',
            ]);
            return;
        }

        // Verificar si ya está matriculado en 2026
        $matriculaExistente = Matricula::where('alumno_id', $matriculaOld->alumno_id)
            ->where('anio', 2026)
            ->first();

        if ($matriculaExistente) {
            $estadoTexto = $matriculaExistente->estado == 0 ? 'PENDIENTE' : ($matriculaExistente->estado == 1 ? 'CONFIRMADA' : 'ANULADA');

            $this->emit('swal:modal', [
                'type' => 'warning',
                'title' => 'Alumno ya matriculado',
                'text' => "El alumno {$matriculaOld->alumno->nombre_completo} ya tiene una matrícula para el año 2026 con estado: {$estadoTexto}",
            ]);
            return;
        }

        // Si no está matriculado, mostrar confirmación
        $nuevoGrado = $this->calcularNuevoGrado($matriculaOld->grado, $matriculaOld->nivel);

        $nivelTexto = $matriculaOld->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA';
        if ($matriculaOld->grado == '6') {
            $nivelTexto = 'SECUNDARIA';
        }

        $mensaje = "Se matriculará a {$matriculaOld->alumno->nombre_completo} ";
        $mensaje .= "de {$matriculaOld->grado}° {$nivelTexto} (2025) ";
        $mensaje .= "a {$nuevoGrado['grado']}° {$nivelTexto} (2026)";

        $this->emit("swal:confirm", [
            'type' => 'info',
            'title' => '¿Confirmar matrícula?',
            'text' => $mensaje,
            'confirmText' => 'Sí, Matricular!',
            'method' => 'confirmar:migracion',
            'params' => [$matriculaOldId],
        ]);
    }

    private function calcularNuevoGrado($gradoActual, $nivel)
    {

        if ($nivel == 'P' && $gradoActual == 6) {
            return ['grado' => 1, 'nivel' => 'S'];
        }

        // 5to de secundaria no se migra (ya egresó)
        if ($nivel == 'S' && $gradoActual == 5) {
            return null;
        }

        // Resto de grados: incrementar en el mismo nivel
        return ['grado' => $gradoActual + 1, 'nivel' => $nivel];
    }

    public function migrarMatricula($params)
    {
        try {
            $matriculaOld = MatriculaOld::find($params[0]);

            if (!$matriculaOld) {
                throw new \Exception('No se encontró la matrícula del 2025');
            }

            // Verificar nuevamente por seguridad
            $existe = Matricula::where('alumno_id', $matriculaOld->alumno_id)
                ->where('anio', 2026)
                ->exists();

            if ($existe) {
                throw new \Exception('El alumno ya está matriculado en 2026');
            }

            $nuevoGrado = $this->calcularNuevoGrado($matriculaOld->grado, $matriculaOld->nivel);

            // Obtener el último número de matrícula del año 2026
            $ultimaMatricula = Matricula::where('anio', 2026)->max('numero_matricula');
            $nuevoNumero = $ultimaMatricula ? $ultimaMatricula + 1 : 1;

            // Generar código de matrícula
            $codigoMatricula = 'IEPDS-' . $matriculaOld->alumno->numero_documento . '-2026';

            // Crear nueva matrícula
            $nuevaMatricula = Matricula::create([
                'codigo' => $codigoMatricula,
                'numero_matricula' => $nuevoNumero,
                'alumno_id' => $matriculaOld->alumno_id,
                'nivel' => $nuevoGrado['nivel'],
                'grado' => $nuevoGrado['grado'],
                'anio' => 2026,
                'estado' => 1, // Pendiente
                'tipo_documento_dj' => $matriculaOld->tipo_documento_dj,
                'numero_documento_dj' => $matriculaOld->numero_documento_dj,
                'nombres_dj' => $matriculaOld->nombres_dj
            ]);

            // Registrar en historial
            Historial::create([
                'user_id' => auth()->user()->id,
                'accion' => "Migración de matrícula 2025→2026: {$codigoMatricula} - {$matriculaOld->alumno->nombre_completo}"
            ]);

            $this->emit('swal:modal', [
                'type' => 'success',
                'title' => 'Éxito!',
                'text' => "El alumno ha sido matriculado para el año 2026 con el número de matrícula: {$nuevoNumero}",
            ]);

            $this->render();
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type' => 'error',
                'title' => 'Error!',
                'text' => $e->getMessage() . $e->getLine(),
            ]);
        }
    }

    public function render()
    {
        $matriculasAntiguas = MatriculaOld::selectRaw('matriculas_2025.*')
            ->join('alumnos', 'alumnos.id', '=', 'matriculas_2025.alumno_id')
            ->where('matriculas_2025.estado', 1)
            ->where(function ($q) {
                // Excluir nivel S grado 5
                $q->where('matriculas_2025.nivel', '!=', 'S')
                    ->orWhere('matriculas_2025.grado', '!=', 5);
            })
            ->when($this->search != '', function ($q) {
                $q->whereRaw(
                    'alumnos.apellido_paterno like ?
            OR alumnos.apellido_materno like ?
            OR alumnos.nombres like ?
            OR alumnos.numero_documento = ?',
                    [
                        "%{$this->search}%",
                        "%{$this->search}%",
                        "%{$this->search}%",
                        $this->search
                    ]
                );
            })
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas_2025.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas_2025.grado', $this->grado);
            })
            ->orderByRaw('CONCAT(alumnos.apellido_paterno, alumnos.apellido_materno, alumnos.nombres) ASC')
            ->paginate(30);


        // Verificar cuáles ya están matriculados en 2026
        foreach ($matriculasAntiguas as $mat) {
            $mat->ya_matriculado_2026 = Matricula::where('alumno_id', $mat->alumno_id)
                ->where('anio', 2026)
                ->exists();
        }

        $totalAlumnos = MatriculaOld::where('estado', 1)
            ->when($this->nivel != '', function ($q) {
                $q->where('nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('grado', $this->grado);
            })
            ->count();

        $yaMatriculados = MatriculaOld::join('alumnos', 'alumnos.id', '=', 'matriculas_2025.alumno_id')
            ->join('matriculas', function ($join) {
                $join->on('matriculas.alumno_id', '=', 'matriculas_2025.alumno_id')
                    ->where('matriculas.anio', '=', 2026);
            })
            ->where('matriculas_2025.estado', 1)
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas_2025.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas_2025.grado', $this->grado);
            })
            ->count();

        return view('livewire.dashboard.matriculas.matricular-antiguo', [
            'matriculas' => $matriculasAntiguas,
            'totalAlumnos' => $totalAlumnos,
            'yaMatriculados' => $yaMatriculados,
            'pendientes' => $totalAlumnos - $yaMatriculados,
        ])
            ->extends('layouts.panel')
            ->section('content');
    }
}

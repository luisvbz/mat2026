<?php

namespace App\Http\Livewire\Dashboard\Matriculas;

use App\Models\Historial;
use App\Models\Matricula;
use App\Models\Padre;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    public $grado = '';
    public $nivel = '';
    public $search = '';
    public $estado = '';
    public $matriculas_selected = [];

    protected $queryString = [
        'estado' =>  ['except' => ''],
        'grado' =>  ['except' => ''],
        'nivel' =>  ['except' => ''],
        'search' => ['except' => '']
    ];

    protected $listeners = ['confirm:matricula' => 'confirmMatricula', 'anular:matricula' => 'anularMatricula'];

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
        $this->reset(['search', 'grado', 'nivel', 'estado']);
        $this->resetPage();
    }

    public function showDialogConfirmMatricula($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta acción macarcara la matricula como confirmada",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'confirm:matricula',
            'params'      => [$id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function showDialogAnularMatricula($id)
    {
        $this->emit("swal:confirm", [
            'type'        => 'warning',
            'title'       => 'Estas seguro(a)?',
            'text'        => "Esta acción anulara la matrícula",
            'confirmText' => 'Sí Confirmar!',
            'method'      => 'anular:matricula',
            'params'      => [$id], // optional, send params to success confirmation
            'callback'    => '', // optional, fire event if no confirmed
        ]);
    }

    public function confirmMatricula($params)
    {
        try {

            Matricula::find($params[0])->update(['estado' => 1]);

            $mat = Matricula::find($params[0]);
            Historial::create(['user_id' => auth()->user()->id, 'accion' => 'Confirmar matrícula: ' . $mat->codigo]);

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "La matrícula se ha marcado como confirmada",
            ]);

            $this->render();
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function anularMatricula($params)
    {
        try {

            Matricula::find($params[0])->update(['estado' => 2]);

            $mat = Matricula::find($params[0]);
            Historial::create(['user_id' => auth()->user()->id, 'accion' => 'Anular matrícula: ' . $mat->codigo]);

            $this->emit('swal:modal', [
                'type'  => 'success',
                'title' => 'Exito!!',
                'text'  => "La matrícula se ha anulado con éxito",
            ]);

            $this->render();
        } catch (\Exception $e) {
            $this->emit('swal:modal', [
                'type'  => 'error',
                'title' => 'Error!!',
                'text'  => $e->getMessage(),
            ]);
        }
    }

    public function descargarFicha($id)
    {

        $matricula = Matricula::find($id);
        $pdf = PDF::loadView('pdfs.ficha', ['matricula' => $matricula]);
        Historial::create(['user_id' => auth()->user()->id, 'accion' => 'Descargar ficha de Matrícula: ' . $matricula->codigo]);
        //dd($pdf);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "FICHA-{$matricula->codigo}.pdf");
    }

    public function exportarPdfNumeros()
    {
        $matriculas = Matricula::where('estado', 1)->orderBy('numero_matricula', 'ASC')->get()->transform(function ($item) {

            $padre = $item->alumno->padres()->where('parentesco', 'P')->first();
            $madre = $item->alumno->padres()->where('parentesco', 'M')->first();

            $hoy = Carbon::now();
            $nac = Carbon::createFromFormat('Y-m-d', $item->alumno->fecha_nacimiento);

            $mat = new \stdClass();
            $mat->numero_matricula = str_pad($item->numero_matricula, 3, '0', STR_PAD_LEFT);
            $mat->alumno = $item->alumno->nombre_completo;
            $mat->edad = $hoy->diffInYears($nac);
            $mat->grado = $item->grado . " " . ($item->nivel == 'S' ? 'SEC' : 'PRIM');
            $mat->direccion = $item->alumno->domicilio;
            $mat->telefono = $item->alumno->celular;
            $mat->colegio_procedencia = $item->alumno->colegio_procedencia;
            $mat->padre = $padre ? $padre->apellidos . ", " . $padre->nombres : '';
            $mat->madre = $madre ? $madre->apellidos . ", " . $madre->nombres : '';

            return $mat;
        });

        $pdf = PDF::loadView('pdfs.reporte-matriculas-numeros', ['matriculas' => $matriculas], [],  ['format' => 'A4', 'orientation' => 'L']);
        $fecha = date('d-m-Y');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "reporte-matricula-numeros-{$fecha}.pdf");
    }

    public function exportarPdfVacuna()
    {
        $matriculas = Matricula::where('estado', 1)
            ->orderBy('nivel', 'ASC')
            ->orderBy('grado', 'ASC')
            ->orderBy('numero_matricula', 'ASC')->get()->transform(function ($item) {

                $padre = $item->alumno->padres()->where('parentesco', 'P')->first();
                $madre = $item->alumno->padres()->where('parentesco', 'M')->first();

                $hoy = Carbon::now();
                $nac = Carbon::createFromFormat('Y-m-d', $item->alumno->fecha_nacimiento);

                $mat = new \stdClass();
                $mat->numero_matricula = str_pad($item->numero_matricula, 3, '0', STR_PAD_LEFT);
                $mat->alumno_dni = $item->alumno->numero_documento;
                $mat->alumno = $item->alumno->nombre_completo;
                $mat->edad = $hoy->diffInYears($nac);
                $mat->grado = $item->grado . " " . ($item->nivel == 'S' ? 'SEC' : 'PRIM');
                $mat->grado_numero = $item->grado . $item->nivel;
                $mat->direccion = $item->alumno->domicilio;
                $mat->telefono = $item->alumno->celular;
                $mat->colegio_procedencia = $item->alumno->colegio_procedencia;
                $mat->padre = $padre ? $padre->apellidos . ", " . $padre->nombres : '';
                $mat->madre = $madre ? $madre->apellidos . ", " . $madre->nombres : '';

                return $mat;
            })->groupBy('grado_numero');



        $pdf = PDF::loadView('pdfs.reporte-matriculas-vacuna', ['matriculas' => $matriculas], [],  ['format' => 'A4', 'orientation' => 'L']);
        $fecha = date('d-m-Y');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "reporte-matricula-numeros-{$fecha}.pdf");
    }

    public function exportarPdf()
    {
        //primaria
        $relacion = collect();

        for ($i = 1; $i <= 6; $i++) {
            $grado =  Matricula::join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->selectRaw('matriculas.*')
                ->where('matriculas.estado', 1)
                ->where('matriculas.nivel', 'P')
                ->where('matriculas.grado', $i)
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'PRIMARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $hoy = Carbon::now();
                    $nac = Carbon::createFromFormat('Y-m-d', $matricula->alumno->fecha_nacimiento);

                    $telefonoPadre = $matricula->alumno->padres()->where('parentesco', 'P')->first();
                    $telefonoMadre = $matricula->alumno->padres()->where('parentesco', 'M')->first();

                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->estado = $matricula->estado;
                    $item->dni = $matricula->alumno->numero_documento;
                    $item->telefono = (isset($telefonoPadre->telefono_celular) ? $telefonoPadre->telefono_celular : '') . (isset($telefonoMadre->telefono_celular) ? '/' . $telefonoMadre->telefono_celular : '');
                    $item->genero = $matricula->alumno->genero;
                    $item->fecha_nacimiento = $matricula->alumno->fecha_nacimiento;
                    $item->edad = $hoy->diffInYears($nac);
                    $item->numero_matricula = $matricula->numero_matricula;
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        //secundaria

        for ($i = 1; $i <= 5; $i++) {
            $grado =  Matricula::join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->where('matriculas.estado', 1)
                ->selectRaw('matriculas.*')
                ->where('matriculas.nivel', 'S')
                ->where('matriculas.grado', $i)
                ->when(auth()->user()->id == 4, function ($q) {
                    $q->where('codigo', '<>', 'IEPDS-61140703-2026');
                })
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'SECUNDARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $hoy = Carbon::now();
                    $nac = Carbon::createFromFormat('Y-m-d', $matricula->alumno->fecha_nacimiento);

                    $telefonoPadre = $matricula->alumno->padres()->where('parentesco', 'P')->first();
                    $telefonoMadre = $matricula->alumno->padres()->where('parentesco', 'M')->first();

                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->estado = $matricula->estado;
                    $item->dni = $matricula->alumno->numero_documento;
                    $item->telefono = (isset($telefonoPadre->telefono_celular) ? $telefonoPadre->telefono_celular : '') . (isset($telefonoMadre->telefono_celular) ? '/' . $telefonoMadre->telefono_celular : '');
                    $item->fecha_nacimiento = $matricula->alumno->fecha_nacimiento;
                    $item->genero = $matricula->alumno->genero;
                    $item->edad = $hoy->diffInYears($nac);
                    $item->numero_matricula = $matricula->numero_matricula;
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        $pdf = PDF::loadView('pdfs.reporte-matriculas', ['matriculas' => $relacion]);
        $fecha = date('d-m-Y');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "reporte-matricula-{$fecha}.pdf");
    }

    public function exportarCorreos()
    {
        //$matriculas = Matricula::whereEstado(1)->get();
        $matriculas = Matricula::selectRaw('matriculas.*')
            ->join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
            ->where('matriculas.anio', 2026)
            ->where('matriculas.estado', 1)
            ->when($this->search != '', function ($q) {
                $q->whereRaw(
                    'alumnos.apellido_paterno = ?
                                      OR alumnos.apellido_materno = ?
                                      OR alumnos.nombres = ?
                                      OR alumnos.numero_documento = ?',
                    [
                        $this->search,
                        $this->search,
                        $this->search,
                        $this->search
                    ]
                );
            })
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas.grado', $this->grado);
            })
            ->when($this->estado != '', function ($q) {
                $q->where('matriculas.estado', $this->estado);
            })
            ->when(auth()->user()->id == 4, function ($q) {
                $q->where('codigo', '<>', 'IEPDS-61140703-2026');
            })
            ->get();
        //$correos = "";
        $correos = [];
        foreach ($matriculas as $mat) {
            foreach ($mat->alumno->padres as $p) {
                array_push($correos, strtolower($p->correo_electronico));
            }
        }

        $correos = array_unique($correos);
        $correos = implode(",", $correos);

        $n = $this->nivel;
        $g = $this->grado;
        $name = ($this->grado == '' && $this->nivel == '') ? 'reporte-correo-todos.txt' : "reporte-correo-{$n}-{$g}.txt";

        return response()->streamDownload(function () use ($correos) {
            echo $correos;
        }, $name);
    }

    public function exportarDNI()
    {
        $relacion = collect();

        for ($i = 1; $i <= 6; $i++) {
            $grado =  Matricula::join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->selectRaw('matriculas.*')
                ->where('matriculas.nivel', 'P')
                ->where('matriculas.grado', $i)
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'PRIMARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->dni_alumno = $matricula->alumno->numero_documento;
                    $item->dni_mama = ($matricula->alumno->padres()->where('parentesco', 'M')->first())->numero_documento ?? '';
                    $item->dni_papa = ($matricula->alumno->padres()->where('parentesco', 'P')->first())->numero_documento ?? '';
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        //secundaria

        for ($i = 1; $i <= 5; $i++) {
            $grado =  Matricula::join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->selectRaw('matriculas.*')
                ->where('matriculas.nivel', 'S')
                ->where('matriculas.grado', $i)
                ->when(auth()->user()->id == 4, function ($q) {
                    $q->where('codigo', '<>', 'IEPDS-61140703-2026');
                })
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'SECUNDARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->dni_alumno = $matricula->alumno->numero_documento;
                    $item->dni_mama = ($matricula->alumno->padres()->where('parentesco', 'M')->first())->numero_documento ?? '';
                    $item->dni_papa = ($matricula->alumno->padres()->where('parentesco', 'P')->first())->numero_documento ?? '';
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        $pdf = PDF::loadView('pdfs.reporte-dni', ['matriculas' => $relacion]);
        $fecha = date('d-m-Y');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "lista-de-alumnos-dni-{$fecha}.pdf");
    }

    public function generarQrs()
    {
        $relacion = collect();

        for ($i = 1; $i <= 6; $i++) {
            $grado =  Matricula::join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->selectRaw('matriculas.*')
                ->where('matriculas.estado', 1)
                ->where('matriculas.nivel', 'P')
                ->when(sizeof($this->matriculas_selected) > 0, function ($q) {
                    $q->whereIn('matriculas.id', $this->matriculas_selected);
                })
                ->where('matriculas.grado', $i)
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'PRIMARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $hoy = Carbon::now();
                    $nac = Carbon::createFromFormat('Y-m-d', $matricula->alumno->fecha_nacimiento);

                    $telefonoPadre = $matricula->alumno->padres()->where('parentesco', 'P')->first();
                    $telefonoMadre = $matricula->alumno->padres()->where('parentesco', 'M')->first();

                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->estado = $matricula->estado;
                    $item->dni = $matricula->alumno->numero_documento;
                    $item->telefono = (isset($telefonoPadre->telefono_celular) ? $telefonoPadre->telefono_celular : '') . (isset($telefonoMadre->telefono_celular) ? '/' . $telefonoMadre->telefono_celular : '');
                    $item->genero = $matricula->alumno->genero;
                    $item->fecha_nacimiento = $matricula->alumno->fecha_nacimiento;
                    $item->edad = $hoy->diffInYears($nac);
                    $item->numero_matricula = $matricula->numero_matricula;
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        //secundaria

        for ($i = 1; $i <= 5; $i++) {
            $grado =  Matricula::join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
                ->where('matriculas.estado', 1)
                ->selectRaw('matriculas.*')
                ->where('matriculas.nivel', 'S')
                ->when(sizeof($this->matriculas_selected) > 0, function ($q) {
                    $q->whereIn('matriculas.id', $this->matriculas_selected);
                })
                ->where('matriculas.grado', $i)
                ->when(auth()->user()->id == 4, function ($q) {
                    $q->where('codigo', '<>', 'IEPDS-61140703-2026');
                })
                ->orderBy('alumnos.apellido_paterno', 'ASC')
                ->orderBy('alumnos.apellido_materno', 'ASC')
                ->orderBy('alumnos.nombres', 'ASC')
                ->get();

            $itemGrade = new \stdClass();
            $itemGrade->nivel = 'SECUNDARIA';
            $itemGrade->grado = $i;
            $itemGrade->alumnos = collect();

            if (count($grado) > 0) {

                foreach ($grado as $matricula) {
                    $hoy = Carbon::now();
                    $nac = Carbon::createFromFormat('Y-m-d', $matricula->alumno->fecha_nacimiento);

                    $telefonoPadre = $matricula->alumno->padres()->where('parentesco', 'P')->first();
                    $telefonoMadre = $matricula->alumno->padres()->where('parentesco', 'M')->first();

                    $item = new \stdClass();
                    $item->alumno = $matricula->alumno->nombre_completo;
                    $item->estado = $matricula->estado;
                    $item->dni = $matricula->alumno->numero_documento;
                    $item->telefono = (isset($telefonoPadre->telefono_celular) ? $telefonoPadre->telefono_celular : '') . (isset($telefonoMadre->telefono_celular) ? '/' . $telefonoMadre->telefono_celular : '');
                    $item->fecha_nacimiento = $matricula->alumno->fecha_nacimiento;
                    $item->genero = $matricula->alumno->genero;
                    $item->edad = $hoy->diffInYears($nac);
                    $item->numero_matricula = $matricula->numero_matricula;
                    $itemGrade->alumnos->push($item);
                }
            }

            if (count($itemGrade->alumnos) > 0) $relacion->push($itemGrade);
        }

        //  dd($relacion);

        $pdf = PDF::loadView('pdfs.qrs', ['matriculas' => $relacion]);
        $fecha = date('d-m-Y');
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, "lista-de-alumnos-qr-{$fecha}.pdf");
    }


    public function render()
    {

        $year = 2026;

        $matriculas = Matricula::selectRaw('matriculas.*')
            ->join('alumnos', 'alumnos.id', '=', 'matriculas.alumno_id')
            ->where('matriculas.anio', $year)
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
                $q->where('matriculas.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas.grado', $this->grado);
            })
            ->when($this->estado != '', function ($q) {
                $q->where('matriculas.estado', $this->estado);
            })
            ->when(auth()->user()->id == 4, function ($q) {
                $q->where('codigo', '<>', 'IEPDS-61140703-2026');
            })
            ->orderByRaw('CONCAT(alumnos.apellido_paterno, alumnos.apellido_paterno, alumnos.nombres) ASC')
            ->paginate(30);

        $totalRegistros = Matricula::where('anio', $year)
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas.grado', $this->grado);
            })
            ->when($this->estado != '', function ($q) {
                $q->where('matriculas.estado', $this->estado);
            })
            ->when(auth()->user()->id == 4, function ($q) {
                $q->where('codigo', '<>', 'IEPDS-61140703-2026');
            })
            ->count();
        $totalPendientes = Matricula::where('anio', $year)->whereEstado(0)
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas.grado', $this->grado);
            })
            ->when($this->estado != '', function ($q) {
                $q->where('matriculas.estado', $this->estado);
            })
            ->when(auth()->user()->id == 4, function ($q) {
                $q->where('codigo', '<>', 'IEPDS-61140703-2026');
            })
            ->count();
        $totalConfirmadas = Matricula::where('anio', $year)->whereEstado(1)
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas.grado', $this->grado);
            })
            ->when($this->estado != '', function ($q) {
                $q->where('matriculas.estado', $this->estado);
            })
            ->when(auth()->user()->id == 4, function ($q) {
                $q->where('codigo', '<>', 'IEPDS-61140703-2026');
            })
            ->count();
        $totalAnuladas = Matricula::where('anio', $year)->whereEstado(2)
            ->when($this->nivel != '', function ($q) {
                $q->where('matriculas.nivel', $this->nivel);
            })
            ->when($this->grado != '', function ($q) {
                $q->where('matriculas.grado', $this->grado);
            })
            ->when($this->estado != '', function ($q) {
                $q->where('matriculas.estado', $this->estado);
            })
            ->when(auth()->user()->id == 4, function ($q) {
                $q->where('codigo', '<>', 'IEPDS-61140703-2026');
            })
            ->count();

        return view('livewire.dashboard.matriculas.index', [
            'matriculas' => $matriculas,
            'total' => $totalRegistros,
            'pendientes' => $totalPendientes,
            'confirmadas' => $totalConfirmadas,
            'anuladas' => $totalAnuladas,
        ])
            ->extends('layouts.panel')
            ->section('content');
    }
}

<?php

namespace App\Http\Livewire\Dashboard\Citas;

use App\Models\Appointment;
use App\Models\TeacherUser;
use App\Models\Grado;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public $nivel = '';
    public $grado = '';
    public $teacher_id = '';
    public $status = '';
    public $desde = '';
    public $hasta = '';
    public $search = '';
    public $selected_appointment = null;
    public $showModal = false;

    public $grados = [];

    protected $queryString = [
        'nivel' => ['except' => ''],
        'grado' => ['except' => ''],
        'teacher_id' => ['except' => ''],
        'status' => ['except' => ''],
        'desde' => ['except' => ''],
        'hasta' => ['except' => ''],
        'search' => ['except' => ''],
    ];

    public function mount()
    {
        if ($this->nivel) {
            $this->updatedNivel();
        }
    }

    public function updatedNivel()
    {
        $this->grados = Grado::where('nivel', $this->nivel)
            ->orderBy('numero')
            ->get();
        $this->reset('grado');
        $this->resetPage();
    }

    public function updatedGrado()
    {
        $this->resetPage();
    }

    public function updatedTeacherId()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedDesde()
    {
        $this->resetPage();
    }

    public function updatedHasta()
    {
        $this->resetPage();
    }

    public function buscar()
    {
        $this->resetPage();
    }

    public function limpiar()
    {
        $this->reset(['nivel', 'grado', 'teacher_id', 'status', 'desde', 'hasta', 'search', 'selected_appointment', 'showModal']);
        $this->grados = [];
        $this->resetPage();
    }

    public function verDetalle($id)
    {
        $this->selected_appointment = Appointment::with(['parent', 'teacher', 'student.matricula'])->find($id);
        $this->showModal = true;
    }

    public function cerrarModal()
    {
        $this->showModal = false;
        $this->selected_appointment = null;
    }

    public function exportarExcel()
    {
        $appointments = $this->getQuery()->get();
        $filename = "reporte-citas-" . date('d-m-Y') . ".xls";
        
        $html = view('excel.citas', compact('appointments'))->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    private function getQuery()
    {
        return Appointment::query()
            ->with(['parent', 'teacher', 'student.matricula'])
            ->when($this->status != '', function ($q) {
                $q->where('status', $this->status);
            })
            ->when($this->teacher_id != '', function ($q) {
                $q->where('teacher_id', $this->teacher_id);
            })
            ->when($this->desde != '', function ($q) {
                $q->whereDate('date', '>=', $this->desde);
            })
            ->when($this->hasta != '', function ($q) {
                $q->whereDate('date', '<=', $this->hasta);
            })
            ->when($this->nivel != '' || $this->grado != '', function ($q) {
                $q->whereHas('student.matricula', function ($mq) {
                    $mq->when($this->nivel != '', function ($sq) {
                        $sq->where('nivel', $this->nivel);
                    })
                    ->when($this->grado != '', function ($sq) {
                        $sq->where('grado', $this->grado);
                    });
                });
            })
            ->when($this->search != '', function ($q) {
                $q->where(function ($sq) {
                    $sq->whereHas('student', function ($aq) {
                        $aq->where('nombres', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido_paterno', 'like', '%' . $this->search . '%')
                            ->orWhere('apellido_materno', 'like', '%' . $this->search . '%');
                    })
                    ->orWhereHas('parent', function ($pq) {
                        $pq->where('nombres', 'like', '%' . $this->search . '%')
                            ->orWhere('apellidos', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->orderBy('date', 'DESC')
            ->orderBy('time', 'DESC');
    }

    public function render()
    {
        $appointments = $this->getQuery()->paginate(20);
        $teachers = TeacherUser::where('is_active', true)->with('teacher')->get();

        return view('livewire.dashboard.citas.index', [
            'appointments' => $appointments,
            'teachers' => $teachers,
        ])
            ->extends('layouts.tailwind')
            ->section('content');
    }
}

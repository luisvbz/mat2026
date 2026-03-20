<?php

namespace App\Http\Livewire\Dashboard\Comunicados;

use App\Models\Communication;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Stats extends Component
{
    use WithPagination;

    public $communication;

    // Filters
    public $searchStudent = '';
    public $searchParent = '';
    public $filterNivel = '';
    public $filterGrado = '';

    public function mount($id)
    {
        $this->communication = Communication::findOrFail($id);
    }

    public function paginationView()
    {
        return 'bulma-pagination';
    }

    public function updatingSearchStudent()
    {
        $this->resetPage();
    }

    public function updatingSearchParent()
    {
        $this->resetPage();
    }

    public function updatingFilterNivel()
    {
        $this->resetPage();
    }

    public function updatingFilterGrado()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['searchStudent', 'searchParent', 'filterNivel', 'filterGrado']);
        $this->resetPage();
    }

    public function render()
    {
        // Query reads and join with parents, students, and matriculas
        // We use anio 2026 as it seems to be the current active year based on other components
        $reads = DB::table('communication_reads as r')
            ->join('parent_users as pu', 'pu.id', '=', 'r.parent_user_id')
            ->join('padres as p', 'p.id', '=', 'pu.padre_id')
            ->leftJoin('alumnos_padres as ap', 'ap.padre_id', '=', 'p.id')
            ->leftJoin('alumnos as a', 'a.id', '=', 'ap.alumno_id')
            ->leftJoin('matriculas as m', function ($join) {
                $join->on('m.alumno_id', '=', 'a.id')
                     ->where('m.anio', '=', 2026);
            })
            ->where('r.communication_id', $this->communication->id)
            ->when($this->searchParent, function ($query) {
                $query->where(function ($q) {
                    $q->where('p.nombres', 'like', '%' . $this->searchParent . '%')
                      ->orWhere('p.apellidos', 'like', '%' . $this->searchParent . '%')
                      ->orWhere('pu.document_number', 'like', '%' . $this->searchParent . '%');
                });
            })
            ->when($this->searchStudent, function ($query) {
                $query->where(function ($q) {
                    $q->where('a.nombres', 'like', '%' . $this->searchStudent . '%')
                      ->orWhere('a.apellido_paterno', 'like', '%' . $this->searchStudent . '%')
                      ->orWhere('a.apellido_materno', 'like', '%' . $this->searchStudent . '%');
                });
            })
            ->when($this->filterNivel, function ($query) {
                $query->where('m.nivel', $this->filterNivel);
            })
            ->when($this->filterGrado, function ($query) {
                $query->where('m.grado', $this->filterGrado);
            })
            ->select(
                'pu.document_number as document',
                'p.nombres as parent_nombres',
                'p.apellidos as parent_apellidos',
                'a.nombres as student_nombres',
                'a.apellido_paterno as student_paterno',
                'a.apellido_materno as student_materno',
                'm.nivel',
                'm.grado',
                'r.read_at'
            )
            ->orderBy('r.read_at', 'desc')
            ->paginate(20);

        return view('livewire.dashboard.comunicados.stats', [
            'reads' => $reads
        ])->extends('layouts.dashboard')->section('content');
    }
}

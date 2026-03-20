<div class="content-dashboard">
    {{-- Header --}}
    <div class="content-dashboard-header">
        <div>
            <i class="fas fa-chart-bar"></i> Estadísticas: {{ $communication->title }}
        </div>
        <div>
            <a href="{{ route('dashboard.comunicados') }}" class="button is-small">
                <i class="fas fa-arrow-left mr-2"></i> Volver
            </a>
        </div>
    </div>

    {{-- Cards --}}
    <div class="columns mb-4">
        <div class="column is-4">
            <div class="box has-background-info-light">
                <p class="heading">Total de Lecturas</p>
                <p class="title is-3">{{ $communication->reads()->count() }}</p>
            </div>
        </div>
        <div class="column is-4">
            <div class="box has-background-success-light">
                <p class="heading">Porcentaje Leído</p>
                <p class="title is-3">{{ $communication->read_percentage ?? 0 }}%</p>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="box-content content-dashboard-content mb-4">
        <div class="columns is-multiline">
            <div class="column is-3">
                <label class="label">Buscar Alumno</label>
                <div class="control has-icons-left">
                    <input wire:model.debounce.500ms="searchStudent" class="input" type="text"
                        placeholder="Nombre o apellido...">
                    <span class="icon is-small is-left">
                        <i class="fas fa-user-graduate"></i>
                    </span>
                </div>
            </div>
            <div class="column is-3">
                <label class="label">Buscar Padre/Madre</label>
                <div class="control has-icons-left">
                    <input wire:model.debounce.500ms="searchParent" class="input" type="text"
                        placeholder="Nombre o DNI...">
                    <span class="icon is-small is-left">
                        <i class="fas fa-user"></i>
                    </span>
                </div>
            </div>
            <div class="column is-2">
                <label class="label">Nivel</label>
                <div class="select is-fullwidth">
                    <select wire:model="filterNivel">
                        <option value="">Todos</option>
                        <option value="P">Primaria</option>
                        <option value="S">Secundaria</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <label class="label">Grado</label>
                <div class="select is-fullwidth">
                    <select wire:model="filterGrado">
                        <option value="">Todos</option>
                        <option value="1">1ro</option>
                        <option value="2">2do</option>
                        <option value="3">3ro</option>
                        <option value="4">4to</option>
                        <option value="5">5to</option>
                        @if ($filterNivel == 'P')
                            <option value="6">6to</option>
                        @endif
                    </select>
                </div>
            </div>
            <div class="column is-2 d-flex align-items-end" style="display: flex; align-items: flex-end;">
                <button wire:click="resetFilters" class="button is-light is-fullwidth">
                    <i class="fas fa-eraser mr-2"></i> Limpiar
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="box-content content-dashboard-content">
        <table class="table is-fullwidth is-hoverable is-striped">
            <thead>
                <tr>
                    <th>Padre/Madre</th>
                    <th>Alumno</th>
                    <th>Nivel</th>
                    <th>Grado</th>
                    <th>Fecha de Lectura</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reads as $read)
                    <tr>
                        <td>
                            @if ($read->parent_nombres)
                                {{ ucwords(strtolower($read->parent_nombres)) }}
                                {{ ucwords(strtolower($read->parent_apellidos)) }}
                            @else
                                <span class="has-text-grey-light">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if ($read->student_nombres)
                                {{ mb_strtoupper($read->student_paterno, 'UTF-8') }}
                                {{ mb_strtoupper($read->student_materno, 'UTF-8') }},
                                {{ mb_convert_case($read->student_nombres, MB_CASE_TITLE, 'UTF-8') }}
                            @else
                                <span class="has-text-grey-light">N/A</span>
                            @endif
                        </td>
                        <td>
                            @if ($read->nivel == 'P')
                                Primaria
                            @elseif($read->nivel == 'S')
                                Secundaria
                            @else
                                <span class="has-text-grey-light">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($read->grado)
                                {{ $read->grado }}°
                            @else
                                <span class="has-text-grey-light">-</span>
                            @endif
                        </td>
                        <td>
                            {{ \Carbon\Carbon::parse($read->read_at)->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="has-text-centered has-text-grey py-5">
                            <i class="fas fa-search fa-3x mb-3"></i>
                            <p>No se encontraron registros de lectura</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $reads->links() }}
        </div>
    </div>
</div>

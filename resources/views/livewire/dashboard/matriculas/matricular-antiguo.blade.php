<div class="content-dashboard">
    <div class="loading-matricula" wire:loading wire:target="migrarMatricula" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}" />
            </div>
            <div class="mensaje">
                Procesando migración.....
            </div>
        </div>
    </div>

    <div class="content-dashboard-header">
        <div><i class="fas fa-user-graduate"></i> Matricular Alumnos Antiguos (2025 → 2026)</div>
    </div>

    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column is-4">
                <div class="control has-icons-left">
                    <input type="text" class="input" wire:keydown.enter="buscar" wire:model.defer="search"
                        placeholder="Buscar por nombre o DNI del estudiante" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model.defer="nivel">
                        <option value="" selected>Nivel</option>
                        <option value="P">Primaria</option>
                        <option value="S">Secundaria</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model.defer="grado">
                        <option value="" selected>Grado</option>
                        <option value="1">Primero</option>
                        <option value="2">Segundo</option>
                        <option value="3">Tercero</option>
                        <option value="4">Cuarto</option>
                        <option value="5">Quinto</option>
                        <option value="6">Sexto</option>
                    </select>
                </div>
            </div>
            <div class="column has-text-centered">
                <button wire:click="buscar" class="button is-success"><i class="fas fa-search"></i></button>
                <button wire:click="limpiar" class="button is-danger"><i class="fas fa-eraser"></i></button>
            </div>
        </div>
    </div>

    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column has-text-centered">
                <i class="fas fa-users has-text-info"></i>
                <strong>{{ $totalAlumnos }}</strong> ALUMNOS 2025
            </div>
            <div class="column has-text-centered">
                <i class="fas fa-check-circle has-text-success"></i>
                <strong>{{ $yaMatriculados }}</strong> YA MATRICULADOS 2026
            </div>
            <div class="column has-text-centered">
                <i class="fas fa-clock has-text-warning"></i>
                <strong>{{ $pendientes }}</strong> PENDIENTES
            </div>
        </div>
    </div>

    <div class="box-content content-dashboard-content">
        <div class="notification is-info is-light">
            <p><strong><i class="fas fa-info-circle"></i> Información:</strong></p>
            <ul>
                <li>Esta vista muestra alumnos con matrícula <strong>confirmada</strong> del año 2025</li>
                <li>Los alumnos serán matriculados automáticamente en el <strong>grado siguiente</strong> para el año
                    2026</li>
                <li>Las matrículas nuevas se crearán con estado <strong>PENDIENTE</strong></li>
                <li>No se pueden duplicar matrículas para el mismo alumno en 2026</li>
            </ul>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th class="has-text-centered">#</th>
                    <th>DNI/CE/PTP</th>
                    <th>Alumno</th>
                    <th>Nivel</th>
                    <th>Grado 2025</th>
                    <th>Grado 2026</th>
                    <th class="has-text-centered">Estado 2026</th>
                    <th class="has-text-centered">Acción</th>
                </tr>
            </thead>
            <tbody>
                @php $i = 1; @endphp
                @forelse($matriculas as $matricula)
                    @php
                        // Calcular nuevo grado y nivel
                        if ($matricula->nivel == 'P' && $matricula->grado == 6) {
                            $nuevoGrado = 1;
                            $nuevoNivel = 'S';
                            $nuevoNivelTexto = 'SECUNDARIA';
                        } else {
                            $nuevoGrado = $matricula->grado + 1;
                            $nuevoNivel = $matricula->nivel;
                            $nuevoNivelTexto = $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA';
                        }
                    @endphp
                    <tr>
                        <td class="has-text-centered">{{ $i }}</td>
                        <td>{{ $matricula->alumno->numero_documento }}</td>
                        <td>{{ $matricula->alumno->nombre_completo }}</td>
                        <td>{{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</td>
                        <td>{{ $matricula->grado }}°</td>
                        <td>
                            <strong class="has-text-primary">{{ $nuevoGrado }}° {{ $nuevoNivelTexto }}</strong>
                            @if ($matricula->nivel == 'P' && $matricula->grado == 6)
                                <span class="tag is-info is-light ml-2">
                                    <i class="fas fa-arrow-up"></i> Cambio de nivel
                                </span>
                            @endif
                        </td>
                        <td class="has-text-centered">
                            @if ($matricula->ya_matriculado_2026)
                                <span class="tag is-success">
                                    <i class="fas fa-check-circle"></i>&nbsp; Matriculado
                                </span>
                            @else
                                <span class="tag is-warning">
                                    <i class="fas fa-clock"></i>&nbsp; Pendiente
                                </span>
                            @endif
                        </td>
                        <td class="has-text-centered">
                            @if (!$matricula->ya_matriculado_2026)
                                <button wire:click="verificarYMostrarDialog({{ $matricula->id }})"
                                    class="button is-small is-success">
                                    <span class="icon">
                                        <i class="fas fa-user-plus"></i>
                                    </span>
                                    <span>Matricular</span>
                                </button>
                            @else
                                <button class="button is-small is-static" disabled>
                                    <span class="icon">
                                        <i class="fas fa-check"></i>
                                    </span>
                                    <span>Ya matriculado</span>
                                </button>
                            @endif
                        </td>
                    </tr>
                    @php $i++; @endphp
                @empty
                    <tr>
                        <td colspan="8" class="has-text-centered">
                            <div class="notification is-warning is-light">
                                <i class="fas fa-exclamation-triangle"></i>
                                No hay alumnos que cumplan con los criterios de búsqueda
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $matriculas->links() }}
    </div>
</div>

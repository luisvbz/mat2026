<div class="content-dashboard">
    <div class="loading-matricula" wire:loading wire:target="exportarExcel" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}" />
            </div>
            <div class="mensaje">
                Generando reporte...
            </div>
        </div>
    </div>

    <div class="content-dashboard-header">
        <div><i class="fas fa-calendar-alt"></i> Gestión de Citas</div>
    </div>

    <div class="content-dashboard-search-bar">
        <div class="columns is-multiline">
            <div class="column is-3">
                <div class="control has-icons-left">
                    <input type="text" class="input" wire:model.defer="search" wire:keydown.enter="buscar"
                        placeholder="Buscar por Alumno o Padre" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model="nivel">
                        <option value="" selected>Nivel</option>
                        <option value="P">Primaria</option>
                        <option value="S">Secundaria</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model="grado">
                        <option value="" selected>Grado</option>
                        @foreach ($grados as $g)
                            <option value="{{ $g->numero }}">{{ $g->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="column is-3">
                <div class="select is-fullwidth">
                    <select wire:model="teacher_id">
                        <option value="" selected>Profesor</option>
                        @foreach ($teachers as $tu)
                            <option value="{{ $tu->teacher_id }}">{{ $tu->teacher->nombre_completo ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model="status">
                        <option value="" selected>Estado</option>
                        <option value="pending">Pendiente</option>
                        <option value="confirmed">Confirmada</option>
                        <option value="rejected">Rechazada</option>
                        <option value="completed">Completada</option>
                        <option value="cancelled">Cancelada</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="control">
                    <input type="date" class="input" wire:model="desde" placeholder="Desde" />
                </div>
            </div>
            <div class="column is-2">
                <div class="control">
                    <input type="date" class="input" wire:model="hasta" placeholder="Hasta" />
                </div>
            </div>
            <div class="column has-text-centered">
                <button wire:click="buscar" class="button is-success"><i class="fas fa-search"></i></button>
                <button wire:click="limpiar" class="button is-danger"><i class="fas fa-eraser"></i></button>
                <button wire:click="exportarExcel" class="button is-link">Excel <i
                        class="ml-2 fas fa-file-excel"></i></button>
            </div>
        </div>
    </div>

    <div class="box-content content-dashboard-content">
        <table class="table is-fullwidth is-striped">
            <thead>
                <tr>
                    <th>Fecha / Hora</th>
                    <th>Solicitante (Padre/Madre)</th>
                    <th>Alumno</th>
                    <th>Nivel/Grado</th>
                    <th>Profesor</th>
                    <th class="has-text-centered">Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($appointments as $appointment)
                    <tr>
                        <td>
                            <strong>{{ $appointment->date ? $appointment->date->format('d/m/Y') : '' }}</strong><br>
                            <small>{{ $appointment->time ? $appointment->time->format('H:i') : '' }}</small>
                        </td>
                        <td>{{ $appointment->parent->nombre_completo ?? 'N/A' }}</td>
                        <td>{{ $appointment->student->nombre_completo ?? 'N/A' }}</td>
                        <td>
                            @if ($appointment->student && $appointment->student->matricula)
                                {{ $appointment->student->matricula->nivel == 'P' ? 'Primaria' : 'Secundaria' }} -
                                {{ $appointment->student->matricula->grado }}°
                            @else
                                N/A
                            @endif
                        </td>
                        <td>{{ $appointment->teacher->nombre_completo ?? 'N/A' }}</td>
                        <td class="has-text-centered">
                            @switch($appointment->status)
                                @case('pending')
                                    <span class="tag is-warning">Pendiente</span>
                                @break

                                @case('confirmed')
                                    <span class="tag is-success">Confirmada</span>
                                @break

                                @case('rejected')
                                    <span class="tag is-danger">Rechazada</span>
                                @break

                                @case('completed')
                                    <span class="tag is-info">Completada</span>
                                @break

                                @case('cancelled')
                                    <span class="tag is-light">Cancelada</span>
                                @break

                                @default
                                    <span class="tag is-grey">{{ $appointment->status }}</span>
                            @endswitch
                        </td>
                        <td>
                            <button wire:click="verDetalle({{ $appointment->id }})"
                                class="button is-small is-info is-light">
                                <i class="fas fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="has-text-centered">No se encontraron citas con los filtros
                                seleccionados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $appointments->links() }}
        </div>

        @if ($showModal && $selected_appointment)
            <div class="modal is-active">
                <div class="modal-background" wire:click="cerrarModal"></div>
                <div class="modal-card">
                    <header class="modal-card-head">
                        <p class="modal-card-title">Detalle de la Cita</p>
                        <button class="delete" aria-label="close" wire:click="cerrarModal"></button>
                    </header>
                    <section class="modal-card-body">
                        <div class="columns is-multiline">
                            <div class="column is-6">
                                <strong>Fecha:</strong><br>
                                {{ $selected_appointment->date->format('d/m/Y') }}
                            </div>
                            <div class="column is-6">
                                <strong>Hora:</strong><br>
                                {{ $selected_appointment->time ? $selected_appointment->time->format('H:i') : 'N/A' }}
                            </div>
                            <div class="column is-6">
                                <strong>Padre/Madre:</strong><br>
                                {{ $selected_appointment->parent->nombre_completo ?? 'N/A' }}
                            </div>
                            <div class="column is-6">
                                <strong>Alumno:</strong><br>
                                {{ $selected_appointment->student->nombre_completo ?? 'N/A' }}
                            </div>
                            <div class="column is-6">
                                <strong>Nivel/Grado:</strong><br>
                                @if ($selected_appointment->student && $selected_appointment->student->matricula)
                                    {{ $selected_appointment->student->matricula->nivel == 'P' ? 'Primaria' : 'Secundaria' }}
                                    -
                                    {{ $selected_appointment->student->matricula->grado }}°
                                @else
                                    N/A
                                @endif
                            </div>
                            <div class="column is-6">
                                <strong>Profesor:</strong><br>
                                {{ $selected_appointment->teacher->nombre_completo ?? 'N/A' }}
                            </div>
                            <div class="column is-12">
                                <strong>Asunto:</strong><br>
                                {{ $selected_appointment->subject ?? 'Sin asunto' }}
                            </div>
                            <div class="column is-12">
                                <strong>Notas:</strong><br>
                                {{ $selected_appointment->notes ?? 'Sin notas' }}
                            </div>
                            <div class="column is-6">
                                <strong>Estado:</strong><br>
                                @switch($selected_appointment->status)
                                    @case('pending')
                                        <span class="tag is-warning">Pendiente</span>
                                    @break

                                    @case('confirmed')
                                        <span class="tag is-success">Confirmada</span>
                                    @break

                                    @case('rejected')
                                        <span class="tag is-danger">Rechazada</span>
                                    @break

                                    @case('completed')
                                        <span class="tag is-info">Completada</span>
                                    @break

                                    @case('cancelled')
                                        <span class="tag is-light">Cancelada</span>
                                    @break
                                @endswitch
                            </div>
                            @if ($selected_appointment->status == 'cancelled')
                                <div class="column is-12">
                                    <strong class="has-text-danger">Motivo de Cancelación:</strong><br>
                                    {{ $selected_appointment->cancellation_reason ?? 'No especificado' }}
                                </div>
                            @endif
                        </div>
                    </section>
                    <footer class="modal-card-foot">
                        <button class="button is-danger" wire:click="cerrarModal">Cerrar</button>
                    </footer>
                </div>
            </div>
        @endif
    </div>

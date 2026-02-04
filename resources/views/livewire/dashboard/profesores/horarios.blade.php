<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-clock"></i> Gestión de Horarios</div>
        <div class="has-text-right">
            <button wire:click="create" class="button is-primary is-small">
                <i class="fas fa-plus mr-2"></i> Nuevo Horario
            </button>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="notification is-success is-light">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="notification is-danger is-light">
            {{ session('error') }}
        </div>
    @endif

    <div class="box-content content-dashboard-content">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Nombre del Horario</th>
                    <th>Días Laborales</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($horarios as $horario)
                    <tr>
                        <td><strong>{{ $horario->name }}</strong></td>
                        <td>
                            @foreach ($horario->dias->where('active', true) as $dia)
                                <span class="tag is-info is-light">
                                    {{ [1 => 'Lun', 2 => 'Mar', 3 => 'Mie', 4 => 'Jue', 5 => 'Vie', 6 => 'Sab', 7 => 'Dom'][$dia->day_number] }}:
                                    {{ substr($dia->start_time, 0, 5) }} - {{ substr($dia->end_time, 0, 5) }}
                                </span>
                            @endforeach
                        </td>
                        <td>
                            <button wire:click="edit({{ $horario->id }})" class="button is-small is-info is-outlined">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button wire:click="delete({{ $horario->id }})"
                                onclick="confirm('¿Estás seguro de eliminar este horario?') || event.stopImmediatePropagation()"
                                class="button is-small is-danger is-outlined">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="has-text-centered">No hay horarios registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal for Create/Edit -->
    <div class="modal {{ $showModal ? 'is-active' : '' }}">
        <div class="modal-background" wire:click="$set('showModal', false)"></div>
        <div class="modal-card" style="width: 800px; max-width: 95%;">
            <header class="modal-card-head">
                <p class="modal-card-title">{{ $isEditing ? 'Editar Horario' : 'Nuevo Horario' }}</p>
                <button class="delete" aria-label="close" wire:click="$set('showModal', false)"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nombre del Horario</label>
                    <div class="control">
                        <input type="text" wire:model="name" class="input"
                            placeholder="Ej: Horario Regular, Medio Tiempo, etc.">
                    </div>
                    @error('name')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <hr>
                <h5 class="title is-6">Configuración de Días</h5>

                <table class="table is-fullwidth is-narrow">
                    <thead>
                        <tr>
                            <th style="width: 50px;">Activo</th>
                            <th>Día</th>
                            <th>Hora Entrada</th>
                            <th>Hora Salida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dias as $index => $dia)
                            <tr>
                                <td class="has-text-centered">
                                    <input type="checkbox" wire:model="dias.{{ $index }}.active">
                                </td>
                                <td>{{ $dia['name'] }}</td>
                                <td>
                                    <input type="time" wire:model="dias.{{ $index }}.start_time"
                                        class="input is-small" {{ !$dia['active'] ? 'disabled' : '' }}>
                                    @error('dias.' . $index . '.start_time')
                                        <p class="help is-danger">Requerido</p>
                                    @enderror
                                </td>
                                <td>
                                    <input type="time" wire:model="dias.{{ $index }}.end_time"
                                        class="input is-small" {{ !$dia['active'] ? 'disabled' : '' }}>
                                    @error('dias.' . $index . '.end_time')
                                        <p class="help is-danger">Requerido</p>
                                    @enderror
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </section>
            <footer class="modal-card-foot">
                <button class="button is-primary" wire:click="save">Guardar Cambios</button>
                <button class="button" wire:click="$set('showModal', false)">Cancelar</button>
            </footer>
        </div>
    </div>
</div>

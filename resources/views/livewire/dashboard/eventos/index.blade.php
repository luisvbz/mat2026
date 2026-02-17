<div class="content-dashboard">
    {{-- Header --}}
    <div class="content-dashboard-header">
        <div><i class="fas fa-calendar-alt"></i> Gestión de Eventos</div>
    </div>

    {{-- Filters and Actions --}}
    <div class="columns">
        <div class="column">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input wire:model="search" class="input" type="text"
                        placeholder="Buscar por descripción o tipo...">
                </div>
                <div class="control">
                    <button class="button is-info">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="column is-narrow">
            <a href="{{ route('dashboard.eventos.crear') }}" class="button is-primary">
                <i class="fas fa-plus mr-2"></i> Nuevo Evento
            </a>
        </div>
    </div>

    {{-- Events List --}}
    <div class="box-content content-dashboard-content">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Fecha y Hora</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Enlace</th>
                    <th>Adjunto</th>
                    <th class="has-text-centered">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    <tr>
                        <td>
                            <strong>{{ $event->date->format('d/m/Y') }}</strong>
                            <br>
                            <small class="has-text-grey">{{ $event->time->format('H:i') }}</small>
                        </td>
                        <td>
                            <span class="tag is-info">
                                {{ ucfirst($event->type) }}
                            </span>
                        </td>
                        <td>
                            <span class="text-truncate d-inline-block" style="max-width: 300px;"
                                title="{{ $event->description }}">
                                {{ $event->description }}
                            </span>
                        </td>
                        <td>
                            @if ($event->link)
                                <a href="{{ $event->link }}" target="_blank" class="has-text-link">
                                    <i class="fas fa-link"></i> Ver enlace
                                </a>
                            @else
                                <span class="has-text-grey-light">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($event->attachment)
                                <a href="{{ asset($event->attachment) }}" target="_blank" class="has-text-success">
                                    <i class="fas fa-paperclip"></i> Ver adjunto
                                </a>
                            @else
                                <span class="has-text-grey-light">-</span>
                            @endif
                        </td>
                        <td class="has-text-centered">
                            <div class="dashboard-menu-opcion" x-data="{ open: false }">
                                <button class="button is-small" @click="open = true">
                                    <i class="fas fa-bars"></i>
                                </button>
                                <div class="items" x-show="open" @click.away="open = false" style="display: none;">
                                    <div class="items-option">
                                        <a href="{{ route('dashboard.eventos.editar', $event->id) }}">
                                            <i class="fas fa-edit has-text-info"></i> Editar
                                        </a>
                                    </div>
                                    <div class="items-option">
                                        <a wire:click="delete({{ $event->id }})"
                                            onclick="confirm('¿Estás seguro de eliminar este evento?') || event.stopImmediatePropagation()">
                                            <i class="fas fa-trash has-text-danger"></i> Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="has-text-centered has-text-grey py-6">
                            <i class="fas fa-calendar-times fa-3x mb-3"></i>
                            <p>No se encontraron eventos.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $events->links() }}
        </div>
    </div>
</div>

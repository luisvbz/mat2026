<div class="content-dashboard">
    {{-- Loading overlay --}}
    <div class="loading-matricula" wire:loading wire:target="save,delete,togglePublish" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}" />
            </div>
            <div class="mensaje">
                Procesando.....
            </div>
        </div>
    </div>

    {{-- Header --}}
    <div class="content-dashboard-header">
        <div><i class="fas fa-bullhorn"></i> Comunicados</div>
    </div>

    {{-- Filters and Actions --}}
    <div class="columns">
        <div class="column">
            <div class="field has-addons">
                <div class="control is-expanded">
                    <input wire:model="search" class="input" type="text"
                        placeholder="Buscar por título o contenido...">
                </div>
                <div class="control">
                    <button class="button is-info">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="column is-narrow">
            <div class="select">
                <select wire:model="filterCategory">
                    <option value="">Todas las categorías</option>
                    <option value="general">General</option>
                    <option value="academico">Académico</option>
                    <option value="administrativo">Administrativo</option>
                    <option value="evento">Evento</option>
                    <option value="urgente">Urgente</option>
                    <option value="cobro">Cobro</option>
                    <option value="actividad">Actividad</option>
                    <option value="otro">Otro</option>
                </select>
            </div>
        </div>
        <div class="column is-narrow">
            <div class="select">
                <select wire:model="filterPublished">
                    <option value="">Todos los estados</option>
                    <option value="1">Publicados</option>
                    <option value="0">Borradores</option>
                </select>
            </div>
        </div>
        <div class="column is-narrow">
            <button wire:click="create" class="button is-primary">
                <i class="fas fa-plus mr-2"></i> Nuevo Comunicado
            </button>
        </div>
    </div>

    {{-- Communications List --}}
    <div class="box-content content-dashboard-content">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr>
                    <th>Estado</th>
                    <th>Título</th>
                    <th>Categoría</th>
                    <th>Adjuntos</th>
                    <th>Fecha Publicación</th>
                    <th>Autor</th>
                    <th class="has-text-centered">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($communications as $communication)
                    <tr>
                        <td class="has-text-centered">
                            @if ($communication->is_published)
                                <span class="tag is-success">
                                    <i class="fas fa-check-circle"></i> Publicado
                                </span>
                            @else
                                <span class="tag is-warning">
                                    <i class="fas fa-clock"></i> Borrador
                                </span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $communication->title }}</strong>
                            <br>
                            <small class="has-text-grey">
                                {{ Str::limit(strip_tags($communication->content), 80) }}
                            </small>
                        </td>
                        <td>
                            <span
                                class="tag 
                            @if ($communication->category == 'urgente') is-danger
                            @elseif($communication->category == 'academico') is-info
                            @elseif($communication->category == 'evento') is-link
                            @else is-light @endif">
                                {{ ucfirst($communication->category) }}
                            </span>
                        </td>
                        <td class="has-text-centered">
                            @if ($communication->attachments->count() > 0)
                                <span class="tag is-info">
                                    <i class="fas fa-paperclip"></i> {{ $communication->attachments->count() }}
                                </span>
                            @else
                                <span class="has-text-grey-light">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($communication->published_at)
                                {{ $communication->published_at->format('d/m/Y H:i') }}
                            @else
                                <span class="has-text-grey-light">-</span>
                            @endif
                        </td>
                        <td>{{ $communication->author_name }}</td>
                        <td>
                            <div class="dashboard-menu-opcion" x-data="{ open: false }">
                                <button class="button is-small" @click="open = true">
                                    <i class="fas fa-bars"></i>
                                </button>
                                <div class="items" x-show="open">
                                    <div class="items-option" @click.away="open = false">
                                        <a wire:click="edit({{ $communication->id }})">
                                            <i class="fas fa-edit has-text-info"></i> Editar
                                        </a>
                                    </div>
                                    <div class="items-option">
                                        <a wire:click="viewStats({{ $communication->id }})">
                                            <i class="fas fa-chart-bar has-text-primary"></i> Ver Estadísticas
                                        </a>
                                    </div>
                                    <div class="items-option">
                                        <a wire:click="togglePublish({{ $communication->id }})">
                                            @if ($communication->is_published)
                                                <i class="fas fa-eye-slash has-text-warning"></i> Despublicar
                                            @else
                                                <i class="fas fa-eye has-text-success"></i> Publicar
                                            @endif
                                        </a>
                                    </div>
                                    <div class="items-option">
                                        <a wire:click="confirmDelete({{ $communication->id }})">
                                            <i class="fas fa-trash has-text-danger"></i> Eliminar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="has-text-centered has-text-grey">
                            <i class="fas fa-inbox fa-3x mb-3"></i>
                            <p>No hay comunicados para mostrar</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if ($deleteConfirmId)
        <div class="modal is-active">
            <div class="modal-background" wire:click="$set('deleteConfirmId', null)"></div>
            <div class="modal-card">
                <header class="modal-card-head has-background-danger">
                    <p class="modal-card-title has-text-white">
                        <i class="fas fa-exclamation-triangle"></i> Confirmar Eliminación
                    </p>
                    <button class="delete" wire:click="$set('deleteConfirmId', null)"></button>
                </header>
                <section class="modal-card-body">
                    <p>¿Estás seguro de que deseas eliminar este comunicado?</p>
                    <p class="has-text-danger mt-3">
                        <strong>Esta acción no se puede deshacer.</strong> Se eliminarán también todos los archivos
                        adjuntos.
                    </p>
                </section>
                <footer class="modal-card-foot">
                    <button wire:click="delete" class="button is-danger">
                        <i class="fas fa-trash mr-2"></i> Eliminar
                    </button>
                    <button wire:click="$set('deleteConfirmId', null)" class="button">Cancelar</button>
                </footer>
            </div>
        </div>
    @endif

    {{-- Statistics Modal --}}
    @if ($showStatsModal)
        <div class="modal is-active">
            <div class="modal-background" wire:click="closeStatsModal"></div>
            <div class="modal-card" style="width: 90%; max-width: 700px;">
                <header class="modal-card-head has-background-info">
                    <p class="modal-card-title has-text-white">
                        <i class="fas fa-chart-bar"></i> Estadísticas de Lectura
                    </p>
                    <button class="delete" wire:click="closeStatsModal"></button>
                </header>
                <section class="modal-card-body">
                    <h4 class="title is-5">{{ $statsData['title'] ?? '' }}</h4>

                    <div class="columns">
                        <div class="column">
                            <div class="box has-background-info-light">
                                <p class="heading">Total de Lecturas</p>
                                <p class="title is-3">{{ $statsData['total_reads'] ?? 0 }}</p>
                            </div>
                        </div>
                        <div class="column">
                            <div class="box has-background-success-light">
                                <p class="heading">Porcentaje Leído</p>
                                <p class="title is-3">{{ $statsData['read_percentage'] ?? 0 }}%</p>
                            </div>
                        </div>
                    </div>

                    @if (!empty($statsData['reads']))
                        <div class="mt-4">
                            <p class="has-text-weight-semibold mb-3">Padres que han leído:</p>
                            <div class="table-container">
                                <table class="table is-fullwidth is-striped is-hoverable">
                                    <thead>
                                        <tr>
                                            <th>Padre/Madre</th>
                                            <th>Documento</th>
                                            <th>Fecha de Lectura</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($statsData['reads'] as $read)
                                            <tr>
                                                <td>{{ $read['parent_name'] }}</td>
                                                <td>{{ $read['document'] }}</td>
                                                <td>{{ $read['read_at'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="notification is-warning">
                            <i class="fas fa-info-circle"></i> Aún no hay lecturas registradas para este comunicado.
                        </div>
                    @endif
                </section>
                <footer class="modal-card-foot">
                    <button wire:click="closeStatsModal" class="button">Cerrar</button>
                </footer>
            </div>
        </div>
    @endif
</div>

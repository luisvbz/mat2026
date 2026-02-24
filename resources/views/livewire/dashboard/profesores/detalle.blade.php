<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-user-tie"></i> Detalle del Profesor</div>
        <div class="has-text-right">
            <a href="{{ route('dashboard.profesores') }}" class="button is-small"><i class="fas fa-arrow-left mr-2"></i>
                Volver</a>
            <a href="{{ route('dashboard.profesores.editar', $teacher->id) }}" class="button is-primary is-small ml-2"><i
                    class="fas fa-edit mr-2"></i> Editar</a>
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

    <div class="columns">
        <div class="column is-4">
            <div class="box-content has-text-centered">
                <figure class="image is-128x128 is-inline-block">
                    <img class="is-rounded" src="{{ $teacher->foto }}"
                        onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($teacher->nombres . ' ' . $teacher->apellidos) }}&color=7F9CF5&background=EBF4FF'">
                </figure>
                <h3 class="title is-4 mt-3">{{ $teacher->nombres }} {{ $teacher->apellidos }}</h3>
                <p class="subtitle is-6">{{ $teacher->documento }}</p>
                <div class="tags is-justify-content-center">
                    <span class="tag {{ $teacher->estado == 1 ? 'is-success' : 'is-danger' }}">
                        {{ $teacher->estado == 1 ? 'Activo' : 'Inactivo' }}
                    </span>
                    <span class="tag is-info">{{ $teacher->horario->name ?? 'Sin horario' }}</span>
                </div>

                @if (!$teacher->user)
                    <div class="mt-4">
                        <button wire:click="crearUsuario" class="button is-warning is-small is-fullwidth">
                            <i class="fas fa-user-plus mr-2"></i> Crear Usuario
                        </button>
                    </div>
                @endif
            </div>

            <div class="box-content mt-4">
                <h4 class="title is-5">Información de Usuario</h4>
                @if ($teacher->user)
                    <p><strong>Usuario:</strong> {{ $teacher->user->document_number }}</p>
                    <p><strong>Estado:</strong> {{ $teacher->user->is_active ? 'Activo' : 'Inactivo' }}</p>
                    <p><strong>Último acceso:</strong>
                        {{ $teacher->user->last_login_at ? $teacher->user->last_login_at->diffForHumans() : 'Nunca' }}
                    </p>
                @else
                    <p class="has-text-grey">No tiene usuario asociado.</p>
                @endif
            </div>
        </div>

        <div class="column is-8">
            <div class="tabs is-boxed">
                <ul>
                    <li class="{{ $activeTab === 'info' ? 'is-active' : '' }}">
                        <a wire:click="setTab('info')">
                            <span class="icon is-small"><i class="fas fa-info-circle"></i></span>
                            <span>Información</span>
                        </a>
                    </li>
                    <li class="{{ $activeTab === 'appointments' ? 'is-active' : '' }}">
                        <a wire:click="setTab('appointments')">
                            <span class="icon is-small"><i class="fas fa-calendar-check"></i></span>
                            <span>Citas
                                ({{ \App\Models\Appointment::where('teacher_id', $teacher->id)->count() }})</span>
                        </a>
                    </li>
                    <li class="{{ $activeTab === 'messages' ? 'is-active' : '' }}">
                        <a wire:click="setTab('messages')">
                            <span class="icon is-small"><i class="fas fa-envelope"></i></span>
                            <span>Agenda
                                ({{ $teacher->user ? \App\Models\AgendaMessage::where('teacher_user_id', $teacher->user->id)->count() : 0 }})</span>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="box-content" style="min-height: 400px;">
                @if ($activeTab === 'info')
                    <h4 class="title is-5">Datos Personales</h4>
                    <table class="table is-fullwidth">
                        <tr>
                            <th style="width: 200px;">Nombres:</th>
                            <td>{{ $teacher->nombres }}</td>
                        </tr>
                        <tr>
                            <th>Apellidos:</th>
                            <td>{{ $teacher->apellidos }}</td>
                        </tr>
                        <tr>
                            <th>DNI / Documento:</th>
                            <td>{{ $teacher->documento }}</td>
                        </tr>
                        <tr>
                            <th>Correo Electrónico:</th>
                            <td>{{ $teacher->correo ?? 'No registrado' }}</td>
                        </tr>
                        <tr>
                            <th>Teléfono:</th>
                            <td>{{ $teacher->telefono ?? 'No registrado' }}</td>
                        </tr>
                        <tr>
                            <th>Horario Asignado:</th>
                            <td>{{ $teacher->horario->name ?? 'No asignado' }}</td>
                        </tr>
                    </table>
                @endif

                @if ($activeTab === 'appointments')
                    <h4 class="title is-5">Historial de Citas</h4>
                    <div class="mb-4 box is-light p-3">
                        <div class="columns is-mobile is-multiline">
                            <div class="column is-3">
                                <div class="field">
                                    <label class="label is-small">Nivel</label>
                                    <div class="control">
                                        <div class="select is-small is-fullwidth">
                                            <select wire:model="filterNivel">
                                                <option value="">Todos</option>
                                                <option value="P">Primaria</option>
                                                <option value="S">Secundaria</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-3">
                                <div class="field">
                                    <label class="label is-small">Grado</label>
                                    <div class="control">
                                        <div class="select is-small is-fullwidth">
                                            <select wire:model="filterGrado">
                                                <option value="">Todos</option>
                                                @for ($i = 1; $i <= 6; $i++)
                                                    <option value="{{ $i }}">{{ $i }}°</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-4">
                                <div class="field">
                                    <label class="label is-small">Fecha</label>
                                    <div class="control">
                                        <input type="date" wire:model="filterFecha" class="input is-small">
                                    </div>
                                </div>
                            </div>
                            <div class="column is-2 is-flex is-align-items-end">
                                <button class="button is-small is-light"
                                    wire:click="$set('filterNivel', ''); $set('filterGrado', ''); $set('filterFecha', '');">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <table class="table is-fullwidth is-hoverable is-narrow">
                        <thead>
                            <tr>
                                <th>Fecha/Hora</th>
                                <th>Alumno</th>
                                <th>Padre</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($appointments as $appointment)
                                <tr>
                                    <td>
                                        {{ $appointment->date->format('d/m/Y') }} <br>
                                        <small>{{ $appointment->time->format('H:i') }}</small>
                                    </td>
                                    <td>{{ $appointment->student->nombres ?? 'N/A' }}
                                        {{ $appointment->student->apellidos ?? '' }}</td>
                                    <td>{{ $appointment->parent->nombres ?? 'N/A' }}
                                        {{ $appointment->parent->apellidos ?? '' }}</td>
                                    <td>
                                        <span
                                            class="tag is-small {{ $appointment->status === 'confirmed' ? 'is-success' : ($appointment->status === 'pending' ? 'is-warning' : 'is-danger') }}">
                                            {{ ucfirst($appointment->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="has-text-centered">No hay citas registradas.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif

                @if ($activeTab === 'messages')
                    <div class="mb-4 box is-light p-3">
                        <div class="columns is-mobile is-multiline">
                            <div class="column is-3">
                                <div class="field">
                                    <label class="label is-small">Nivel</label>
                                    <div class="control">
                                        <div class="select is-small is-fullwidth">
                                            <select wire:model="filterNivel">
                                                <option value="">Todos</option>
                                                <option value="P">Primaria</option>
                                                <option value="S">Secundaria</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-3">
                                <div class="field">
                                    <label class="label is-small">Grado</label>
                                    <div class="control">
                                        <div class="select is-small is-fullwidth">
                                            <select wire:model="filterGrado">
                                                <option value="">Todos</option>
                                                @for ($i = 1; $i <= 6; $i++)
                                                    <option value="{{ $i }}">{{ $i }}°</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="column is-4">
                                <div class="field">
                                    <label class="label is-small">Fecha</label>
                                    <div class="control">
                                        <input type="date" wire:model="filterFecha" class="input is-small">
                                    </div>
                                </div>
                            </div>
                            <div class="column is-2 is-flex is-align-items-end">
                                <button class="button is-small is-light"
                                    wire:click="$set('filterNivel', ''); $set('filterGrado', ''); $set('filterFecha', '');">
                                    <i class="fas fa-undo"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <h4 class="title is-5">Mensajes de Agenda</h4>
                    <table class="table is-fullwidth is-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Alumno</th>
                                <th>Asunto</th>
                                <th>Estado</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $msg)
                                <tr style="cursor: pointer;" wire:click="openAgendaModal({{ $msg->id }})">
                                    <td>{{ $msg->date->format('d/m/Y') }}</td>
                                    <td>
                                        {{ $msg->matricula->alumno->apellido_paterno }}
                                        {{ $msg->matricula->alumno->nombres }}
                                    </td>
                                    <td>{{ $msg->subject }}</td>
                                    <td>
                                        <span class="tag {{ $msg->is_read ? 'is-success' : 'is-warning' }}">
                                            {{ $msg->is_read ? 'Leído' : 'Pendiente' }}
                                        </span>
                                    </td>
                                    <td><i class="fas fa-chevron-right"></i></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="has-text-centered">No hay mensajes registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal para Detalle de Agenda -->
    <div class="modal {{ $showAgendaModal ? 'is-active' : '' }}">
        <div class="modal-background" wire:click="closeAgendaModal"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Detalle de Agenda</p>
                <button class="delete" aria-label="close" wire:click="closeAgendaModal"></button>
            </header>
            <section class="modal-card-body">
                @if ($selectedAgenda)
                    <div class="content">
                        <p><strong>Fecha:</strong> {{ $selectedAgenda->date->format('d/m/Y') }}</p>
                        <p><strong>Alumno:</strong> {{ $selectedAgenda->matricula->alumno->nombre_completo }}</p>
                        <p><strong>Asunto:</strong> {{ $selectedAgenda->subject }}</p>
                        <div class="box is-light">
                            <strong>Mensaje:</strong>
                            <p>{{ $selectedAgenda->message }}</p>
                        </div>

                        <hr>
                        <h4 class="title is-6"><i class="fas fa-reply mr-2"></i> Respuestas</h4>

                        @forelse($selectedAgenda->replies as $reply)
                            <article class="media">
                                <div class="media-content">
                                    <div class="content">
                                        <p>
                                            <strong>{{ $reply->author_type === 'parent' ? 'Padre/Apoderado' : 'Profesor' }}</strong>
                                            <small
                                                class="is-pulled-right">{{ $reply->created_at->format('d/m/Y H:i') }}</small>
                                            <br>
                                            {{ $reply->message }}
                                        </p>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="has-text-grey is-italic">Sin respuestas aún.</p>
                        @endforelse
                    </div>
                @endif
            </section>
            <footer class="modal-card-foot">
                <button class="button" wire:click="closeAgendaModal">Cerrar</button>
            </footer>
        </div>
    </div>
</div>

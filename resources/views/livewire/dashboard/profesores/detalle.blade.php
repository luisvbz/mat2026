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
                            <th>Horario Asignado:</th>
                            <td>{{ $teacher->horario->name ?? 'No asignado' }}</td>
                        </tr>
                    </table>
                @endif

                @if ($activeTab === 'appointments')
                    <h4 class="title is-5">Historial de Citas</h4>
                    <table class="table is-fullwidth is-striped">
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
                    <h4 class="title is-5">Mensajes de Agenda</h4>
                    <table class="table is-fullwidth is-striped">
                        <thead>
                            <tr>
                                <th>Fecha</th>
                                <th>Alumno</th>
                                <th>Asunto</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $message)
                                <tr>
                                    <td>{{ $message->date->format('d/m/Y') }}</td>
                                    <td>{{ $message->matricula->alumno->nombres ?? 'N/A' }}</td>
                                    <td>{{ $message->subject }}</td>
                                    <td>
                                        @if ($message->is_read)
                                            <span class="tag is-success is-light">Leído</span>
                                        @else
                                            <span class="tag is-warning is-light">Pendiente</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="has-text-centered">No hay mensajes de agenda registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</div>

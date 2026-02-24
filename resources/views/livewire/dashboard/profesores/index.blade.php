<div class="content-dashboard">
    <div class="loading-matricula" wire:loading wire:targe="getCarnet" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}" />
            </div>
            <div class="mensaje">
                Procesando.....
            </div>
        </div>
    </div>
    <div class="content-dashboard-header">
        <div><i class="fas fa-graduation-cap"></i> Profesores</div>
        <div class="has-text-right">
            <a href="{{ route('dashboard.profesores.horarios') }}" class="button is-info is-small mr-2">
                <i class="fas fa-clock mr-2"></i> Gestión de Horarios
            </a>
            <a href="{{ route('dashboard.profesores.nuevo') }}" class="button is-primary is-small">
                <i class="fas fa-plus mr-2"></i> Nuevo Profesor
            </a>
        </div>
    </div>
    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column is-8">
                <div class="control has-icons-left">
                    <input type="text" class="input" wire:model.defer="search"
                        placeholder="Buscar por nombre o DNI del profesor" />
                    <span class="icon is-small is-left">
                        <i class="fas fa-search"></i>
                    </span>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model.defer="estado">
                        <option value="" selected>Estado</option>
                        <option value="0">Inactivo</option>
                        <option value="1">Activo</option>
                    </select>
                </div>
            </div>
            <div class="column has-text-centered">
                <button wire:click="buscar" class="button is-success"><i class="fas fa-search"></i></button>
                <button wire:click="limpiar" class="button is-danger"><i class="fas fa-eraser"></i></button>
            </div>
        </div>
    </div>

    <div class="box-content content-dashboard-content">
        <table class="table">
            <thead>
                <tr>
                    <th class="has-text-centered">Estado</th>
                    <th>Documento</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>Horario</th>
                    <th>Email</th>
                    <th>Celular</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($teachers as $teacher)
                    <tr>
                        <td class="has-text-centered">{!! $teacher->status !!}</td>
                        <td>{{ $teacher->documento }}</td>
                        <td>{{ $teacher->apellidos }}</td>
                        <td>{{ $teacher->nombres }}</td>
                        <td>{{ $teacher->horario->name }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>
                            {{ $teacher->telefono }}
                            @if ($teacher->telefono)
                                <a href="https://wa.me/51{{ $teacher->telefono }}" target="_blank"
                                    class="has-text-success ml-2" title="Enviar WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            @endif
                        </td>
                        <td>
                            <div class="dashboard-menu-opcion" x-data="{ open: false }">
                                <button class="button is-small" @click="open = true"><i
                                        class="fas fa-bars"></i></button>
                                <div class="items" x-show="open">
                                    <div class="items-option" @click.away="open = false">
                                        <a href="{{ route('dashboard.profesores.detalle', $teacher->id) }}"><i
                                                class="fas fa-eye"></i> Ver Detalle</a>
                                    </div>
                                    <div class="items-option" @click.away="open = false">
                                        <a href="{{ route('dashboard.profesores.editar', $teacher->id) }}"><i
                                                class="fas fa-edit"></i> Editar</a>
                                    </div>
                                    @if ($teacher->estado == 0)
                                        <div class="items-option" @click.away="open = false">
                                            <a wire:click="activar({{ $teacher->id }})"><i
                                                    class="fas fa-check-double has-text-success"></i> Activar</a>
                                        </div>
                                    @elseif($teacher->estado == 1)
                                        <div class="items-option" @click.away="open = false">
                                            <a wire:click="desactivar({{ $teacher->id }})"><i
                                                    class="fas fa-ban has-text-danger"></i> Desactivar</a>
                                        </div>
                                    @endif
                                    <div class="items-option" @click.away="open = false">
                                        <a wire:click="showDialogEliminar({{ $teacher->id }})">
                                            <i class="fas fa-trash-alt has-text-danger"></i> Eliminar
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="8" class="has-text-centered">No hay resultados que mostrar</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

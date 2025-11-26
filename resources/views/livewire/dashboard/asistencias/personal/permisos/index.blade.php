<div class="content-dashboard-content">
    <livewire:commons.mod-asistencia />
    <div class="content-dashboard">
        <div class="content-dashboard-header">
            <div><i class="fas fa-money-bill"></i> Permisos de Personal</div>
        </div>
        <div class="content-dashboard-search-bar">
            <div class="columns">
                <div class="column is-4">
                    <div class="field">
                        <div class="select is-fullwidth">
                            <select wire:model="profesor">
                                <option value="">Seleccione el personal</option>
                                @foreach($profesores as $p)
                                <option value="{{ $p->id }}">{{ $p->apellidos.', '.$p->nombres }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="column-is-2">
                    <div class="field">
                        <a href="{{ route('permisos-profesores.nuevo') }}" class="mt-2 button is-primary">Nuevo <i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-content content-dashboard-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>Tipo</th>
                        <th>Colaborador</th>
                        <th>Entrada (Desde)</th>
                        <th>Salida (Hasta)</th>
                        <th>Motivo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($permisos as $permiso)
                    <tr>
                        <td class="has-text-weight-bold">{{ $permiso->tipo == 'E' ? 'Entrada Tarde' : ($permiso->tipo == 'S' ? 'Salida Temprano' : 'Falta Fustificada' )}}</td>
                        <td>{{ $permiso->profesor->nombres }}</td>
                        <td>
                            @if($permiso->tipo == 'E')
                            {{ $permiso->hasta | date:'d/m/Y h:i a'}}
                            @elseif($permiso->tipo == 'S')
                            --
                            @else
                            {{ $permiso->desde | date:'d/m/Y'}}
                            @endif
                        </td>
                        <td>
                            @if($permiso->tipo == 'E')
                            --
                            @elseif($permiso->tipo == 'S')
                            {{ $permiso->desde | date:'d/m/Y h:i a'}}
                            @else
                            {{ $permiso->hasta | date:'d/m/Y'}}
                            @endif
                        </td>
                        <td>{{ $permiso->comentario }}</td>
                        <td>
                            <div class="dashboard-menu-opcion" x-data="{ open: false }">
                                <button class="button is-small" @click="open = true"><i class="fas fa-bars"></i></button>
                                <div class="items" x-show="open">
                                    <div class="items-option" @click.away="open = false">
                                        <a href="{{ route('permisos-profesores.editar', [$permiso->id]) }}"><i class="fas fa-edit has-text-success"></i> Editar</a>
                                    </div>
                                    <div class="items-option" @click.away="open = false">
                                        <a wire:click="showDialogEliminarPermiso({{ $permiso->id }})"><i class="fas fa-ban has-text-danger"></i> Eliminar</a>
                                    </div>
                                </div>
                            </div>
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="6" class="has-text-centered">No hay resultados que mostrar</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

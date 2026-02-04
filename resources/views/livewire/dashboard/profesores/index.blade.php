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
        <div class="flex-grow">
            <input type="text" wire:model.debounce.500ms="search" class="input is-small"
                placeholder="Buscar por nombre, apellido o documento..." style="max-width: 300px; margin-left: 20px;">
        </div>
        <div class="has-text-right">
            <a href="{{ route('dashboard.profesores.nuevo') }}" class="button is-primary is-small"><i
                    class="fas fa-plus mr-2"></i> Nuevo Profesor</a>
            <button wire:click="getCarnet" class="button is-small ml-2">Generar QR's <i
                    class="ml-2 fas fa-qrcode"></i></button>
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
                        <td>
                            <div class="dashboard-menu-opcion" x-data="{ open: false }">
                                <button class="button is-small" @click="open = true"><i
                                        class="fas fa-bars"></i></button>
                                <div class="items" x-show="open">
                                    <div class="items-option" @click.away="open = false">
                                        <a href="{{ route('dashboard.profesores.detalle', $teacher->id) }}"><i
                                                class="fas fa-eye"></i> Ver Detalle</a>
                                        @if ($teacher->estado == 0)
                                            <a wire:click="activar({{ $teacher->id }})"><i
                                                    class="fas fa-check-double has-text-success"></i> Activar</a>
                                        @elseif($teacher->estado == 1)
                                            <a wire:click="desactivar({{ $teacher->id }})"><i
                                                    class="fas fa-ban has-text-danger"></i> Desactivar</a>
                                        @endif
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

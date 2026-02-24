<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-calendar-times"></i> Gestión de Feriados</div>
        <div class="has-text-right">
            <a href="{{ route('asistencias.index') }}" class="button is-info is-small">
                <i class="fas fa-arrow-left mr-2"></i> Regresar a Asistencias
            </a>
        </div>
    </div>

    <div class="columns">
        <div class="column is-4">
            <div class="box-content">
                <h3 class="title is-5"><i class="fas fa-plus-circle mr-2"></i> Nuevo Feriado</h3>
                <form wire:submit.prevent="guardat">
                    <div class="field">
                        <label class="label">Fecha del Feriado</label>
                        <div class="control">
                            <input type="date" class="input @error('fecha_feriado') is-danger @enderror"
                                wire:model="fecha_feriado">
                        </div>
                        @error('fecha_feriado')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field">
                        <label class="label">Descripción</label>
                        <div class="control">
                            <input type="text" class="input @error('descripcion') is-danger @enderror"
                                wire:model="descripcion" placeholder="Ej: Navidad, Año Nuevo...">
                        </div>
                        @error('descripcion')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="field mt-5">
                        <div class="control">
                            <button type="submit" class="button is-primary is-fullwidth">
                                <i class="fas fa-save mr-2"></i> Guardar Feriado
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="column is-8">
            <div class="box-content content-dashboard-content">
                <h3 class="title is-5"><i class="fas fa-list mr-2"></i> Listado de Feriados</h3>
                <table class="table is-fullwidth is-striped is-hoverable">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Descripción</th>
                            <th class="has-text-centered">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($feriados as $feriado)
                            @php
                                $fechaRaw = \Carbon\Carbon::parse($feriado->getRawOriginal('fecha_feriado'));
                                $esPasado = $fechaRaw->isPast() && !$fechaRaw->isToday();
                            @endphp
                            <tr>
                                <td>
                                    <span class="tag is-info is-light">
                                        {{ $feriado->fecha_feriado }}
                                    </span>
                                </td>
                                <td>{{ $feriado->descripcion }}</td>
                                <td class="has-text-centered">
                                    @if (!$esPasado)
                                        <button wire:click="showDialogEliminar({{ $feriado->id }})"
                                            class="button is-danger is-small" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @else
                                        <button class="button is-small is-disabled" disabled
                                            title="No se puede eliminar un feriado pasado">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="has-text-centered">No hay feriados registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

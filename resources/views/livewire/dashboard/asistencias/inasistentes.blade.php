<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-money-bill"></i> Estudiantes sin marcanción</div>
    </div>
    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model="nivel">
                        <option value="">Seleccione..</option>
                        <option value="P">Primaria</option>
                        <option value="S">Secundaria</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model="grado">
                        <option value="">Seleccione..</option>
                        @foreach($grados as $g)
                        <option value="{{ $g->numero }}">{{ $g->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="is-fullwidth">
                    <input type="date" wire:model='date' max="date('Y-m-d')" min="date('Y-m-d')" class="input" readonly />
                </div>
            </div>
            @if(count($inasistentes) > 0)
            <div class="column is-2">
                <button wire:click="showDialogMarcaTodos()" class="button is-primary is-small">Marcar asistencia de todos <i class="ml-2 fas fa-hammer"></i></button>
            </div>
            @endif
        </div>
    </div>
    <div class="box-content content-dashboard-content">
        <table class="table">
            <thead>
                <tr>
                    <th>DNI/CE/PTP</th>
                    <th>Alumno</th>
                    <th>Nivel</th>
                    <th>Grado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($inasistentes as $matricula)
                <tr>
                    <td>{{ $matricula->alumno->numero_documento }}</td>
                    <td>{{ trim($matricula->alumno->apellido_paterno.' '.$matricula->alumno->apellido_materno.' '.$matricula->alumno->nombres) }}</td>
                    <td>{{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</td>
                    <td>{{ $matricula->grado | grado }}</td>
                    <td>
                        <button wire:click="showDialogMarcarAsistencia({{ $matricula->id }}, true)" class="button is-small is-primary"><i class="fas fa-calendar-day"></i></button>
                        <button wire:click="showDialogMarcarAsistencia({{ $matricula->id }})" class="button is-small is-success"><i class="fas fa-hammer"></i></button>
                        {{-- <div class="dashboard-menu-opcion" x-data="{ open: false }">
                            <button class="button is-small" @click="open = true"><i class="fas fa-bars"></i></button>
                            <div class="items" x-show="open">
                                <div class="items-option" @click.away="open = false">
                                    <a href="{{ route('dashboard.detalle-matricula', [$matricula->codigo]) }}"><i class="fas fa-search-plus has-text-primary"></i> Ver mas detalles</a>
    </div>
    <div class="items-option" @click.away="open = false">
        <a wire:click="descargarFicha({{ $matricula->id }})"><i class="fas fa-file-pdf has-text-success"></i> Descargar ficha</a>
    </div>

    <div class="items-option" @click.away="open = false">
        @if($matricula->estado == 0)
        <a wire:click="showDialogConfirmMatricula({{ $matricula->id }})"><i class="fas fa-check-double has-text-success"></i> Confirmar</a>
        @elseif($matricula->estado == 1)
        <a wire:click="showDialogAnularMatricula({{ $matricula->id }})"><i class="fas fa-ban has-text-danger"></i> Anular</a>
        @endif
    </div>
</div>
</div> --}}
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
<div class="loading-matricula" wire:loading wire:target="descargarFicha" style="display: none;">
    <div class="loading-matricula-body" style="margin: 100px auto;">
        <div class="spinner" style="text-align: center;">
            <img src="{{ asset('images/loader.svg') }}" />
        </div>
        <div class="mensaje">
            Procesando.....
        </div>
    </div>
</div>
</div>

<div class="content-dashboard">
    <div class="content-dashboard-header">
        <div><i class="fas fa-alarm-clock"></i> Recordatorios de pagos enviados</div>
    </div>
    {{--
    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column is-4">
                <div class="control has-icons-left">
                    <input type="text" class="input" wire:model.defer="search" placeholder="Buscar por nombre o DNI del estudiante"/>
                    <span class="icon is-small is-left">
                            <i class="fas fa-search"></i>
                        </span>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model.defer="estado">
                        <option value="" selected>Estado</option>
                        <option value="0">Pendiente</option>
                        <option value="1">Confirmada</option>
                        <option value="2">Anulada</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model.defer="nivel">
                        <option value="" selected>Nivel</option>
                        <option value="P">Primaria</option>
                        <option value="S">Secundaria</option>
                    </select>
                </div>
            </div>
            <div class="column is-2">
                <div class="select is-fullwidth">
                    <select wire:model.defer="grado">
                        <option value="" selected>Grado</option>
                        <option value="1">Primero</option>
                        <option value="2">Segundo</option>
                        <option value="3">Tercero</option>
                        <option value="4">Cuarto</option>
                        <option value="5">Quinto</option>
                        <option value="6">Sexto</option>
                    </select>
                </div>
            </div>
            <div class="column has-text-centered">
                <button wire:click="buscar" class="button is-success"><i class="fas fa-search"></i></button>
                <button wire:click="limpiar" class="button is-danger"><i class="fas fa-eraser"></i></button>
            </div>
        </div>
    </div>
    --}}
    <div class="content-dashboard-content box-content">
        <table class="table">
            <thead>
            <tr>
                <th class="has-text-centered">Estado</th>
                <th>Alumno</th>
                <th>Destinatario</th>
                <th>Parentesco</th>
                <th>Grado</th>
                <th>Nivel</th>
                <th class="has-text-centered">Meses</th>
                <th class="has-text-centered">Número</th>
                <th>Fecha</th>
            </tr>
            </thead>
            <tbody>
            @forelse($recordatorios as $recordatorio)
                <tr>
                    <td class="has-text-centered">{!! $recordatorio->status !!}</td>
                    <td>{{ $recordatorio->matricula->alumno->nombre_completo }}</td>
                    <td>{{ $recordatorio->destinatario }}</td>
                    <td>{{ $recordatorio->padre->parentesco == 'P' ? 'Padre' : 'Madre' }}</td>
                    <td>{{ $recordatorio->matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</td>
                    <td>{{ $recordatorio->matricula->grado | grado }}</td>
                    <td class="has-text-centered">{{ $recordatorio->meses }}</td>
                    <td class="has-text-centered">{{ $recordatorio->numero }}</td>
                    <td>{{ $recordatorio->created_at | dateFormat }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="has-text-centered">No hay resultados que mostrar</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $recordatorios->links() }}
    </div>
</div>

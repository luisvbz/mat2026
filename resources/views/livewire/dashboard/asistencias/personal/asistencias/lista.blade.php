<div class="content-dashboard-content">
    <livewire:commons.mod-asistencia />
    <div class="content-dashboard">
        <div class="content-dashboard-header">
            <div><i class="fas fa-money-bill"></i> Permisos de Personal</div>
        </div>
        <div class="content-dashboard-search-bar">
            <div class="columns">
                <div class="column is-2">
                    <input type="date" class="input" wire:model="date" max="{{ date('Y-m-d') }}" />
                </div>
                <div class="column is-2" style="border-left:2px solid #ccc;">
                    <div class="select is-fullwidth">
                        <select wire:model.defer="mes">
                            @foreach($meses as $mes)
                            <option value="{{ $mes['numero'] }}">{{ $mes['nombre'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="column is-2">
                    <button wire:click="generarReporte" class="button is-primary is-small">Generar Reporte Mensual</button>
                </div>
            </div>
        </div>
        <div class="columns is-centered">
            <div class="column is-10">
                <div class="box-content content-dashboard-content">
                    <table class="table is-bordered is-striped">
                        <thead>
                            <tr class="has-text-weight-bold is-size-7 has-background-grey-lighter">
                                <th>Colaborador</th>
                                <th>Entrada</th>
                                <th>Comentario E.</th>
                                <th>Salida</th>
                                <th>Comentario S.</th>
                            </tr>
                        </thead>
                        @foreach($profesores as $p)
                        <tr>
                            <td style="width: 40%;">{{ $p->apellidos }}, {{ $p->nombres }}</td>
                            @if($p->asistencia)
                            @if($p->asistencia->tipo == 'N')
                            <td style="width: 15%;">{{ $p->asistencia->entrada |  date:'h:i:s a' }}</td>
                            <td style="width: 15%;" class="has-text-success has-background-success-light">A TIEMPO <i class="fas fa-check-circle"></i></td>
                            <td style="width: 15%;">
                                @if ($p->asistencia->salida)
                                {{ $p->asistencia->salida |  date:'h:i:s a' }}
                                @else
                                -
                                @endif
                            </td>
                            {{-- salida anticipada --}}
                            @if($p->asistencia->salida_anticipada ||$p->asistencia->comentario_salida)
                            <td style="width: 15%;" class="has-background-danger-light has-text-danger">
                                {{ $p->asistencia->comentario_salida }} @if($p->asistencia->salida_anticipada) <b>{{ $p->asistencia->salida_anticipada }}</b> @endif
                            </td>
                            @else
                            @if($p->asistencia->salida)
                            <td style="width: 15%;" class="has-text-success has-background-success-light">A TIEMPO <i class="fas fa-check-circle"></i></td>
                            @else
                            <td style="width: 15%;">-</td>
                            @endif
                            @endif
                            {{-- /salida anticipada --}}
                            @elseif($p->asistencia->tipo == 'T')
                            <td style="width: 15%;">{{ $p->asistencia->entrada |  date:'h:i:s a' }}</td>
                            <td style="width: 15%;" class="has-text-danger has-background-danger-light"><b>{{ $p->asistencia->tardanza_entrada}}</b></td>
                            <td style="width: 15%;">
                                @if ($p->asistencia->salida)
                                {{ $p->asistencia->salida |  date:'h:i:s a' }}
                                @else
                                -
                                @endif
                            </td>
                            {{-- salida anticipada --}}
                            @if($p->asistencia->salida_anticipada ||$p->asistencia->comentario_salida)
                            <td style="width: 15%;" class="has-background-danger-light has-text-danger">
                                {{ $p->asistencia->comentario_salida }} @if($p->asistencia->salida_anticipada) <b>{{ $p->asistencia->salida_anticipada }}</b> @endif
                            </td>
                            @else
                            @if($p->asistencia->salida)
                            <td style="width: 15%;" class="has-text-success has-background-success-light">A TIEMPO <i class="fas fa-check-circle"></i></td>
                            @else
                            <td style="width: 15%;">-</td>
                            @endif
                            @endif
                            {{-- /salida anticipada --}}
                            @elseif($p->asistencia->tipo == 'NL')
                            <td colspan="4" class="has-background-white-bis">
                                No laborable segun horario
                            </td>
                            @elseif($p->asistencia->tipo == 'FI')
                            <td colspan="4" class="has-background-danger-light has-text-danger">
                                Falta Injustificada
                            </td>
                            @elseif($p->asistencia->tipo == 'FJ')
                            <td colspan="4" class="has-background-white-bis">
                                Falta Justificada
                            </td>
                            @elseif($p->asistencia->tipo == 'F')
                            <td colspan="4" class="has-background-white-bis">
                                Feriado
                            </td>
                            @endif
                            @else
                            @if($p->tipo == 'NL')
                            <td colspan="4" class="has-background-white-bis">
                                No laborable segun horario
                            </td>
                            @elseif($p->tipo == 'FI')
                            <td colspan="4" class="has-background-danger-light has-text-danger">
                                Falta Injustificada
                            </td>
                            @endif
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

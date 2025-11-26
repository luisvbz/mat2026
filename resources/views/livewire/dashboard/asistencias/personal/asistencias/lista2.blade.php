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
            </div>
        </div>
        <div class="columns is-centered">
            <div class="column is-10">
                <div class="box-content content-dashboard-content">
                    <table class="table is-bordered is-striped">
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
                            <td style="width: 15%;">
                                {{ $p->asistencia->comentario_salida }} @if($p->asistencia->salida_anticipada) {{ $p->asistencia->salida_anticipada }} @endif
                            </td>
                            @elseif($p->asistencia->tipo == 'T')
                            <td style="width: 15%;">{{ $p->asistencia->entrada |  date:'h:i:s a' }}</td>
                            <td style="width: 15%;" class="has-text-danger has-background-danger-light">{{ $p->asistencia->tardanza_entrada}}</td>
                            <td style="width: 15%;">
                                @if ($p->asistencia->salida)
                                {{ $p->asistencia->salida |  date:'h:i:s a' }}
                                @else
                                -
                                @endif
                            </td>
                            <td style="width: 15%;">
                                {{ $p->asistencia->comentario_salida }} @if($p->asistencia->salida_anticipada) {{ $p->asistencia->salida_anticipada }} @endif
                            </td>
                            @elseif($p->asistencia->tipo == 'NL')
                            <td colspan="4" class="has-background-grey-lighter">
                                No laborable segun horario
                            </td>
                            @elseif($p->asistencia->tipo == 'FI')
                            <td colspan="4" class="has-background-danger-light has-text-danger">
                                Falta Injustificada
                            </td>
                            @elseif($p->asistencia->tipo == 'FJ')
                            <td colspan="4" class="has-background-grey-lighter">
                                Falta Justificada
                            </td>
                            @elseif($p->asistencia->tipo == 'F')
                            <td colspan="4" class="has-background-grey-lighter">
                                Feriado
                            </td>
                            @endif
                            @else
                            @if($p->tipo == 'NL')
                            <td colspan="4" class="has-background-grey-lighter">
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

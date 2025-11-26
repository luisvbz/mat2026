<div x-data="pagosPensiones()" x-init="suscribe()">
    <livewire:commons.mod-contable/>
    <div class="content-dashboard">
        <div class="loading-matricula"  wire:loading wire:target="verComprobante" style="display: none;">
            <div class="loading-matricula-body" style="margin: 100px auto;">
                <div class="spinner" style="text-align: center;">
                    <img src="{{ asset('images/loader.svg') }}"/>
                </div>
                <div class="mensaje">
                    Cargando.....
                </div>
            </div>
        </div>
        <div class="content-dashboard-header">
            <div><i class="fas fa-money-bill"></i> Pagos recibidos por pensiones</div>
        </div>
        <div class="content-dashboard-search-bar">
            <div class="columns">
                <div class="column is-6 ">
                    <div class="control has-icons-left">
                        <input type="text" class="input"
                               wire:keydown.enter="buscar"
                               wire:model.defer="search" placeholder="Buscar por codigo de matricula"/>
                        <span class="icon is-small is-left">
                                <i class="fas fa-search"></i>
                            </span>
                    </div>
                </div>
                <div class="column is-2">
                    <input type="text" autocomplete="off" id="fecha" class="input" placeholder="Fecha" wire:model.lazy="fecha"/>
                </div>
                <div class="column is-2">
                    <div class="select is-fullwidth">
                        <select wire:model.defer="estado">
                            <option value="" selected>Estado</option>
                            <option value="0">Por revisión</option>
                            <option value="1">Confirmados</option>
                            <option value="2">Anulados</option>
                        </select>
                    </div>
                </div>
                <div class="column has-text-centered">
                    <button wire:click="buscar" class="button is-success"><i class="fas fa-search"></i></button>
                    <button wire:click="limpiar" class="button is-danger"><i class="fas fa-eraser"></i></button>
                </div>
            </div>
        </div>
        <div class="content-dashboard-search-bar">
            <div class="columns">
                <div class="column has-text-centered"><i class="fas fa-circle has-text-warning"></i> <strong>{{ $pendientes }}</strong> POR REVISION</div>
                <div class="column has-text-centered"><i class="fas fa-circle has-text-success"></i> <strong>{{ $confirmados }}</strong> CONFIRMADOS</div>
                <div class="column has-text-centered"><i class="fas fa-circle has-text-danger"></i> <strong>{{ $anulados }}</strong> ANULADOS</div>
                <div class="column has-text-centered"><i class="fas fa-circle has-text-grey-light"></i> <strong>{{ $total }}</strong> TOTAL</div>
            </div>
        </div>
        <div class="columns">
            <div class="column has-text-right">
                <button wire:click="marcarTodas" @if($pendientes == 0) disabled @endif class="button is-success">Marcar pendientes como comprobados<i class="fas fa-check ml-2"></i></button>
            </div>
        </div>
        <div class="content-dashboard-content box-content">
            <table class="table">
                <thead>
                <tr>
                    <th class="has-text-centered">Estado</th>
                    <th>Matricula</th>
                    <th>Cocepto</th>
                    <th>Alumno</th>
                    <th>Nivel/Grado</th>
                    <th class="has-text-centered">Monto</th>
                    <th>Fecha de Pago</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($pagos as $pago)
                    <tr>
                        <td class="has-text-centered">{!! $pago->status !!}</td>
                        <td>{{ $pago->codigo_matricula }}</td>
                        <td>Pensión {{ $pago->mes | mes }}</td>
                        <td>{{ $pago->matricula->alumno->apellido_paterno }}, {{ $pago->matricula->alumno->nombres }}</td>
                        <td>{{ $pago->matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}/{{ $pago->matricula->grado | grado }}</td>
                        <td class="has-text-right">
                            <b>S./ </b>{{ $pago->costo }}
                        </td>
                        <td>{{ $pago->fecha_pago | dateFormat }}</td>
                        <td>
                            <div class="dashboard-menu-opcion" x-data="{ open: false }">
                                <button class="button is-small" @click="open = true"><i class="fas fa-bars"></i></button>
                                <div class="items" x-show="open">
                                    <div class="items-option"  @click.away="open = false">
                                        <a wire:click="verComprobante('{{ $pago->comprobante }}')">
                                            <i class="fas fa-money-bill"></i> Ver comprobante</a>
                                    </div>
                                    @if($pago->estado == 0)
                                        <div class="items-option"  @click.away="open = false">
                                            <a wire:click="showDialogConfirm({{ $pago->id }}, '{{$pago->codigo_matricula}}')">
                                                <i class="fas fa-check-double has-text-success"></i> Confirmar pago</a>
                                        </div>
                                        @if(auth()->user()->hasRole('Admin'))
                                            <div class="items-option"  @click.away="open = false">
                                                <a wire:click="showDialogEliminarPago({{ $pago->id }})">
                                                    <i class="fas fa-ban has-text-danger"></i> Eliminar Pago</a>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="has-text-centered">No hay resultados que mostrar</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $pagos->links() }}
        </div>
        <div class="modal is-active" x-show="show">
            <div class="modal-background"></div>
            <div class="modal-content">
                <p class="image">
                    <img src="{{ $imagenComprobante }}" alt="">
                </p>
            </div>
            <button @click="show = false" class="modal-close is-large" aria-label="close"></button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function pagosPensiones() {
            return {
                show: false,
                suscribe() {
                    setTimeout(function () {
                        Livewire.on('mostrar:comprobante:pension', () => {
                            this.show = true;
                        });
                    }.bind(this));
                }
            }
        }

        document.addEventListener('livewire:load', function () {
            new Pikaday({
                field: document.getElementById('fecha'),
                format: 'YYYY-MM-DD',
                i18n: {
                    previousMonth: 'Mes Anterior',
                    nextMonth: 'Siguiente Mes',
                    months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                    weekdays: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                    weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mi', 'Ju', 'Vi', 'Sa']
                },
                toString(date, format) {
                    // you should do formatting based on the passed format,
                    // but we will just return 'D/M/YYYY' for simplicity
                    var day = date.getDate();
                    day = day < 10 ? `0${day}` : day;

                    var month = date.getMonth() + 1;
                    month = month < 10 ? `0${month}` : month;

                    const year = date.getFullYear();
                    return `${year}-${month}-${day}`;
                },
            });
        });

    </script>
@endpush

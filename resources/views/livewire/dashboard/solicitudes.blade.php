<div class="content-dashboard"  x-data="solicitudes()" x-init="suscribe()">
    <div class="content-dashboard-header">
        <div><i class="fas fa-clipboard-check"></i> Solicitudes de Documentos</div>
    </div>
    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column">
                <div class="control has-icons-left">
                    <input type="text" class="input"
                           wire:keydown.enter="buscar"
                           wire:model.defer="search" placeholder="Buscar...."/>
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
                        <option value="1">Atendida</option>
                    </select>
                </div>
            </div>
            <div class="column is-2-desktop has-text-centered">
                <button wire:click="buscar" class="button is-success"><i class="fas fa-search"></i></button>
                <button wire:click="limpiar" class="button is-danger"><i class="fas fa-eraser"></i></button>
            </div>
        </div>
    </div>
    <div class="content-dashboard-search-bar">
        <div class="columns">
            <div class="column has-text-centered"><i class="fas fa-circle has-text-warning"></i> <strong>{{ $pendientes }}</strong> PENDIENTES</div>
            <div class="column has-text-centered"><i class="fas fa-circle has-text-success"></i> <strong>{{ $atendidas }}</strong> ATENDIDAS</div>
            <div class="column has-text-centered"><i class="fas fa-circle has-text-grey-light"></i> <strong>{{ $total }}</strong> TOTAL</div>
        </div>
    </div>
    <div class="content-dashboard-content box-content">
        <table class="table">
            <thead>
            <tr>
                <th class="has-text-centered">Estado</th>
                <th>Solicitante</th>
                <th>Alumno</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th class="has-text-centered">Documentos</th>
                <th>Fecha</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @forelse($solicitudes as $solicitud)
                <tr>
                    <td class="has-text-centered">{!! $solicitud->status !!}</td>
                    <td>{{ $solicitud->nombre_solicitante }}</td>
                    <td>{{ $solicitud->nombre_alumno != null ? $solicitud->nombre_alumno : 'SOLICITANTE' }}</td>
                    <td>{{ $solicitud->numero_celular }}</td>
                    <td>{{ $solicitud->correo_electronico }}</td>
                    <td class="has-text-centered"><a class="has-text-info-dark" @click="openModal('{{ $solicitud->documentos }}')">{{ $solicitud->documentos_count }} Documentos</a></td>
                    <td>{{ $solicitud->created_at | dateFormat }}</td>
                    <td wire:ignore>
                        <div class="dashboard-menu-opcion" x-data="{ open: false }">
                            <button class="button is-small" @click="open = true"><i class="fas fa-bars"></i></button>
                            <div class="items" x-show="open">
                                <div wire:click="descargarFicha({{ $solicitud->id }})"class="items-option"  @click.away="open = false">
                                    <a><i class="fas fa-file-pdf has-text-danger"></i> Descargar solicitud</a>
                                </div>
                                @if($solicitud->estado == 0)
                                    <div wire:click="showDialogConfirmSolicitud({{ $solicitud->id }})" class="items-option" @click.away="open = false">
                                        <a><i class="fas fa-check-double has-text-success"></i> Marcar como atendida</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="has-text-centered">No hay resultados que mostrar</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $solicitudes->links() }}
    </div>
    <div class="modal is-active" x-show="show" wire:ignore>
        <div class="modal-background"></div>
        <div class="modal-content">
            <p class="image">
                <img src="{{ $imagenComprobante }}" alt="">
            </p>
        </div>
        <button @click="show = false" class="modal-close is-large" aria-label="close"></button>
    </div>
    <div class="modal is-active" x-show="showDetails" wire:ignore>
        <div class="modal-background"  @click="showDetails = false" ></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title" style="margin: 0;">Documentos solicitados</p>
                <button class="delete" @click="showDetails = false" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <ul>
                    <template x-for="d in documentos">
                        <li class="is-size-5" x-text="d.nombre"></li>
                    </template>
                </ul>
            </section>
            <footer class="modal-card-foot">
                <button @click="showDetails = false" class="button is-danger">Cerrar</button>
            </footer>
        </div>
    </div>
    <div class="loading-matricula"  wire:loading wire:target="descargarFicha" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}"/>
            </div>
            <div class="mensaje">
                Procesando.....
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        function solicitudes() {
            return {
                show: false,
                showDetails: false,
                documentos: [],
                openModal (data = null)
                {
                    console.log(data);
                  this.documentos = data == null ? [] : JSON.parse(data);
                  this.showDetails = true;
                },
                suscribe() {
                    setTimeout(function () {
                        Livewire.on('mostrar:comprobante', () => {
                            this.show = true;
                        });
                    }.bind(this));
                }
            }
        }

    </script>
@endpush

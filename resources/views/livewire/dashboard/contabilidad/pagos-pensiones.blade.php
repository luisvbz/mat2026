<div x-data="pagosPensiones()" x-init="suscribe()" class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    <livewire:commons.mod-contable />

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="verComprobante"
        class="fixed inset-0 z-50 bg-white/70 backdrop-blur-sm flex-col items-center justify-center hidden">
        <div class="animate-spin text-colegio-500 mb-4">
            <i class="ph ph-circle-notch text-5xl"></i>
        </div>
        <div class="text-lg font-semibold text-gray-700 animate-pulse">
            Cargando comprobante...
        </div>
    </div>

    {{-- Header & Global Actions --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b border-gray-100 pb-4">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-receipt text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pagos Recibidos por Pensiones</h1>
                <p class="text-sm text-gray-500">Gestión y confirmación de transferencias de mensualidades</p>
            </div>
        </div>
        <div class="flex justify-end relative z-10">
            <button wire:click="marcarTodas"
                @if ($pendientes == 0) disabled class="opacity-50 cursor-not-allowed bg-green-600 text-white px-4 py-2 rounded-lg font-medium flex items-center gap-2" @else class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shadow-sm" @endif>
                <i class="ph-fill ph-checks"></i> Marcar pendientes como comprobados
            </button>
        </div>
    </div>

    {{-- Stats Cards Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div
                class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-clock-counter-clockwise text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">POR REVISIÓN</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $pendientes }}</h3>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div
                class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-check-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">CONFIRMADOS</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $confirmados }}</h3>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-x-circle text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">ANULADOS</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $anulados }}</h3>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-gray-50 text-gray-500 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-sigma text-2xl"></i>
            </div>
            <div>
                <p class="text-xs font-medium text-gray-500">TOTAL</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $total }}</h3>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-12 lg:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="ph ph-magnifying-glass"></i>
                    </div>
                    <input type="text" wire:keydown.enter="buscar" wire:model.defer="search"
                        placeholder="Buscar por código de matrícula"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm shadow-sm">
                </div>
            </div>
            <div class="md:col-span-6 lg:col-span-2">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="ph ph-calendar"></i>
                    </div>
                    <input type="text" autocomplete="off" id="fecha" wire:model.lazy="fecha" placeholder="Fecha"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm shadow-sm">
                </div>
            </div>
            <div class="md:col-span-6 lg:col-span-3">
                <select wire:model.defer="estado"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm shadow-sm">
                    <option value="" selected>Todos los estados</option>
                    <option value="0">Por revisión</option>
                    <option value="1">Confirmados</option>
                    <option value="2">Anulados</option>
                </select>
            </div>
            <div class="md:col-span-12 lg:col-span-2 flex space-x-2">
                <button wire:click="buscar"
                    class="flex-1 bg-colegio-600 hover:bg-colegio-700 text-white rounded-lg flex items-center justify-center hover:bg-colegio-700 transition-colors shadow-sm"
                    title="Buscar">
                    <i class="ph ph-magnifying-glass font-bold"></i>
                </button>
                <button wire:click="limpiar"
                    class="flex-1 bg-red-500 hover:bg-red-600 text-white rounded-lg flex items-center justify-center transition-colors shadow-sm"
                    title="Limpiar filtros">
                    <i class="ph ph-eraser font-bold"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-visible relative z-20">
        {{-- Table Loading Skeleton --}}
        <div wire:loading wire:target="buscar, limpiar, estado, fecha, gotoPage, previousPage, nextPage"
            class="absolute inset-0 bg-white/50 backdrop-blur-[2px] z-50 transition-all rounded-xl">
            <div class="p-6 space-y-4">
                @for ($i = 0; $i < 6; $i++)
                    <div class="flex items-center gap-4">
                        <x-skeleton width="w-24" height="h-10" />
                        <x-skeleton width="w-full" height="h-10" />
                        <x-skeleton width="w-32" height="h-10" />
                        <x-skeleton width="w-16" height="h-10" />
                    </div>
                @endfor
            </div>
        </div>

        <div class="overflow-x-auto pb-32">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-center w-24">Estado</th>
                        <th class="px-4 py-3 font-semibold">Matrícula</th>
                        <th class="px-4 py-3 font-semibold">Concepto</th>
                        <th class="px-4 py-3 font-semibold">Alumno</th>
                        <th class="px-4 py-3 font-semibold">Nivel/Grado</th>
                        <th class="px-4 py-3 font-semibold text-right">Monto</th>
                        <th class="px-4 py-3 font-semibold">Fecha de Pago</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pagos as $pago)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3 text-center">
                                {!! str_replace(
                                    ['has-text-warning', 'has-text-success', 'has-text-danger', 'fas fa-circle'],
                                    ['text-yellow-500', 'text-green-500', 'text-red-500', 'ph-fill ph-circle text-lg'],
                                    explode('>', $pago->status)[0] . '>',
                                ) !!}
                            </td>
                            <td class="px-4 py-3 font-medium text-gray-800">{{ $pago->codigo_matricula }}</td>
                            <td class="px-4 py-3">Pensión <span class="capitalize">{{ $pago->mes | mes }}</span></td>
                            <td class="px-4 py-3 font-medium">{{ $pago->matricula->alumno->apellido_paterno }},
                                {{ $pago->matricula->alumno->nombres }}</td>
                            <td class="px-4 py-3">
                                <span
                                    class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-semibold mr-1">{{ $pago->matricula->nivel == 'P' ? 'PRI' : 'SEC' }}</span>
                                {{ $pago->matricula->grado | grado }}
                            </td>
                            <td class="px-4 py-3 text-right font-bold text-gray-800">
                                <span
                                    class="text-gray-400 font-normal mr-1">S/</span>{{ number_format($pago->costo, 2) }}
                            </td>
                            <td class="px-4 py-3">{{ $pago->fecha_pago | dateFormat }}</td>
                            <td class="px-4 py-3 text-center">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false"
                                        class="p-1.5 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                                        <i class="ph-bold ph-dots-three-vertical text-lg"></i>
                                    </button>

                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 z-50 py-1 origin-top-right">

                                        <button wire:click="verComprobante('{{ $pago->comprobante }}')"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-colegio-600 flex items-center gap-2">
                                            <i class="ph ph-receipt text-colegio-500"></i> Ver comprobante
                                        </button>

                                        @if ($pago->estado == 0)
                                            <button
                                                wire:click="showDialogConfirm({{ $pago->id }}, '{{ $pago->codigo_matricula }}')"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600 flex items-center gap-2">
                                                <i class="ph ph-check-circle text-green-500"></i> Confirmar pago
                                            </button>

                                            @if (auth()->user()->hasRole('Admin'))
                                                <div class="border-t border-gray-100 my-1"></div>
                                                <button wire:click="showDialogEliminarPago({{ $pago->id }})"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                    <i class="ph ph-trash"></i> Eliminar Pago
                                                </button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-5 py-8 text-center text-gray-500">
                                <i class="ph ph-file-dashed text-4xl mb-2 text-gray-300 block"></i>
                                No hay resultados que mostrar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-100">
            {{ $pagos->links() }}
        </div>
    </div>

    {{-- Image Modal --}}
    <div x-show="show" style="display: none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6"
        x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        <div class="fixed inset-0 bg-gray-900/75 backdrop-blur-sm transition-opacity" @click="show = false"></div>

        <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden max-w-3xl w-full transform transition-all"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">

            <div class="absolute top-0 right-0 pt-4 pr-4">
                <button @click="show = false"
                    class="bg-gray-100 rounded-full p-2 text-gray-500 hover:bg-gray-200 hover:text-gray-900 transition-colors focus:outline-none">
                    <span class="sr-only">Cerrar modal</span>
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>

            <div class="p-6 pt-12">
                <img src="{{ $imagenComprobante }}" alt="Comprobante de Pago"
                    class="w-full h-auto max-h-[70vh] object-contain rounded-lg">
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-100 flex justify-end">
                <button @click="show = false"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-colors">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function pagosPensiones() {
            return {
                show: false,
                suscribe() {
                    setTimeout(function() {
                        Livewire.on('mostrar:comprobante:pension', () => {
                            this.show = true;
                        });
                    }.bind(this), 100);
                }
            }
        }

        document.addEventListener('livewire:load', function() {
            if (typeof Pikaday !== 'undefined') {
                new Pikaday({
                    field: document.getElementById('fecha'),
                    format: 'YYYY-MM-DD',
                    i18n: {
                        previousMonth: 'Mes Anterior',
                        nextMonth: 'Siguiente Mes',
                        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                            'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ],
                        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes',
                            'Sabado'
                        ],
                        weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mi', 'Ju', 'Vi', 'Sa']
                    },
                    toString(date, format) {
                        var day = date.getDate();
                        day = day < 10 ? `0${day}` : day;

                        var month = date.getMonth() + 1;
                        month = month < 10 ? `0${month}` : month;

                        const year = date.getFullYear();
                        return `${year}-${month}-${day}`;
                    },
                });
            }
        });
    </script>
@endpush

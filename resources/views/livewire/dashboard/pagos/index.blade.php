<div x-data="pagosMatriculas()" x-init="suscribe()" class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    <livewire:commons.mod-contable />

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="verComprobante, exportar"
        class="fixed inset-0 z-50 bg-white/70 backdrop-blur-sm flex-col items-center justify-center hidden">
        <div class="animate-spin text-colegio-500 mb-4">
            <i class="ph ph-circle-notch text-5xl"></i>
        </div>
        <div class="text-lg font-semibold text-gray-700 animate-pulse">
            Cargando...
        </div>
    </div>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 border-b border-gray-300 pb-4">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-300 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-money text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Pagos Recibidos por Matrícula</h1>
                <p class="text-sm text-gray-800">Gestión y confirmación de transferencias de matrículas</p>
            </div>
        </div>
        <div class="flex justify-end gap-2 relative z-10">
            <button wire:click="exportar"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors flex items-center gap-2 shadow-sm"
                title="Exportar a PDF">
                <i class="ph-fill ph-file-pdf"></i> Exportar
            </button>
        </div>
    </div>

    {{-- Stats Cards Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div
                class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-clock-counter-clockwise text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-wider mb-0.5">POR REVISIÓN</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $pendientes }}</h3>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div
                class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-wider mb-0.5">CONFIRMADOS</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $confirmados }}</h3>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-x-circle text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-wider mb-0.5">ANULADOS</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $anulados }}</h3>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-4 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-12 h-12 rounded-full bg-gray-50 text-gray-800 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-sigma text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-wider mb-0.5">TOTAL</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $total }}</h3>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-4 flex flex-col md:flex-row gap-4">
        <div class="flex-1 relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-800">
                <i class="ph ph-magnifying-glass"></i>
            </div>
            <input type="text" wire:keydown.enter="buscar" wire:model.defer="search"
                placeholder="Buscar por código de matrícula"
                class="pl-10 w-full rounded-lg border-gray-300 shadow-sm focus:border-colegio-500 focus:ring-colegio-500">
        </div>

        <div class="w-full md:w-48">
            <select wire:model.defer="estado"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-colegio-500 focus:ring-colegio-500">
                <option value="" selected>Todos los estados</option>
                <option value="0">Por revisión</option>
                <option value="1">Confirmados</option>
                <option value="2">Anulados</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button wire:click="buscar"
                class="px-4 py-2 bg-colegio-600 hover:bg-colegio-700 text-white rounded-lg shadow-sm font-medium transition-colors"
                title="Buscar">
                <i class="ph ph-magnifying-glass"></i>
            </button>
            <button wire:click="limpiar"
                class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 rounded-lg shadow-sm font-medium transition-colors border border-red-100"
                title="Limpiar filtros">
                <i class="ph ph-eraser"></i>
            </button>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-visible relative z-20">
        <div class="overflow-x-auto pb-32">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-800 uppercase bg-gray-50 border-b border-gray-300">
                    <tr>
                        <th class="px-2 py-2 font-semibold text-center w-24">Estado</th>
                        <th class="px-2 py-2 font-semibold">Concepto</th>
                        <th class="px-2 py-2 font-semibold">Matrícula</th>
                        <th class="px-2 py-2 font-semibold">Alumno</th>
                        <th class="px-2 py-2 font-semibold">Nivel/Grado</th>
                        <th class="px-2 py-2 font-semibold">Método</th>
                        <th class="px-2 py-2 font-semibold">Operación</th>
                        <th class="px-2 py-2 font-semibold text-right">Monto</th>
                        <th class="px-2 py-2 font-semibold">Fecha de Pago</th>
                        <th class="px-2 py-2 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($pagos as $pago)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-2 py-2 text-center">
                                {!! str_replace(
                                    ['has-text-warning', 'has-text-success', 'has-text-danger', 'fas fa-circle'],
                                    ['text-yellow-500', 'text-green-500', 'text-red-500', 'ph-fill ph-circle text-lg'],
                                    explode('>', $pago->status)[0] . '>',
                                ) !!}
                            </td>
                            <td class="px-2 py-2 font-medium text-gray-800">
                                {{ $pago->concepto == 'M' ? 'Matrícula' : 'Pensión' }}</td>
                            <td class="px-2 py-2">{{ $pago->codigo_matricula }}</td>
                            <td class="px-2 py-2 font-medium">{{ $pago->matricula->alumno->apellido_paterno }},
                                {{ $pago->matricula->alumno->nombres }}</td>
                            <td class="px-2 py-2">
                                <span
                                    class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-semibold mr-1">{{ $pago->matricula->nivel == 'P' ? 'PRI' : 'SEC' }}</span>
                                {{ $pago->matricula->grado | grado }}
                            </td>
                            <td class="px-2 py-2 font-bold text-gray-600">{{ $pago->tipo_pago | mp }}</td>
                            <td class="px-2 py-2 font-mono text-xs">{{ $pago->numero_operacion }}</td>
                            <td class="px-2 py-2 text-right font-bold text-gray-800">
                                <span
                                    class="text-gray-800 font-normal mr-1">S/</span>{{ number_format($pago->monto_pagado, 2) }}
                            </td>
                            <td class="px-2 py-2">{{ $pago->fecha_deposito | dateFormat }}</td>
                            <td class="px-2 py-2 text-center">
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false"
                                        class="p-1.5 rounded-md text-gray-800 hover:bg-gray-100 hover:text-gray-800 transition-colors">
                                        <i class="ph-bold ph-dots-three-vertical text-lg"></i>
                                    </button>

                                    <div x-show="open" x-transition:enter="transition ease-out duration-100"
                                        x-transition:enter-start="transform opacity-0 scale-95"
                                        x-transition:enter-end="transform opacity-100 scale-100"
                                        x-transition:leave="transition ease-in duration-75"
                                        x-transition:leave-start="transform opacity-100 scale-100"
                                        x-transition:leave-end="transform opacity-0 scale-95"
                                        class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-300 z-50 py-1 origin-top-right">

                                        <button wire:click="verComprobante('{{ $pago->comprobante }}')"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-colegio-600 flex items-center gap-2">
                                            <i class="ph ph-receipt text-colegio-500"></i> Ver comprobante
                                        </button>

                                        @if ($pago->estado == 0)
                                            <button
                                                wire:click="showDialogConfirmMatricula({{ $pago->id }}, '{{ $pago->codigo_matricula }}')"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-green-600 flex items-center gap-2">
                                                <i class="ph ph-check-circle text-green-500"></i> Confirmar matrícula
                                            </button>

                                            <div class="border-t border-gray-300 my-1"></div>
                                            <button
                                                wire:click="showDialogAnularPago({{ $pago->id }},  '{{ $pago->codigo_matricula }}')"
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center gap-2">
                                                <i class="ph ph-x-circle"></i> Anular Pago
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-2 py-2 text-center text-gray-800">
                                <i class="ph ph-file-dashed text-4xl mb-2 text-gray-300 block"></i>
                                No hay resultados que mostrar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-gray-300">
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

        <div class="relative bg-white rounded-xl shadow-2xl overflow-hidden max-w-3xl w-full transform transition-all">

            <div class="absolute top-0 right-0 pt-4 pr-4 z-10">
                <button @click="show = false"
                    class="bg-gray-100 rounded-full p-2 text-gray-800 hover:bg-gray-200 hover:text-gray-900 transition-colors focus:outline-none">
                    <span class="sr-only">Cerrar modal</span>
                    <i class="ph ph-x text-xl"></i>
                </button>
            </div>

            <div class="p-6 pt-12">
                <img src="{{ $imagenComprobante }}" alt="Comprobante de Pago"
                    class="w-full h-auto max-h-[70vh] object-contain rounded-lg">
            </div>
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-300 flex justify-end">
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
        function pagosMatriculas() {
            return {
                show: false,
                suscribe() {
                    setTimeout(function() {
                        Livewire.on('mostrar:comprobante:matricula', () => {
                            this.show = true;
                        });
                    }.bind(this), 100);
                }
            }
        }
    </script>
@endpush

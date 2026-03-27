<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    {{-- Unified Loading Overlay --}}
    <div wire:loading.flex
        wire:target="exportarPdf,exportarPdfNumeros,exportarCorreos,exportarDNI,exportarPdfVacuna,generarQrs,descargarFicha"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center hidden">
        <div class="bg-white p-6 rounded-2xl shadow-xl flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-colegio-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-gray-700 font-medium">Procesando.....</span>
        </div>
    </div>

    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <i class="ph ph-student text-colegio-600 mr-3 text-3xl"></i> Matrículas
            </h1>
        </div>
        <div>
            <a href="{{ route('dashboard.matriculas-old') }}"
                class="inline-flex flex-row items-center text-sm font-semibold text-colegio-600 hover:text-colegio-700 bg-colegio-50 px-4 py-2 rounded-lg border border-colegio-100 transition-colors">
                <i class="ph ph-arrow-circle-right mr-2 text-lg"></i> Migrar alumno 2025
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-2 flex items-center">
            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center mr-4">
                <i class="ph ph-circle text-yellow-500 text-xl font-bold"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800 uppercase"><span class="font-bold">{{ $pendientes }}</span>
                    Pendientes </p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-2 flex items-center">
            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-4">
                <i class="ph ph-check-circle text-green-500 text-xl font-bold"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800 uppercase"><span class="font-bold">{{ $confirmadas }}</span>
                    Confirmadas</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-2 flex items-center">
            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center mr-4">
                <i class="ph ph-prohibit text-red-500 text-xl font-bold"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800 uppercase"><span class="font-bold">{{ $anuladas }}</span>
                    Anuladas</p>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-2 flex items-center">
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center mr-4">
                <i class="ph ph-users text-gray-800 text-xl font-bold"></i>
            </div>
            <div>
                <p class="font-semibold text-gray-800 uppercase"><span class="font-bold">{{ $total }}</span>
                    Total</p>
            </div>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-800"></i>
                    </div>
                    <input type="text" wire:keydown.enter="buscar" wire:model.defer="search"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm"
                        placeholder="Buscar por nombre o DNI del estudiante">
                </div>
            </div>

            <div class="md:col-span-2">
                <select wire:model.defer="estado"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="" selected>Estado</option>
                    <option value="0">Pendiente</option>
                    <option value="1">Confirmada</option>
                    <option value="2">Anulada</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <select wire:model.defer="nivel"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="" selected>Nivel</option>
                    <option value="P">Primaria</option>
                    <option value="S">Secundaria</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <select wire:model.defer="grado"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="" selected>Grado</option>
                    <option value="1">Primero</option>
                    <option value="2">Segundo</option>
                    <option value="3">Tercero</option>
                    <option value="4">Cuarto</option>
                    <option value="5">Quinto</option>
                    <option value="6">Sexto</option>
                </select>
            </div>

            <div class="md:col-span-1 flex space-x-2">
                <button wire:click="buscar"
                    class="flex-1 bg-green-500 text-white rounded-lg flex items-center justify-center hover:bg-green-600 transition-colors shadow-sm">
                    <i class="ph ph-magnifying-glass font-bold"></i>
                </button>
                <button wire:click="limpiar"
                    class="flex-1 bg-red-500 text-white rounded-lg flex items-center justify-center hover:bg-red-600 transition-colors shadow-sm">
                    <i class="ph ph-eraser font-bold"></i>
                </button>
            </div>
        </div>
    </div>



    {{-- Actions Bar --}}
    <div class="flex flex-wrap items-center justify-end gap-2 mb-6">
        <button wire:click="exportarPdfVacuna"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Reporte (Vacunas) <i class="ph ph-file-pdf ml-2 text-red-500 text-lg"></i>
        </button>
        <button wire:click="exportarPdfNumeros"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Reporte (Números) <i class="ph ph-file-pdf ml-2 text-red-500 text-lg"></i>
        </button>
        <button wire:click="exportarPdf"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Rep. Matrículas <i class="ph ph-file-pdf ml-2 text-red-500 text-lg"></i>
        </button>
        <button wire:click="exportarCorreos"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Correos <i class="ph ph-envelope-simple ml-2 text-blue-500 text-lg"></i>
        </button>
        <button wire:click="exportarDNI"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            Rep. DNI <i class="ph ph-identification-card ml-2 text-indigo-500 text-lg"></i>
        </button>
        {{--      <button wire:click="generarQrs"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-colegio-600 hover:bg-colegio-700">
            Generar QR's <i class="ph ph-qr-code ml-2 text-lg"></i>
        </button> --}}
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-visible relative z-20">
        <div class="overflow-x-auto pb-32">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-2 py-2 text-center w-8 text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            SEL.</th>
                        <th scope="col"
                            class="px-2 py-2 text-center w-8 text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            #</th>
                        <th scope="col"
                            class="px-2 py-2 text-center text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Estado</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            COD
                        </th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            N.
                            MAT.</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Doc.
                        </th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Alumno</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Nivel</th>
                        <th scope="col"
                            class="px-2 py-2 text-center text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Grado</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Fecha</th>
                        <th scope="col"
                            class="px-2 py-2 text-center text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php $i = 1; @endphp
                    @forelse($matriculas as $matricula)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 py-2 whitespace-nowrap text-center">
                                <input value="{{ $matricula->id }}" type="checkbox" wire:model="matriculas_selected"
                                    class="h-4 w-4 text-colegio-600 focus:ring-colegio-500 border-gray-300 rounded">
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-xs text-gray-800">
                                {{ $i }}</td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-lg">
                                {!! $matricula->status !!}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs font-medium text-gray-900">
                                {{ $matricula->codigo }}</td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-800">
                                {{ $matricula->numero_matricula }}</td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-800">
                                {{ $matricula->alumno->numero_documento }}</td>
                            <td class="px-2 py-2 text-xs text-gray-900 font-medium leading-tight min-w-[150px]">
                                {{ trim($matricula->alumno->apellido_paterno . ' ' . $matricula->alumno->apellido_materno . ' ' . $matricula->alumno->nombres) }}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-800">
                                {{ $matricula->nivel == 'P' ? 'Primaria' : 'Secundaria' }}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-xs text-gray-900 font-medium">
                                {{ $matricula->grado | grado }}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-800">
                                {{ $matricula->created_at | dateFormat }}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-xs font-medium">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false"
                                        class="text-gray-800 hover:text-gray-600 focus:outline-none p-2 rounded-full hover:bg-gray-100 transition-colors">
                                        <i class="ph ph-list text-xl"></i>
                                    </button>

                                    <div x-show="open" x-transition.opacity
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                                        <div class="py-1" role="menu">
                                            <a href="{{ route('dashboard.detalle-matricula', [$matricula->codigo]) }}"
                                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex items-center">
                                                <i class="ph ph-magnifying-glass-plus text-blue-500 text-lg mr-2"></i>
                                                Ver más detalles
                                            </a>
                                            <button wire:click="descargarFicha({{ $matricula->id }})"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex items-center">
                                                <i class="ph ph-file-pdf text-green-500 text-lg mr-2"></i> Descargar
                                                ficha
                                            </button>

                                            @if ($matricula->estado == 0)
                                                <div class="border-t border-gray-300 my-1"></div>
                                                <button wire:click="showDialogConfirmMatricula({{ $matricula->id }})"
                                                    class="w-full text-left px-4 py-2 text-sm text-green-600 hover:bg-green-50 flex items-center">
                                                    <i class="ph ph-check-circle text-green-500 text-lg mr-2"></i>
                                                    Confirmar
                                                </button>
                                            @elseif($matricula->estado == 1)
                                                <div class="border-t border-gray-300 my-1"></div>
                                                <button wire:click="showDialogAnularMatricula({{ $matricula->id }})"
                                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                    <i class="ph ph-prohibit text-red-500 text-lg mr-2"></i> Anular
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @empty
                        <tr>
                            <td colspan="11" class="px-2 py-12 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <i class="ph ph-magnifying-glass text-2xl text-gray-800"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">No hay matrículas</h3>
                                <p class="mt-1 text-sm text-gray-800">Aún no se ha registrado ninguna matrícula o
                                    ninguna coincide con los filtros aplicados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-300">
            {{ $matriculas->links() }}
        </div>
    </div>
</div>

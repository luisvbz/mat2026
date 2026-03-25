<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    <livewire:commons.mod-asistencia />

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="generarReporte"
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
            <span class="text-gray-700 font-medium">Generando reporte mensual...</span>
        </div>
    </div>

    {{-- Header Content --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="w-12 h-12 rounded-xl bg-teal-100 text-teal-600 flex items-center justify-center mr-4">
                    <i class="ph-fill ph-users-three text-2xl"></i>
                </span>
                Asistencia de Personal
            </h1>
            <p class="text-gray-500 text-sm mt-1 ml-16">Control de marcaciones de entrada y salida de los colaboradores.</p>
        </div>
    </div>

    {{-- Filters and Actions --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-3 space-y-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="ph ph-calendar"></i>
                    </div>
                    <input type="date" wire:model="date" max="{{ date('Y-m-d') }}"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                </div>
            </div>
            
            <div class="md:col-span-3 space-y-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Mes (Reporte)</label>
                <select wire:model.defer="mes"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    @foreach($meses as $mesItem)
                        <option value="{{ $mesItem['numero'] }}">{{ $mesItem['nombre'] }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="md:col-span-3">
                <button wire:click="generarReporte"
                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-colegio-600 hover:bg-colegio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-colors">
                    <i class="ph-fill ph-file-pdf mr-2 text-lg"></i>
                    Generar Reporte Mensual
                </button>
            </div>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-visible relative z-20">
        <div class="overflow-x-auto pb-6">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Colaborador</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Entrada</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Comentario E.</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Salida</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Comentario S.</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($profesores as $p)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <span class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-sm">
                                            {{ substr($p->apellidos, 0, 1) }}{{ substr($p->nombres, 0, 1) }}
                                        </span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $p->apellidos }}, {{ $p->nombres }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            @if($p->asistencia)
                                @if($p->asistencia->tipo == 'N')
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{ $p->asistencia->entrada | date:'h:i:s A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            A TIEMPO <i class="ph-bold ph-check-circle ml-1"></i>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{ $p->asistencia->salida ? date('h:i:s A', strtotime($p->asistencia->salida)) : '--:--:--' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        @if($p->asistencia->salida_anticipada || $p->asistencia->comentario_salida)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 max-w-xs truncate" title="{{ $p->asistencia->comentario_salida }}">
                                                {{ $p->asistencia->comentario_salida }} 
                                                @if($p->asistencia->salida_anticipada) <b>({{ $p->asistencia->salida_anticipada }})</b> @endif
                                            </span>
                                        @elseif($p->asistencia->salida)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                A TIEMPO <i class="ph-bold ph-check-circle ml-1"></i>
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    
                                @elseif($p->asistencia->tipo == 'T')
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{ $p->asistencia->entrada | date:'h:i:s A' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 max-w-xs truncate" title="{{ $p->asistencia->tardanza_entrada }}">
                                            <b>{{ $p->asistencia->tardanza_entrada }}</b>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        {{ $p->asistencia->salida ? date('h:i:s A', strtotime($p->asistencia->salida)) : '--:--:--' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">
                                        @if($p->asistencia->salida_anticipada || $p->asistencia->comentario_salida)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 max-w-xs truncate" title="{{ $p->asistencia->comentario_salida }}">
                                                {{ $p->asistencia->comentario_salida }} 
                                                @if($p->asistencia->salida_anticipada) <b>({{ $p->asistencia->salida_anticipada }})</b> @endif
                                            </span>
                                        @elseif($p->asistencia->salida)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                A TIEMPO <i class="ph-bold ph-check-circle ml-1"></i>
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    
                                @elseif($p->asistencia->tipo == 'NL')
                                    <td colspan="4" class="px-6 py-4 text-center bg-gray-50">
                                        <span class="text-gray-500 font-medium italic">No laborable según horario</span>
                                    </td>
                                @elseif($p->asistencia->tipo == 'FI')
                                    <td colspan="4" class="px-6 py-4 text-center bg-red-50">
                                        <span class="text-red-600 font-bold">Falta Injustificada</span>
                                    </td>
                                @elseif($p->asistencia->tipo == 'FJ')
                                    <td colspan="4" class="px-6 py-4 text-center bg-blue-50">
                                        <span class="text-blue-600 font-bold">Falta Justificada</span>
                                    </td>
                                @elseif($p->asistencia->tipo == 'F')
                                    <td colspan="4" class="px-6 py-4 text-center bg-gray-50">
                                        <span class="text-gray-500 font-medium">Día Feriado</span>
                                    </td>
                                @endif
                                
                            @else
                                @if($p->tipo == 'NL')
                                    <td colspan="4" class="px-6 py-4 text-center bg-gray-50">
                                        <span class="text-gray-500 font-medium italic">No laborable según horario</span>
                                    </td>
                                @elseif($p->tipo == 'FI')
                                    <td colspan="4" class="px-6 py-4 text-center bg-red-50">
                                        <span class="text-red-600 font-bold">Falta Injustificada</span>
                                    </td>
                                @endif
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500">
                                No se encontraron profesores registrados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

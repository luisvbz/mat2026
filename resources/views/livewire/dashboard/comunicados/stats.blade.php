<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                <i class="ph ph-chart-bar text-colegio-600 mr-2"></i> Estadísticas: <span
                    class="text-gray-800 font-normal">{{ $communication->title }}</span>
            </h1>
        </div>
        <div>
            <a href="{{ route('dashboard.comunicados') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                <i class="ph ph-arrow-left mr-2"></i> Volver a Comunicados
            </a>
        </div>
    </div>

    {{-- Info Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-300 flex items-center p-6">
            <div class="p-3 bg-blue-100 rounded-lg">
                <i class="ph ph-users text-blue-600 text-2xl"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-800 uppercase tracking-wider">Total de Lecturas</p>
                <p class="text-3xl font-bold text-gray-900">{{ $communication->reads()->count() }}</p>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-300 flex items-center p-6">
            <div class="p-3 bg-green-100 rounded-lg">
                <i class="ph ph-percent text-green-600 text-2xl"></i>
            </div>
            <div class="ml-5">
                <p class="text-sm font-medium text-gray-800 uppercase tracking-wider">Porcentaje Leído</p>
                <div class="flex items-center">
                    <p class="text-3xl font-bold text-gray-900 mr-3">{{ $communication->read_percentage ?? 0 }}%</p>
                    <div class="w-24 bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-500 h-2.5 rounded-full"
                            style="width: {{ $communication->read_percentage ?? 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-5 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Alumno</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-student text-gray-800"></i>
                    </div>
                    <input wire:model.debounce.500ms="searchStudent" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm"
                        placeholder="Nombre o apellidos...">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Buscar Padre/Madre</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-user text-gray-800"></i>
                    </div>
                    <input wire:model.debounce.500ms="searchParent" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm"
                        placeholder="Nombre o DNI...">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nivel</label>
                <select wire:model="filterNivel"
                    class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="">Todos</option>
                    <option value="I">Inicial</option>
                    <option value="P">Primaria</option>
                    <option value="S">Secundaria</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Grado</label>
                <select wire:model="filterGrado"
                    class="block w-full py-2 px-3 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="">Todos</option>
                    <option value="1">1ro</option>
                    <option value="2">2do</option>
                    <option value="3">3ro</option>
                    <option value="4">4to</option>
                    <option value="5">5to</option>
                    <option value="6">6to</option>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="resetFilters"
                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-colors">
                    <i class="ph ph-eraser mr-2"></i> Limpiar Filtros
                </button>
            </div>
        </div>
    </div>

    {{-- Detail Table --}}
    <div class="bg-white shadow-sm rounded-xl border border-gray-300 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Padre/Madre</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Documento</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Alumno</th>
                        <th scope="col"
                            class="px-2 py-2 text-center text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Nivel / Grado</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Fecha
                            de Lectura</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reads as $read)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 py-2 whitespace-nowrap text-xs font-medium text-gray-900">
                                @if ($read->parent_nombres)
                                    <div class="flex items-center">
                                        <div
                                            class="flex-shrink-0 h-8 w-8 rounded-full bg-colegio-100 flex items-center justify-center text-colegio-700 font-bold text-xs uppercase">
                                            {{ substr($read->parent_nombres, 0, 1) }}{{ substr($read->parent_apellidos, 0, 1) }}
                                        </div>
                                        <div class="ml-3">
                                            {{ ucwords(strtolower($read->parent_nombres)) }}
                                            {{ ucwords(strtolower($read->parent_apellidos)) }}
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-800">N/A</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-800">
                                {{ $read->document }}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">
                                @if ($read->student_nombres)
                                    <span class="font-medium">{{ mb_strtoupper($read->student_paterno, 'UTF-8') }}
                                        {{ mb_strtoupper($read->student_materno, 'UTF-8') }}</span>,
                                    <span
                                        class="text-gray-600">{{ mb_convert_case($read->student_nombres, MB_CASE_TITLE, 'UTF-8') }}</span>
                                @else
                                    <span class="text-gray-800">N/A</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-center">
                                @php
                                    $nivelesStr = [
                                        'I' => 'Inicial',
                                        'P' => 'Primaria',
                                        'S' => 'Secundaria',
                                    ];
                                    $nivelStr = $nivelesStr[$read->nivel] ?? '-';
                                    $gradoStr = $read->grado ? $read->grado . '°' : '-';
                                @endphp

                                @if ($nivelStr != '-')
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $nivelStr }} - {{ $gradoStr }}
                                    </span>
                                @else
                                    <span class="text-gray-800">-</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-800">
                                {{ \Carbon\Carbon::parse($read->read_at)->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-2 py-12 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <i class="ph ph-magnifying-glass text-2xl text-gray-800"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Sin resultados</h3>
                                <p class="mt-1 text-sm text-gray-800">No se encontraron lecturas que coincidan con los
                                    filtros aplicados.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-300">
            {{ $reads->links() }}
        </div>
    </div>
</div>

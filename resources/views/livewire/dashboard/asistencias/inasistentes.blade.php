<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">

    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="marcarAsistenciaTodos,marcarAsistencia"
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
            <span class="text-gray-700 font-medium">Marcando asistencia...</span>
        </div>
    </div>

    {{-- Header Content --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center mr-4">
                    <i class="ph-fill ph-warning-circle text-2xl"></i>
                </span>
                Estudiantes sin marcación
            </h1>
            <p class="text-gray-500 text-sm mt-1 ml-16">Lista de alumnos que aún no han registrado asistencia en la
                fecha de hoy.</p>
        </div>
    </div>

    {{-- Search Filters and Actions Bar --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-3 space-y-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Nivel</label>
                <select wire:model="nivel"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="">Seleccione..</option>
                    <option value="P">Primaria</option>
                    <option value="S">Secundaria</option>
                </select>
            </div>
            <div class="md:col-span-3 space-y-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Grado</label>
                <select wire:model="grado" @if (!$grados || count($grados) == 0) disabled @endif
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm disabled:bg-gray-100 disabled:text-gray-400">
                    <option value="">Seleccione..</option>
                    @foreach ($grados as $g)
                        <option value="{{ $g->numero }}">{{ $g->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-3 space-y-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha (Hoy)</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="ph ph-calendar"></i>
                    </div>
                    <input type="date" wire:model='date' max="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" readonly
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 bg-gray-50 text-gray-500 rounded-lg sm:text-sm cursor-not-allowed">
                </div>
            </div>

            @if (count($inasistentes) > 0)
                <div class="md:col-span-3">
                    <button wire:click="showDialogMarcaTodos()"
                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-lg font-medium text-white hover:bg-green-700 focus:outline-none transition-colors shadow-sm">
                        Marcar a todos <i class="ph-bold ph-hammer ml-2 text-lg"></i>
                    </button>
                </div>
            @endif
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            DNI/CE/PTP</th>
                        <th scope="col"
                            class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Alumno</th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nivel</th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Grado</th>
                        <th scope="col"
                            class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Acciones (Marcar)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($inasistentes as $matricula)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                {{ $matricula->alumno->numero_documento }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ trim($matricula->alumno->apellido_paterno . ' ' . $matricula->alumno->apellido_materno . ' ' . $matricula->alumno->nombres) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-600">
                                {{ $matricula->nivel == 'P' ? 'Primaria' : 'Secundaria' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-semibold text-gray-900">
                                {{ $matricula->grado | grado }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center space-x-2">
                                    <button wire:click="showDialogMarcarAsistencia({{ $matricula->id }}, true)"
                                        title="Hora Actual"
                                        class="inline-flex items-center justify-center p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors focus:outline-none">
                                        <i class="ph-bold ph-calendar-plus text-lg"></i>
                                    </button>
                                    <button wire:click="showDialogMarcarAsistencia({{ $matricula->id }})"
                                        title="Hora Registrada en Matrícula"
                                        class="inline-flex items-center justify-center p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-600 hover:text-white transition-colors focus:outline-none">
                                        <i class="ph-bold ph-hammer text-lg"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <i class="ph-fill ph-check-circle text-3xl text-green-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">Excelente</h3>
                                <p class="text-sm text-gray-500 mt-1">Todos los estudiantes presentes han marcado su
                                    asistencia o no hay resultados para tus filtros.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

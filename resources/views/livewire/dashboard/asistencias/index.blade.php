<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6" x-data="{ tipo: @entangle('vista') }">
    <livewire:commons.mod-asistencia />

    {{-- Unified Loading Overlay --}}
    <div wire:loading.flex wire:target="generarReporteAsistencia,exportarExcelAsistencia"
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
            <span class="text-gray-700 font-medium">Generando reporte...</span>
        </div>
    </div>

    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <i class="ph ph-calendar-check text-colegio-600 mr-3 text-3xl"></i> Asistencia de Estudiantes
            </h1>
        </div>
        <div>
            <a href="{{ route('asistencias.feriados') }}"
                class="inline-flex flex-row items-center text-sm font-semibold text-colegio-600 hover:text-colegio-700 bg-colegio-50 px-4 py-2 rounded-lg border border-colegio-100 transition-colors">
                <i class="ph ph-calendar-x mr-2 text-lg"></i> Gestión de Feriados
            </a>
        </div>
    </div>

    {{-- Search & Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-2 space-y-1">
                <label class="block text-xs font-semibold text-gray-800 uppercase tracking-wider">Nivel</label>
                <select wire:model="nivel"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 text-sm">
                    <option value="">Seleccione nivel...</option>
                    <option value="P">Primaria</option>
                    <option value="S">Secundaria</option>
                </select>
            </div>

            <div class="md:col-span-2 space-y-1">
                <label class="block text-xs font-semibold text-gray-800 uppercase tracking-wider">Grado</label>
                <select wire:model="grado" @if (!$grados || count($grados) == 0) disabled @endif
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 text-sm disabled:bg-gray-100 disabled:text-gray-800">
                    <option value="">Seleccione grado...</option>
                    @foreach ($grados as $g)
                        <option value="{{ $g->numero }}">{{ $g->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-3 space-y-1">
                <label class="block text-xs font-semibold text-gray-800 uppercase tracking-wider">Fecha</label>
                <input type="date" wire:model='day'
                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 text-sm" />
            </div>

            <div class="md:col-span-5 space-y-1">
                <label class="block text-xs font-semibold text-gray-800 uppercase tracking-wider">Vista</label>
                <div class="flex shadow-sm rounded-lg w-full">
                    <button @click="tipo = 'dia'"
                        :class="tipo == 'dia' ? 'bg-colegio-600 text-white border-colegio-600' :
                            'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-r-0 rounded-l-lg text-sm font-medium transition-colors">
                        <i class="ph ph-calendar-blank mr-2 text-lg"></i> Día
                    </button>
                    <button @click="tipo = 'semana'"
                        :class="tipo == 'semana' ? 'bg-colegio-600 text-white border-colegio-600' :
                            'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-r-0 text-sm font-medium transition-colors">
                        <i class="ph ph-calendar-star mr-2 text-lg"></i> Semana
                    </button>
                    <button @click="tipo = 'mes'"
                        :class="tipo == 'mes' ? 'bg-colegio-600 text-white border-colegio-600' :
                            'bg-white text-gray-700 hover:bg-gray-50 border-gray-300'"
                        class="flex-1 inline-flex justify-center items-center px-4 py-2 border rounded-r-lg text-sm font-medium transition-colors">
                        <i class="ph ph-calendar-dots mr-2 text-lg"></i> Mes
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Panel de Reportes --}}
    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl shadow-sm border border-blue-100 p-5">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div>
                <h3 class="text-blue-800 font-bold text-lg flex items-center">
                    <i class="ph-fill ph-file-text mr-2 text-xl text-blue-600"></i> Generar Reporte de Asistencias
                </h3>
                <p class="text-blue-600 text-sm mt-1">
                    Genera un informe detallado de asistencias en formato PDF o Excel
                </p>
                @if (empty($grado))
                    <div
                        class="mt-2 inline-flex items-center text-xs text-blue-700 bg-blue-100 px-2 py-1 rounded-md font-medium">
                        <i class="ph-fill ph-info mr-1"></i> Sin grado seleccionado: se generará reporte para todos los
                        grados del nivel
                    </div>
                @endif
            </div>

            <div class="flex flex-wrap items-end gap-3">
                <div class="space-y-1 w-24">
                    <label class="block text-xs font-semibold text-blue-800 uppercase">Año</label>
                    <select wire:model="anio_reporte"
                        class="block w-full pl-3 pr-8 py-2 border border-blue-200 bg-white rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                        @for ($i = 2020; $i <= date('Y') + 1; $i++)
                            <option value="{{ $i }}" @if ($i == date('Y')) selected @endif>
                                {{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="space-y-1 w-36">
                    <label class="block text-xs font-semibold text-blue-800 uppercase">Mes</label>
                    <select wire:model="mes_reporte"
                        class="block w-full pl-3 pr-8 py-2 border border-blue-200 bg-white rounded-lg focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-sm">
                        <option value="03" @if (date('m') == '03') selected @endif>Marzo</option>
                        <option value="04" @if (date('m') == '04') selected @endif>Abril</option>
                        <option value="05" @if (date('m') == '05') selected @endif>Mayo</option>
                        <option value="06" @if (date('m') == '06') selected @endif>Junio</option>
                        <option value="07" @if (date('m') == '07') selected @endif>Julio</option>
                        <option value="08" @if (date('m') == '08') selected @endif>Agosto</option>
                        <option value="09" @if (date('m') == '09') selected @endif>Septiembre</option>
                        <option value="10" @if (date('m') == '10') selected @endif>Octubre</option>
                        <option value="11" @if (date('m') == '11') selected @endif>Noviembre</option>
                        <option value="12" @if (date('m') == '12') selected @endif>Diciembre</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button wire:click="generarReporteAsistencia"
                        @if (empty($nivel)) disabled title="Seleccione nivel" @endif
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <i class="ph ph-file-pdf mr-2 text-lg"></i>
                        {{ empty($grado) ? 'PDF (Todos)' : 'PDF' }}
                    </button>

                    <button wire:click="exportarExcelAsistencia"
                        @if (empty($nivel)) disabled title="Seleccione nivel" @endif
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                        <i class="ph ph-file-xls mr-2 text-lg"></i>
                        {{ empty($grado) ? 'Excel (Todos)' : 'Excel' }}
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Información si falta selección --}}
    @if (empty($nivel))
        <div class="rounded-xl border border-blue-200 bg-blue-50 p-4 flex items-start">
            <i class="ph-fill ph-info text-blue-500 text-xl mr-3 mt-0.5"></i>
            <div>
                <p class="text-sm text-blue-800">
                    <strong class="font-bold">Seleccione nivel</strong> para visualizar las asistencias de los
                    estudiantes y poder generar reportes. Si no selecciona grado, se generará un reporte con todos los
                    grados del nivel.
                </p>
            </div>
        </div>
    @endif

    @if (!empty($nivel) && empty($grado))
        <div class="rounded-xl border border-yellow-200 bg-yellow-50 p-4 flex items-start">
            <i class="ph-fill ph-warning text-yellow-500 text-xl mr-3 mt-0.5"></i>
            <div>
                <p class="text-sm text-yellow-800">
                    <strong class="font-bold">Sin grado seleccionado:</strong> Para visualizar asistencias en pantalla
                    debe seleccionar un grado específico. Sin embargo, puede generar un reporte corporativo con todos
                    los grados del nivel {{ $nivel == 'P' ? 'Primaria' : 'Secundaria' }}.
                </p>
            </div>
        </div>
    @endif

    {{-- Vista por Día --}}
    @if ($vista == 'dia' && sizeof($alumnos) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-visible relative z-20">
            <div class="overflow-x-auto pb-6">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-800 uppercase bg-gray-50 border-b border-gray-300">
                        <tr>
                            <th scope="col" class="px-2 py-2 font-semibold">
                                <div class="flex items-center"><i
                                        class="ph-fill ph-student text-gray-800 mr-2 text-lg"></i> Alumno</div>
                            </th>
                            <th scope="col" class="px-2 py-2 font-semibold text-center w-32">Estado</th>
                            <th scope="col" class="px-2 py-2 font-semibold text-center w-32">
                                <div class="flex justify-center items-center"><i
                                        class="ph-fill ph-clock text-gray-800 mr-1 text-lg"></i> Entrada</div>
                            </th>
                            <th scope="col" class="px-2 py-2 font-semibold text-center w-32">Obs. E.</th>
                            <th scope="col" class="px-2 py-2 font-semibold text-center w-32">
                                <div class="flex justify-center items-center"><i
                                        class="ph-fill ph-door-open text-gray-800 mr-1 text-lg"></i> Salida</div>
                            </th>
                            <th scope="col" class="px-2 py-2 font-semibold text-center w-32">Obs. S.</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($alumnos as $alumno)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-2 py-2 font-semibold text-gray-900">
                                    {{ $alumno['nombre'] }}
                                </td>
                                @foreach ($alumno['dias'] as $dia)
                                    <td class="px-2 py-2 text-center">
                                        @if ($dia['tipo'] == 'N')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="ph-bold ph-check mr-1"></i> Presente
                                            </span>
                                        @elseif($dia['tipo'] == 'T')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 cursor-pointer hover:bg-yellow-200"
                                                wire:click="mostrarJustificarTardanza({{ $dia['asistencia_id'] }})"
                                                title="Click para justificar">
                                                <i class="ph-bold ph-hourglass mr-1"></i> Tardanza
                                            </span>
                                        @elseif($dia['tipo'] == 'TJ')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <i class="ph-bold ph-check-circle mr-1"></i> T. Justificada
                                            </span>
                                        @elseif($dia['tipo'] == 'F')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                <i class="ph-bold ph-calendar-plus mr-1"></i> Feriado
                                            </span>
                                        @elseif($dia['tipo'] == 'FI')
                                            <button type="button"
                                                wire:click="mostrarJustificarAusencia({{ $dia['asistencia_id'] }})"
                                                title="Click para regularizar"
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-600 text-white hover:bg-red-700 focus:outline-none transition-colors shadow-sm">
                                                <i class="ph-bold ph-warning-circle mr-1"></i> Falta
                                            </button>
                                        @elseif($dia['tipo'] == 'FJ')
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                <i class="ph-bold ph-file-text mr-1"></i> F. Justificada
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                                <i class="ph-bold ph-clock mr-1"></i> S/R
                                            </span>
                                        @endif
                                    </td>

                                    @if ($dia['tipo'] == 'FI')
                                        <td colspan="4" class="px-2 py-2 text-center bg-red-50">
                                            <span class="text-sm font-bold text-red-700">Falta Injustificada</span>
                                        </td>
                                    @elseif($dia['tipo'] == 'FJ')
                                        <td colspan="4" class="px-2 py-2 text-center bg-blue-50">
                                            <span class="text-sm font-bold text-blue-700">Falta Justificada
                                                (Permiso)
                                            </span>
                                        </td>
                                    @elseif($dia['tipo'] == 'F')
                                        <td colspan="4" class="px-2 py-2 text-center bg-gray-50">
                                            <span class="text-sm font-bold text-gray-800">Día Feriado</span>
                                        </td>
                                    @else
                                        <td class="px-2 py-2 text-center">
                                            @if ($dia['entrada'])
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-teal-100 text-teal-800">
                                                    {{ \Carbon\Carbon::parse($dia['entrada'])->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="text-gray-800">-</span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            @if ($dia['tardanza_entrada'])
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800">
                                                    {{ $dia['tardanza_entrada'] }}
                                                </span>
                                            @else
                                                <span class="text-gray-800">-</span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            @if ($dia['salida'])
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-indigo-100 text-indigo-800">
                                                    {{ \Carbon\Carbon::parse($dia['salida'])->format('h:i A') }}
                                                </span>
                                            @else
                                                <span class="text-gray-800">-</span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 text-center">
                                            @if ($dia['salida_anticipada'])
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold bg-yellow-100 text-yellow-800">
                                                    {{ $dia['salida_anticipada'] }}
                                                </span>
                                            @else
                                                <span class="text-gray-800">-</span>
                                            @endif
                                        </td>
                                    @endif
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Vista por Semana/Mes --}}
    @elseif(in_array($vista, ['semana', 'mes']) && sizeof($alumnos) > 0)
        <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-visible relative z-20">
            <div class="overflow-x-auto pb-6">
                <table class="w-full text-sm text-left text-gray-600">
                    <thead class="text-xs text-gray-800 uppercase bg-gray-50 border-b border-gray-300 bg-gray-100">
                        <tr>
                            <th scope="col" rowspan="2"
                                class="px-2 py-2 font-semibold w-1/4 align-middle border-r border-gray-200">
                                <div class="flex items-center"><i
                                        class="ph-fill ph-student text-gray-800 mr-2 text-lg"></i> Alumno</div>
                            </th>
                            @foreach ($dias as $dia)
                                <th scope="col"
                                    class="px-2 py-2 font-bold text-center border-b border-gray-200 min-w-[60px]">
                                    {{ $dia['dia_letra'] }}
                                </th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach ($dias as $dia)
                                <th scope="col" class="px-2 py-2 font-semibold text-center pb-3">
                                    {{ \Carbon\Carbon::parse($dia['fecha'])->format('d/m') }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @foreach ($alumnos as $alumno)
                            <tr>
                                <td rowspan="2"
                                    class="px-2 py-2 font-semibold text-gray-900 border-r border-gray-300 align-middle">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mr-3 font-bold text-xs shrink-0">
                                            {{ substr($alumno['nombre'], 0, 1) }}
                                        </div>
                                        <span>{{ $alumno['nombre'] }}</span>
                                    </div>
                                </td>
                                @foreach ($alumno['dias'] as $dia)
                                    <td class="px-2 py-2 text-center bg-blue-50/30 border-b border-gray-50">
                                        @if ($dia['entrada'])
                                            <span
                                                class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] sm:text-xs font-medium bg-teal-100 text-teal-800"
                                                title="Entrada">
                                                <i class="ph-bold ph-sign-in mr-1 hidden sm:inline"></i>
                                                {{ \Carbon\Carbon::parse($dia['entrada'])->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                            <tr>
                                @foreach ($alumno['dias'] as $dia)
                                    <td class="px-2 py-2 text-center bg-orange-50/30">
                                        @if ($dia['salida'])
                                            <span
                                                class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] sm:text-xs font-medium bg-indigo-100 text-indigo-800"
                                                title="Salida">
                                                <i class="ph-bold ph-sign-out mr-1 hidden sm:inline"></i>
                                                {{ \Carbon\Carbon::parse($dia['salida'])->format('H:i') }}
                                            </span>
                                        @else
                                            <span class="text-gray-300">-</span>
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Estado vacío --}}
    @if (sizeof($alumnos) == 0 && !empty($nivel) && !empty($grado))
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-12 flex flex-col items-center justify-center">
            <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                <i class="ph-fill ph-users-three text-4xl text-gray-800"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-800 mb-2">No hay registros de asistencia</h3>
            <p class="text-gray-800 text-center max-w-md">
                No se encontraron estudiantes matriculados en {{ $nivel == 'P' ? 'Primaria' : 'Secundaria' }} -
                @if ($grados && $grado)
                    {{ collect($grados)->where('numero', $grado)->first()->nombre ?? $grado }}
                @else
                    Grado {{ $grado }}
                @endif
                para la fecha seleccionada.
            </p>
        </div>
    @endif
</div>

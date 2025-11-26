@section('title', 'Asistencias')

<main class="container mx-auto px-4 py-10 space-y-8">

    <!-- Loading -->
    <div class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center"  wire:loading wire:target="consultarMatricula" style="display: none;">
        <div class="bg-white rounded-xl p-6 text-center shadow-lg">
            <div class="w-10 h-10 mx-auto mb-3 border-4 border-primary/30 border-t-primary rounded-full animate-spin"></div>
            <p class="text-gray-700 text-sm font-medium">Consultando asistencias...</p>
        </div>
    </div>

    <!-- Steps -->
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-center space-x-6">
            <!-- Paso 1 -->
            <div class="flex flex-col items-center text-center">
                <div class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                    @if($step == 1) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                    @else bg-green-500 text-white @endif">
                    @if($step > 1) <i class="fas fa-check"></i> @else 1 @endif
                </div>
                <span class="mt-2 text-xs font-semibold">Buscar</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200">
                <div class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if($step >= 2) w-full @else w-0 @endif"></div>
            </div>
            <!-- Paso 2 -->
            <div class="flex flex-col items-center text-center">
                <div class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                    @if($step == 2) bg-gradient-to-r from-contrast3 to-[#f0b82f] text-white shadow-md
                    @elseif($step > 2) bg-green-500 text-white
                    @else bg-gray-300 text-gray-500 @endif">
                    @if($step > 2) <i class="fas fa-check"></i> @else 2 @endif
                </div>
                <span class="mt-2 text-xs font-semibold">Asistencias</span>
            </div>
        </div>
    </div>

    <!-- Contenido -->
    <div class="max-w-4xl mx-auto">
        @if($step == 1)
        <!-- Buscar -->
        <div class="bg-white rounded-xl p-8 shadow-md text-center space-y-6 animate-fade-in">
            <div>
                <div class="w-14 h-14 bg-gradient-to-r from-primary to-red-700 text-white flex items-center justify-center rounded-lg mx-auto mb-4">
                    <i class="fas fa-search text-xl"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Consultar Asistencias</h2>
                <p class="text-gray-500 text-sm">Ingrese el DNI/CE/PTP del estudiante para ver su registro</p>
            </div>

            <form wire:submit.prevent="buscarMatricula" class="space-y-4">
                <div class="max-w-xs mx-auto">
                    <input
                        type="text"
                        wire:model.defer="dni"
                        placeholder="12345678"
                        class="w-full px-4 py-3 text-center text-lg font-mono border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary"
                    />
                    @error('dni')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <p class="text-xs text-blue-600 bg-blue-50 border border-blue-200 rounded-md px-3 py-2 inline-block">
                    Solo 8 dígitos, sin espacios ni guiones.
                </p>

                <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition">
                    Buscar Estudiante <i class="fas fa-arrow-right ml-2"></i>
                </button>
            </form>
        </div>

        @elseif($step == 2)
        <!-- Info Estudiante -->
        <div class="space-y-6 animate-fade-in">

            <!-- Card Alumno -->
            <div class="bg-white rounded-xl p-6 shadow-md grid md:grid-cols-5 gap-6 items-center">
                <div class="md:col-span-1 flex justify-center">
                    <img src="{{ $matricula->alumno->foto }}" alt="Foto" class="w-28 h-28 rounded-lg object-cover shadow">
                </div>
                <div class="md:col-span-2">
                    <h3 class="text-lg font-bold text-gray-800">
                        {{ trim($matricula->alumno->apellido_paterno.' '.$matricula->alumno->apellido_materno.' '.$matricula->alumno->nombres) }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-2">Grado: <span class="font-semibold">{{ $matricula->grado | grado }}</span></p>
                    <p class="text-sm text-gray-600">Nivel: <span class="font-semibold">{{ $matricula->nivel == 'P' ? 'Primaria' : 'Secundaria' }}</span></p>
                </div>
                <div class="md:col-span-2 grid grid-cols-3 gap-3 text-center">
                    <div class="p-3 rounded-md bg-yellow-50">
                        <p class="text-xl font-bold text-yellow-700">{{ $tardanzas }}</p>
                        <p class="text-xs text-yellow-600">Tardanzas</p>
                    </div>
                    <div class="p-3 rounded-md bg-red-50">
                        <p class="text-xl font-bold text-red-700">{{ $fi }}</p>
                        <p class="text-xs text-red-600">F. Injust.</p>
                    </div>
                    <div class="p-3 rounded-md bg-orange-50">
                        <p class="text-xl font-bold text-orange-700">{{ $fj }}</p>
                        <p class="text-xs text-orange-600">F. Just.</p>
                    </div>
                </div>
            </div>

            <!-- Selector de mes -->
            <div class="flex items-center justify-between bg-white p-4 rounded-xl shadow-md">
                <h4 class="text-sm font-semibold text-gray-700">Filtrar por mes</h4>
                <select wire:model="mes" class="border rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary/40">
                    @foreach($meses as $mes)
                        <option value="{{ $mes['numero'] }}">{{ $mes['nombre'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tabla -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-red-700 px-6 py-3 text-white font-semibold">
                    Registro de Asistencias
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-700 font-medium">
                            <tr>
                                <th class="px-4 py-2 text-left">Fecha</th>
                                <th class="px-4 py-2 text-center">Entrada</th>
                                <th class="px-4 py-2 text-center">Estado</th>
                                <th class="px-4 py-2 text-center">Salida</th>
                                <th class="px-4 py-2 text-center">Estado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            @forelse($asistencias as $a)
                                @if(in_array($a->tipo,['N','T']))
                                <tr>
                                    <td class="px-4 py-2">{{ $a->dia | date:'d-m-Y' }}</td>
                                    <td class="px-4 py-2 text-center">{{ $a->entrada | date:'h:i a' }}</td>
                                    <td class="px-4 py-2 text-center">
                                        @if($a->tardanza_entrada)
                                            <span class="px-2 py-1 text-xs bg-red-100 text-red-700 rounded">Tarde</span>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">A tiempo</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-center">
                                        @if($a->salida)
                                            {{ $a->salida | date:'h:i:s a'}}
                                        @endif
                                        </td>
                                    <td class="px-4 py-2 text-center">
                                        @if($a->salida && $a->salida_anticipada)
                                            <span class="px-2 py-1 text-xs bg-orange-100 text-orange-700 rounded">Antes</span>
                                        @elseif($a->salida)
                                            <span class="px-2 py-1 text-xs bg-green-100 text-green-700 rounded">A tiempo</span>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                                @elseif($a->tipo == 'FI')
                                <tr class="bg-red-50 text-red-700 font-medium">
                                    <td class="px-4 py-2">{{ $a->dia | date:'d-m-Y' }}</td>
                                    <td colspan="4" class="px-4 py-2 text-center">Falta Injustificada</td>
                                </tr>
                                @elseif($a->tipo == 'FJ')
                                <tr class="bg-orange-50 text-orange-700 font-medium">
                                    <td class="px-4 py-2">{{ $a->dia | date:'d-m-Y' }}</td>
                                    <td colspan="4" class="px-4 py-2 text-center">Falta Justificada</td>
                                </tr>
                                @elseif($a->tipo == 'F')
                                <tr class="bg-gray-50 text-gray-600 font-medium">
                                    <td class="px-4 py-2">{{ $a->dia | date:'d-m-Y' }}</td>
                                    <td colspan="4" class="px-4 py-2 text-center">{{ $a->feriado->descripcion ?? 'Feriado' }}</td>
                                </tr>
                                @endif
                            @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500">No hay registros</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex justify-between items-center">
                <a href="{{ route('ver.asistencias') }}" class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                    <i class="fas fa-arrow-left mr-2"></i> Volver
                </a>
                <button class="px-5 py-2 bg-gradient-to-r from-contrast3 to-[#f0b82f] text-white rounded-lg hover:from-[#f0b82f] hover:to-contrast3 transition">
                    <i class="fas fa-print mr-2"></i> Imprimir
                </button>
            </div>
        </div>
        @endif
    </div>
</main>

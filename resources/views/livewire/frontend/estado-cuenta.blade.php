@section('title', 'Estado de Cuenta')

<main class="container mx-auto px-4 py-10 space-y-8">

    <!-- Loading -->
    <div class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center" wire:loading
        wire:target="consultarMatricula" style="display: none;">
        <div class="bg-white rounded-xl p-6 text-center shadow-lg">
            <div class="w-10 h-10 mx-auto mb-3 border-4 border-primary/30 border-t-primary rounded-full animate-spin">
            </div>
            <p class="text-gray-700 text-sm font-medium">Consultando estado de cuenta...</p>
        </div>
    </div>

    <!-- Steps -->
    <div class="max-w-2xl mx-auto">
        <div class="flex items-center justify-center space-x-6">
            <!-- Paso 1 -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                    @if ($step == 1) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                    @else bg-green-500 text-white @endif">
                    @if ($step > 1)
                        <i class="fas fa-check"></i>
                    @else
                        1
                    @endif
                </div>
                <span class="mt-2 text-xs font-semibold">Buscar Matrícula</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200">
                <div
                    class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 2) w-full @else w-0 @endif">
                </div>
            </div>
            <!-- Paso 2 -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                    @if ($step == 2) bg-gradient-to-r from-contrast3 to-blue-700 text-white shadow-md
                    @elseif($step > 2) bg-green-500 text-white
                    @else bg-gray-300 text-gray-500 @endif">
                    @if ($step > 2)
                        <i class="fas fa-check"></i>
                    @else
                        2
                    @endif
                </div>
                <span class="mt-2 text-xs font-semibold">Estado de Cuenta</span>
            </div>
        </div>
    </div>

    <!-- Contenido -->
    <div class="max-w-4xl mx-auto">
        @if ($step == 1)
            <!-- Buscar Matrícula -->
            <div class="bg-white rounded-xl p-8 shadow-md text-center space-y-6 animate-fade-in">
                <div>
                    <div
                        class="w-14 h-14 bg-gradient-to-r from-primary to-red-700 text-white flex items-center justify-center rounded-lg mx-auto mb-4">
                        <i class="fas fa-file-invoice text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Consultar Estado de Cuenta</h2>
                    <p class="text-gray-500 text-sm">Ingrese el DNI/CE/PTP del alumno para ver el estado de sus
                        pensiones</p>
                </div>

                <form wire:submit.prevent="buscarMatricula" class="space-y-4">
                    <div class="max-w-xs mx-auto">
                        <input type="text" wire:model.defer="codigo" onkeyup="mayus(this);" placeholder="12345678"
                            class="w-full px-4 py-3 text-center text-lg font-mono border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('codigo') border-red-500 @enderror" />
                        @error('codigo')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div
                        class="text-xs text-blue-600 bg-blue-50 border border-blue-200 rounded-md px-3 py-2 inline-block max-w-sm mx-auto">
                        <i class="fas fa-info-circle mr-1"></i>
                        Ingrese el DNI del alumno, sin separaciones ni guiones. Tampoco debe agregar el código
                        verificador.
                    </div>

                    <button type="submit"
                        class="px-6 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition">
                        Continuar <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>
            </div>
        @elseif($step == 2)
            <!-- Estado de Cuenta -->
            <div class="space-y-6 animate-fade-in">

                <!-- Card Alumno -->
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="grid md:grid-cols-4 gap-6 text-center">
                        <div class="space-y-1">
                            <div class="text-sm font-semibold text-gray-700">Alumno(a)</div>
                            <div class="text-lg font-bold text-gray-800">
                                {{ trim($matricula->alumno->apellido_paterno . ' ' . $matricula->alumno->apellido_materno . ' ' . $matricula->alumno->nombres) }}
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm font-semibold text-gray-700">Grado</div>
                            <div class="text-lg font-bold text-primary">
                                {{ $matricula->grado | grado }}
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm font-semibold text-gray-700">Nivel</div>
                            <div class="text-lg font-bold text-contrast3">
                                {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}
                            </div>
                        </div>
                        <div class="space-y-1">
                            <div class="text-sm font-semibold text-gray-700">Año Lectivo</div>
                            <div class="text-lg font-bold text-secondary">
                                {{ $matricula->anio }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estado de Pensiones -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="bg-gradient-to-r from-primary to-red-700 px-6 py-3 text-white font-semibold">
                        <i class="fas fa-file-invoice mr-2"></i>
                        Estado de Pensiones
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-700 font-medium">
                                <tr>
                                    <th class="px-4 py-3 text-left">Orden</th>
                                    <th class="px-4 py-3 text-left">Concepto</th>
                                    <th class="px-4 py-3 text-center">Monto</th>
                                    <th class="px-4 py-3 text-center">Vencimiento</th>
                                    <th class="px-4 py-3 text-center">Estado</th>
                                    <th class="px-4 py-3 text-center">Comprobante</th>
                                    <th class="px-4 py-3 text-center">Fecha Pago</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach ($misPensiones as $pension)
                                    <tr
                                        class="hover:bg-gray-50 transition-colors
                                    @if ($pension->vencido && $pension->estado == null) bg-red-50 @endif">

                                        <!-- Orden -->
                                        <td class="px-4 py-3 font-semibold text-gray-800">
                                            {{ $pension->orden }}
                                        </td>

                                        <!-- Concepto -->
                                        <td class="px-4 py-3">
                                            <div class="font-medium text-gray-800">{{ $pension->nombre }}</div>
                                        </td>

                                        <!-- Monto -->
                                        <td class="px-4 py-3 text-center">
                                            <span class="font-bold text-lg text-green-600">
                                                S/. {{ number_format($pension->costo, 2) }}
                                            </span>
                                        </td>

                                        <!-- Vencimiento -->
                                        <td class="px-4 py-3 text-center">
                                            <span
                                                class="text-sm font-medium
                                            @if ($pension->vencido && $pension->estado == null) text-red-600
                                            @else text-gray-600 @endif">
                                                {{ $pension->fecha_vencimiento | dateFormat }}
                                            </span>
                                        </td>

                                        <!-- Estado Pagada -->
                                        <td class="px-4 py-3 text-center">
                                            @if ($pension->estado != null)
                                                @if ($pension->estado == 1)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-green-100 text-green-700 rounded-full font-medium">
                                                        <i class="fas fa-check-double mr-1"></i>
                                                        Pagado
                                                    </span>
                                                @elseif($pension->estado == 0)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded-full font-medium">
                                                        <i class="fas fa-check-double mr-1"></i>
                                                        Procesado
                                                    </span>
                                                @endif
                                            @else
                                                @if ($pension->vencido)
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-red-100 text-red-700 rounded-full font-medium">
                                                        <i class="fas fa-times mr-1"></i>
                                                        Vencido
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded-full font-medium">
                                                        <i class="fas fa-clock mr-1"></i>
                                                        Pendiente
                                                    </span>
                                                @endif
                                            @endif
                                        </td>

                                        <!-- Comprobante -->
                                        <td class="px-4 py-3 text-center">
                                            @if ($pension->estado != null)
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 bg-green-100 text-green-600 rounded-full">
                                                    <i class="fas fa-file-invoice text-sm"></i>
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-800 rounded-full">
                                                    <i class="fas fa-clock text-sm"></i>
                                                </span>
                                            @endif
                                        </td>

                                        <!-- Fecha Pago -->
                                        <td class="px-4 py-3 text-center">
                                            @if ($pension->estado != null)
                                                <span class="text-sm font-medium text-gray-600">
                                                    {{ $pension->fecha_pago | dateFormat }}
                                                </span>
                                            @else
                                                <span class="text-gray-800">
                                                    <i class="fas fa-minus"></i>
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Resumen -->
                    <div class="border-t bg-gray-50 px-6 py-4">
                        <div class="grid md:grid-cols-3 gap-4 text-center">
                            <div class="p-3 rounded-md bg-green-50">
                                <p class="text-lg font-bold text-green-700">
                                    {{ $misPensiones->where('estado', '!=', null)->count() }}
                                </p>
                                <p class="text-xs text-green-600">Pagadas</p>
                            </div>
                            <div class="p-3 rounded-md bg-red-50">
                                <p class="text-lg font-bold text-red-700">
                                    {{ $misPensiones->where('vencido', true)->where('estado', null)->count() }}
                                </p>
                                <p class="text-xs text-red-600">Vencidas</p>
                            </div>
                            <div class="p-3 rounded-md bg-yellow-50">
                                <p class="text-lg font-bold text-yellow-700">
                                    {{ $misPensiones->where('estado', null)->where('vencido', false)->count() }}
                                </p>
                                <p class="text-xs text-yellow-600">Pendientes</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-between items-center">
                    <a href="{{ route('estado.cuenta') }}"
                        class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i> Salir
                    </a>
                    <button
                        class="px-5 py-2 bg-gradient-to-r from-contrast3 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-contrast3 transition">
                        <i class="fas fa-print mr-2"></i> Imprimir
                    </button>
                </div>
            </div>
        @endif
    </div>
</main>

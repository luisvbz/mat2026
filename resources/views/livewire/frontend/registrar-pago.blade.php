@section('title', 'Registrar Pago')

<div>
    <!-- Loading Screens -->
    <div class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center" wire:loading
        wire:target="buscarMatricula" style="display: none;">
        <div class="bg-white rounded-xl p-6 text-center shadow-lg">
            <div class="w-10 h-10 mx-auto mb-3 border-4 border-primary/30 border-t-primary rounded-full animate-spin">
            </div>
            <p class="text-gray-700 text-sm font-medium">Buscando matrícula...</p>
        </div>
    </div>

    <div class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center" wire:loading
        wire:target="registrarPagoMatricula" style="display: none;">
        <div class="bg-white rounded-xl p-6 text-center shadow-lg">
            <div class="w-10 h-10 mx-auto mb-3 border-4 border-primary/30 border-t-primary rounded-full animate-spin">
            </div>
            <p class="text-gray-700 text-sm font-medium">Registrando pago...</p>
        </div>
    </div>

    <div class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center" wire:loading
        wire:target="registrarPagosPension" style="display: none;">
        <div class="bg-white rounded-xl p-6 text-center shadow-lg">
            <div class="w-10 h-10 mx-auto mb-3 border-4 border-primary/30 border-t-primary rounded-full animate-spin">
            </div>
            <p class="text-gray-700 text-sm font-medium">Registrando pagos...</p>
        </div>
    </div>

    <!-- Steps Progress -->
    <div class="max-w-3xl mx-auto">
        <div class="flex items-center justify-center space-x-6  mb-8">
            <!-- Paso 1: Buscar Matrícula -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full font-bold text-sm
                    @if ($step == 1) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                    @elseif($step > 1) bg-green-500 text-white
                    @else bg-gray-300 text-gray-500 @endif">
                    @if ($step > 1)
                        <i class="fas fa-check"></i>
                    @else
                        1
                    @endif
                </div>
                <span
                    class="mt-2 text-xs font-semibold @if ($step == 1) text-primary @elseif($step > 1) text-green-600 @else text-gray-400 @endif">
                    Buscar Matrícula
                </span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200">
                <div
                    class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 2) w-full @else w-0 @endif">
                </div>
            </div>

            <!-- Paso 2: Concepto -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full font-bold text-sm
                    @if ($step == 2) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                    @elseif($step > 2) bg-green-500 text-white
                    @else bg-gray-300 text-gray-500 @endif">
                    @if ($step > 2)
                        <i class="fas fa-check"></i>
                    @else
                        2
                    @endif
                </div>
                <span
                    class="mt-2 text-xs font-semibold @if ($step == 2) text-primary @elseif($step > 2) text-green-600 @else text-gray-400 @endif">
                    Concepto
                </span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200">
                <div
                    class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 3) w-full @else w-0 @endif">
                </div>
            </div>

            <!-- Paso 3: Registrar Pago -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full font-bold text-sm
                    @if ($step == 3) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                    @elseif($step > 3) bg-green-500 text-white
                    @else bg-gray-300 text-gray-500 @endif">
                    @if ($step > 3)
                        <i class="fas fa-check"></i>
                    @else
                        3
                    @endif
                </div>
                <span
                    class="mt-2 text-xs font-semibold @if ($step == 3) text-primary @elseif($step > 3) text-green-600 @else text-gray-400 @endif">
                    Registrar Pago
                </span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200">
                <div
                    class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 4) w-full @else w-0 @endif">
                </div>
            </div>

            <!-- Paso 4: Finalizado -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-12 h-12 flex items-center justify-center rounded-full font-bold text-sm
                    @if ($step == 4) bg-gradient-to-r from-green-500 to-green-700 text-white shadow-md
                    @else bg-gray-300 text-gray-500 @endif">
                    @if ($step == 4)
                        <i class="fas fa-check"></i>
                    @else
                        4
                    @endif
                </div>
                <span
                    class="mt-2 text-xs font-semibold @if ($step == 4) text-green-600 @else text-gray-400 @endif">
                    Finalizado
                </span>
            </div>
        </div>
    </div>

    <!-- Content Area -->
    <div class="max-w-4xl mx-auto">
        @if ($step == 1)
            <!-- Paso 1: Buscar Matrícula -->
            <div class="bg-white rounded-xl p-8 shadow-md text-center space-y-6 animate-fade-in">
                <div>
                    <div
                        class="w-16 h-16 bg-gradient-to-r from-primary to-red-700 text-white flex items-center justify-center rounded-xl mx-auto mb-4 shadow-lg">
                        <i class="fas fa-file-invoice-dollar text-2xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Registrar Pago</h2>
                    <p class="text-gray-500">Ingrese el DNI del estudiante para continuar</p>
                </div>

                <form wire:submit.prevent="buscarMatricula" class="space-y-6">
                    <div class="max-w-sm mx-auto">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">DNI/CE/PTP del alumno</label>
                        <input type="text" wire:model.defer="codigo"  placeholder="12345678"
                            class="w-full px-4 py-3 text-center text-lg font-mono border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('codigo') border-red-500 @enderror" />
                        @error('codigo')
                            <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 max-w-md mx-auto">
                        <p class="text-xs text-blue-700">
                            <i class="fas fa-info-circle mr-2"></i>
                            Ingrese el DNI del alumno, sin separaciones ni guiones. Tampoco debe agregar el código
                            verificador.
                        </p>
                    </div>

                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition-all duration-300 shadow-lg">
                        Continuar <i class="fas fa-arrow-right ml-2"></i>
                    </button>
                </form>
            </div>
        @elseif($step == 2)
            <!-- Paso 2: Seleccionar Concepto -->
            <div class="space-y-6 animate-fade-in">
                <!-- Card Estudiante -->
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="grid md:grid-cols-4 gap-6 text-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Alumno(a)</p>
                            <p class="text-gray-800 font-medium">
                                {{ trim($matricula->alumno->apellido_paterno . ' ' . $matricula->alumno->apellido_materno . ' ' . $matricula->alumno->nombres) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Grado</p>
                            <p class="text-gray-800 font-medium">{{ $matricula->grado | grado }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Nivel</p>
                            <p class="text-gray-800 font-medium">
                                {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Año Lectivo</p>
                            <p class="text-gray-800 font-medium">{{ $matricula->anio }}</p>
                        </div>
                    </div>
                </div>

                <!-- Selector de Concepto -->
                <div class="bg-white rounded-xl p-8 shadow-md text-center space-y-6">
                    <h3 class="text-xl font-bold text-gray-800">Seleccione el concepto de pago</h3>

                    <form wire:submit.prevent="seleccionarConcepto" class="space-y-6">
                        <div class="max-w-md mx-auto">
                            <div class="grid grid-cols-2 gap-4">
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="concepto" value="M" class="sr-only peer">
                                    <div
                                        class="p-6 border-2 border-gray-200 rounded-xl text-center peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all duration-300">
                                        <i class="fas fa-user-graduate text-2xl text-primary mb-3"></i>
                                        <p class="font-semibold text-gray-800">Matrícula</p>
                                    </div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" wire:model="concepto" value="P" class="sr-only peer">
                                    <div
                                        class="p-6 border-2 border-gray-200 rounded-xl text-center peer-checked:border-primary peer-checked:bg-primary/5 hover:border-primary/50 transition-all duration-300">
                                        <i class="fas fa-calendar-alt text-2xl text-primary mb-3"></i>
                                        <p class="font-semibold text-gray-800">Pensión</p>
                                    </div>
                                </label>
                            </div>
                            @error('concepto')
                                <p class="text-red-600 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="px-8 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition-all duration-300 shadow-lg">
                            Continuar <i class="fas fa-arrow-right ml-2"></i>
                        </button>
                    </form>
                </div>
            </div>
        @elseif($step == 3 && $concepto == 'M')
            <!-- Paso 3: Registrar Pago de Matrícula -->
            <div class="space-y-6 animate-fade-in">
                <!-- Info Estudiante -->
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="grid md:grid-cols-4 gap-6 text-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Alumno(a)</p>
                            <p class="text-gray-800 font-medium">
                                {{ trim($matricula->alumno->apellido_paterno . ' ' . $matricula->alumno->apellido_materno . ' ' . $matricula->alumno->nombres) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Grado</p>
                            <p class="text-gray-800 font-medium">{{ $matricula->grado | grado }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Nivel</p>
                            <p class="text-gray-800 font-medium">
                                {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Año Lectivo</p>
                            <p class="text-gray-800 font-medium">{{ $matricula->anio }}</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Pago Matrícula -->
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <div class="flex items-center mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-r from-primary to-red-700 text-white flex items-center justify-center rounded-lg mr-3">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Pago de Matrícula</h3>
                    </div>

                    <form wire:submit.prevent="registrarPagoMatricula" class="space-y-6">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de operación</label>
                                <select wire:model.debounce.500ms="pago.tipo_pago"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('pago.tipo_pago') border-red-500 @enderror">
                                    <option value="">Seleccione</option>
                                    <option value="A">Depósito en Agente</option>
                                    <option value="D">Depósito en banco</option>
                                    <option value="T">Transferencia bancaria</option>
                                    <option value="Y">Pago YAPE</option>
                                </select>
                                @error('pago.tipo_pago')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($pago['tipo_pago'] != 'E' && $pago['tipo_pago'] != '')
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">
                                        @if ($pago['tipo_pago'] === 'Y')
                                            Nombre en Yape
                                        @else
                                            Número de operación/comprobante
                                        @endif
                                    </label>
                                    <input type="text" wire:model.debounce.500ms="pago.numero_operacion"
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('pago.numero_operacion') border-red-500 @enderror" />
                                    @error('pago.numero_operacion')
                                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div>

                        <div class="grid md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de Pago</label>
                                <input type="text" autocomplete="off" wire:model.lazy="pago.fecha"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('pago.fecha') border-red-500 @enderror"
                                    id="fecha-pago" placeholder="DD/MM/YYYY" />
                                @error('pago.fecha')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Monto Pagado</label>
                                <input style="text-align: right" type="text"
                                    wire:model.debounce.500ms="pago.monto_pagado"
                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('pago.monto_pagado') border-red-500 @enderror"
                                    id="monto-pago" placeholder="0.00" />
                                @error('pago.monto_pagado')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Comprobante
                                    (jpg,png)</label>
                                <div class="relative">
                                    <input
                                        class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary file:text-white file:cursor-pointer hover:file:bg-red-700"
                                        type="file" wire:model.debounce.500ms="pago.comprobante" accept="image/*">
                                    @if ($pago['comprobante'])
                                        <p class="text-xs text-green-600 mt-1">
                                            <i
                                                class="fas fa-check mr-1"></i>{{ $pago['comprobante']->getClientOriginalName() }}
                                        </p>
                                    @endif
                                </div>
                                <p wire:loading wire:target="pago.comprobante" class="text-xs text-blue-600 mt-1">
                                    <i class="fas fa-spinner fa-spin mr-1"></i>Cargando...
                                </p>
                                @error('pago.comprobante')
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-between items-center pt-6 border-t">
                            <button type="button" wire:click="goToStep(2)"
                                class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-300">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="submit" wire:loading.remove
                                class="px-8 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition-all duration-300 shadow-lg">
                                Registrar pago <i class="fas fa-check ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($step == 3 && $concepto == 'P')
            <!-- Paso 3: Registrar Pagos de Pensión -->
            <div class="space-y-6 animate-fade-in">
                <!-- Info Estudiante -->
                <div class="bg-white rounded-xl p-6 shadow-md">
                    <div class="grid md:grid-cols-4 gap-6 text-center">
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Alumno(a)</p>
                            <p class="text-gray-800 font-medium">
                                {{ trim($matricula->alumno->apellido_paterno . ' ' . $matricula->alumno->apellido_materno . ' ' . $matricula->alumno->nombres) }}
                            </p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Grado</p>
                            <p class="text-gray-800 font-medium">{{ $matricula->grado | grado }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Nivel</p>
                            <p class="text-gray-800 font-medium">
                                {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-600 mb-1">Año Lectivo</p>
                            <p class="text-gray-800 font-medium">{{ $matricula->anio }}</p>
                        </div>
                    </div>
                </div>

                <!-- Formulario de Pagos de Pensión -->
                <div class="bg-white rounded-xl p-8 shadow-md">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-gradient-to-r from-contrast3 to-blue-700 text-white flex items-center justify-center rounded-lg mr-3">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Pagos de Pensión</h3>
                        </div>
                        <button type="button" wire:click="agregarPago"
                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-all duration-300 text-sm">
                            <i class="fas fa-plus mr-2"></i> Agregar Mes
                        </button>
                    </div>

                    <form wire:submit.prevent="registrarPagosPension" class="space-y-6">
                        <!-- Lista de Pagos -->
                        <div class="space-y-4">
                            @foreach ($pagosPension as $index => $pago)
                                <div class="border border-gray-200 rounded-lg p-6 relative">
                                    @if (count($pagosPension) > 1)
                                        <button type="button" wire:click="removerPago({{ $index }})"
                                            class="absolute top-2 right-2 w-6 h-6 bg-red-500 text-white rounded-full text-xs hover:bg-red-600 transition-colors">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif

                                    <div class="grid md:grid-cols-4 gap-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Mes de
                                                pensión</label>
                                            <select wire:model.debounce.500ms="pagosPension.{{ $index }}.mes"
                                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('pagosPension.' . $index . '.mes') border-red-500 @enderror">
                                                <option value="">Seleccione</option>
                                                @foreach ($pensiones as $pension)
                                                    @php
                                                        $mesYaSeleccionado =
                                                            collect($pagosPension)
                                                                ->pluck('mes')
                                                                ->contains($pension['value']) &&
                                                            $pagosPension[$index]['mes'] != $pension['value'];
                                                    @endphp
                                                    <option value="{{ $pension['value'] }}"
                                                        @if ($pension['disabled'] || $mesYaSeleccionado) disabled @endif
                                                        @if ($mesYaSeleccionado) style="color: #cbd5e0;" @endif>
                                                        {{ $pension['mes'] }}
                                                        @if ($mesYaSeleccionado)
                                                            (Ya seleccionado)
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('pagosPension.' . $index . '.mes')
                                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de
                                                Pago</label>
                                            <input type="date"
                                                wire:model="pagosPension.{{ $index }}.fecha_pago"
                                                class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('pagosPension.' . $index . '.fecha_pago') border-red-500 @enderror" />
                                            @error('pagosPension.' . $index . '.fecha_pago')
                                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Monto a
                                                pagar</label>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">S./</span>
                                                <input type="text" value="{{ $pago['monto'] ?? '0.00' }}"
                                                    class="w-full pl-10 pr-4 py-3 border rounded-lg bg-gray-50 text-gray-600"
                                                    disabled />
                                            </div>
                                        </div>

                                        <div>
                                            <label
                                                class="block text-sm font-semibold text-gray-700 mb-2">Comprobante</label>
                                            <div class="relative" x-data="{ isUploading: false, progress: 0 }"
                                                x-on:livewire-upload-start="isUploading = true"
                                                x-on:livewire-upload-finish="isUploading = false"
                                                x-on:livewire-upload-error="isUploading = false"
                                                x-on:livewire-upload-progress="progress = $event.detail.progress">
                                                <input
                                                    class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-contrast3 file:text-white file:cursor-pointer hover:file:bg-blue-700 @error('pagosPension.' . $index . '.comprobante') border-red-500 @enderror"
                                                    type="file"
                                                    wire:model="pagosPension.{{ $index }}.comprobante"
                                                    accept="image/*">

                                                {{-- Mostrar nombre de archivo si ya está cargado --}}
                                                @if (isset($pagosPension[$index]['comprobante']) && $pagosPension[$index]['comprobante'])
                                                    <p class="text-xs text-green-600 mt-1">
                                                        <i class="fas fa-check mr-1"></i>
                                                        {{ $pagosPension[$index]['comprobante']->getClientOriginalName() }}
                                                    </p>
                                                @endif

                                                {{-- Loader con barra de progreso --}}
                                                <div x-show="isUploading" class="mt-2">
                                                    <progress max="100" x-bind:value="progress"
                                                        class="w-full h-2 rounded bg-gray-200"></progress>
                                                    <p class="text-xs text-blue-600 mt-1">
                                                        <i class="fas fa-spinner fa-spin mr-1"></i>
                                                        Subiendo... <span x-text="progress + '%'"></span>
                                                    </p>
                                                </div>

                                                @error('pagosPension.' . $index . '.comprobante')
                                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Resumen -->
                        @if (count($pagosPension) > 0)
                            <div class="bg-gray-50 rounded-lg p-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-semibold text-gray-700">Total a registrar:</span>
                                    <span class="text-2xl font-bold text-primary">
                                        S./ {{ number_format(collect($pagosPension)->sum('monto'), 2) }}
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600 mt-2">{{ count($pagosPension) }} mes(es)
                                    seleccionado(s)</p>
                            </div>
                        @endif

                        <div class="flex justify-between items-center pt-6 border-t">
                            <button type="button" wire:click="goToStep(2)"
                                class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-300">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="submit" wire:loading.remove
                                class="px-8 py-3 bg-gradient-to-r from-contrast3 to-blue-700 text-white rounded-lg font-semibold hover:scale-105 transition-all duration-300 shadow-lg">
                                Registrar pagos <i class="fas fa-check ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @elseif($step == 4)
            <!-- Paso 4: Finalizado -->
            <div class="bg-white rounded-xl p-8 shadow-md text-center space-y-6 animate-fade-in">
                <div
                    class="w-20 h-20 bg-gradient-to-r from-green-500 to-green-700 text-white flex items-center justify-center rounded-full mx-auto shadow-lg">
                    <i class="fas fa-check text-3xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-gray-800">¡Pago Registrado!</h2>
                <p class="text-gray-600 max-w-md mx-auto">
                    Su pago ha sido registrado exitosamente. Pronto verificaremos la información y actualizaremos su
                    estado de cuenta.
                </p>
                <div class="flex justify-center space-x-4">
                    <button wire:click="nuevoPago"
                        class="px-6 py-3 bg-primary text-white rounded-lg hover:bg-red-700 transition-all duration-300">
                        <i class="fas fa-plus mr-2"></i> Nuevo Pago
                    </button>
                    <a href="{{ route('principal') }}"
                        class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-all duration-300">
                        <i class="fas fa-home mr-2"></i> Inicio
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('paso:tres:pago', () => {
                // Inicializar Pikaday para fecha de pago
                if (document.getElementById('fecha-pago')) {
                    new Pikaday({
                        field: document.getElementById('fecha-pago'),
                        format: 'DD/MM/YYYY',
                        yearRange: [1990, 2026],
                        i18n: {
                            previousMonth: 'Mes Anterior',
                            nextMonth: 'Siguiente Mes',
                            months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio',
                                'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                            ],
                            weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves',
                                'Viernes', 'Sábado'
                            ],
                            weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb']
                        },
                        toString(date, format) {
                            var day = date.getDate();
                            day = day < 10 ? `0${day}` : day;
                            var month = date.getMonth() + 1;
                            month = month < 10 ? `0${month}` : month;
                            const year = date.getFullYear();
                            return `${day}/${month}/${year}`;
                        },
                    });
                }

                // Inicializar Cleave para formato de monto
                if (document.getElementById('monto-pago')) {
                    new Cleave('#monto-pago', {
                        numeral: true,
                        decimal: true,
                        numeralThousandsGroupStyle: 'thousand'
                    });
                }
            });

            // Función para convertir texto a mayúsculas
            window.mayus = function(e) {
                e.value = e.value.toUpperCase();
            }
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pattern-bg {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(139, 39, 36, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(47, 128, 237, 0.05) 0%, transparent 50%);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .floating-shapes .shape {
            position: absolute;
            opacity: 0.1;
            pointer-events: none;
        }

        .icon-bounce:hover {
            animation: bounce 0.6s ease-out;
        }

        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            40%,
            43% {
                transform: translate3d(0, -8px, 0);
            }

            70% {
                transform: translate3d(0, -4px, 0);
            }

            90% {
                transform: translate3d(0, -2px, 0);
            }
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .institutional-shadow {
            box-shadow: 0 4px 6px -1px rgba(139, 39, 36, 0.1), 0 2px 4px -1px rgba(139, 39, 36, 0.06);
        }
    </style>
@endpush

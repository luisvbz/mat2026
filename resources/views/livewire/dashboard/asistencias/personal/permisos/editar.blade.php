<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-5xl mx-auto space-y-6">

    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center mr-4">
                    <i class="ph-fill ph-pencil-simple text-2xl"></i>
                </span>
                Editar Permiso de Personal
            </h1>
            <p class="text-gray-800 text-sm mt-1 ml-16">Modifica la información de un permiso existente.</p>
        </div>
        <div>
            <a href="{{ route('permisos-profesores.index') }}"
                class="inline-flex flex-row items-center text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white px-4 py-2 rounded-lg border border-gray-300 shadow-sm transition-colors">
                <i class="ph-bold ph-arrow-left mr-2"></i> Regresar
            </a>
        </div>
    </div>

    {{-- Formulario --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form wire:submit.prevent="guardarPermiso" class="space-y-6">

                {{-- Sección 1: Selección de Personal --}}
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-300 mb-6">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center">
                        <i class="ph-fill ph-user-circle mr-2 text-blue-500 text-lg"></i> 1. Selección de Colaborador
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="lg:col-span-2 space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Colaborador</label>
                            <select wire:model="profesor"
                                class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('profesor') border-red-500 ring-1 ring-red-500 @enderror">
                                <option value="">Seleccione el personal</option>
                                @foreach ($profesores as $p)
                                    <option value="{{ $p->id }}">{{ $p->apellidos }}, {{ $p->nombres }}
                                    </option>
                                @endforeach
                            </select>
                            @error('profesor')
                                <p class="text-xs text-red-500 mt-1"><i
                                        class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección 2: Detalles del Permiso --}}
                <div class="bg-gray-50 rounded-lg p-5 border border-gray-300 mb-6">
                    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-4 flex items-center">
                        <i class="ph-fill ph-calendar-plus mr-2 text-blue-500 text-lg"></i> 2. Detalles del Permiso
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <div class="md:col-span-4 space-y-1">
                            <label class="block text-sm font-medium text-gray-700">Tipo de permiso</label>
                            <select wire:model="tipo"
                                class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('tipo') border-red-500 ring-1 ring-red-500 @enderror">
                                <option value="">Seleccione el tipo</option>
                                <option value="E">Entrada Tarde</option>
                                <option value="S">Salida Temprana</option>
                                <option value="SS">Falta Justificada</option>
                            </select>
                            @error('tipo')
                                <p class="text-xs text-red-500 mt-1"><i
                                        class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Conditional Fields based on Tipo --}}
                        <div class="md:col-span-8">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                @if ($tipo == 'E')
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Fecha</label>
                                        <input type="date" min="{{ date('Y-m-d') }}" wire:model.defer="hasta"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('hasta') border-red-500 ring-1 ring-red-500 @enderror" />
                                        @error('hasta')
                                            <p class="text-xs text-red-500 mt-1"><i
                                                    class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Hora de llegada
                                            estimada</label>
                                        <input type="time" wire:model.defer="hasta_hora"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('hasta_hora') border-red-500 ring-1 ring-red-500 @enderror" />
                                        @error('hasta_hora')
                                            <p class="text-xs text-red-500 mt-1"><i
                                                    class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif($tipo == 'S')
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Fecha</label>
                                        <input type="date" min="{{ date('Y-m-d') }}" wire:model.defer="desde"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('desde') border-red-500 ring-1 ring-red-500 @enderror" />
                                        @error('desde')
                                            <p class="text-xs text-red-500 mt-1"><i
                                                    class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Hora de salida</label>
                                        <input type="time" wire:model.defer="desde_hora"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('desde_hora') border-red-500 ring-1 ring-red-500 @enderror" />
                                        @error('desde_hora')
                                            <p class="text-xs text-red-500 mt-1"><i
                                                    class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                @elseif($tipo == 'SS')
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Fecha Desde</label>
                                        <input type="date" min="{{ date('Y-m-d') }}" wire:model.defer="desde"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('desde') border-red-500 ring-1 ring-red-500 @enderror" />
                                        @error('desde')
                                            <p class="text-xs text-red-500 mt-1"><i
                                                    class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="space-y-1">
                                        <label class="block text-sm font-medium text-gray-700">Fecha Hasta</label>
                                        <input type="date" min="{{ date('Y-m-d') }}" wire:model.defer="hasta"
                                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('hasta') border-red-500 ring-1 ring-red-500 @enderror" />
                                        @error('hasta')
                                            <p class="text-xs text-red-500 mt-1"><i
                                                    class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                                        @enderror
                                    </div>
                                @else
                                    <div
                                        class="col-span-2 flex items-center justify-center p-4 bg-white border border-dashed border-gray-300 rounded-lg">
                                        <p class="text-gray-800 text-sm"><i class="ph-fill ph-info mr-1"></i> Seleccione
                                            un tipo de permiso para ver las opciones de fecha y hora.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 space-y-1">
                        <label class="block text-sm font-medium text-gray-700">Motivo del Permiso /
                            Observaciones</label>
                        <textarea wire:model.defer="motivo" rows="3"
                            placeholder="Explique brevemente el motivo de este permiso para el colaborador..."
                            class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('motivo') border-red-500 ring-1 ring-red-500 @enderror"></textarea>
                        @error('motivo')
                            <p class="text-xs text-red-500 mt-1"><i
                                    class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Acciones --}}
                <div class="flex justify-end pt-4 border-t border-gray-300">
                    <button type="submit"
                        class="inline-flex justify-center items-center px-6 py-2.5 bg-colegio-600 border border-transparent rounded-lg font-medium text-white hover:bg-colegio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-colors shadow-sm text-sm">
                        <i class="ph-bold ph-floppy-disk mr-2 text-lg"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

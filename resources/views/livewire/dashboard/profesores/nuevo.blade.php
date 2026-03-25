<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-user-plus text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Nuevo Profesor</h1>
                <p class="text-sm text-gray-500">Registrar un nuevo integrante al personal</p>
            </div>
        </div>
        <a href="{{ route('dashboard.profesores') }}"
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors shadow-sm">
            <i class="ph ph-arrow-left mr-2"></i> Volver a la lista
        </a>
    </div>

    <livewire:commons.mod-profesor />

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form wire:submit.prevent="save" class="space-y-8">
                {{-- Sección: Información Personal --}}
                <div>
                    <div class="flex items-center gap-2 mb-6 pb-2 border-b border-gray-100">
                        <i class="ph-fill ph-identification-card text-colegio-500 text-lg"></i>
                        <h2 class="font-bold text-gray-800 uppercase tracking-wider text-xs">Información Personal</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">Nombres <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model="nombres"
                                class="block w-full px-4 py-2.5 border {{ $errors->has('nombres') ? 'border-red-300 ring-red-50' : 'border-gray-200 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl sm:text-sm transition-all bg-gray-50/30"
                                placeholder="Ej. Juan Andrés">
                            @error('nombres')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">Apellidos <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model="apellidos"
                                class="block w-full px-4 py-2.5 border {{ $errors->has('apellidos') ? 'border-red-300 ring-red-50' : 'border-gray-200 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl sm:text-sm transition-all bg-gray-50/30"
                                placeholder="Ej. Pérez García">
                            @error('apellidos')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">Documento (DNI) <span
                                    class="text-red-500">*</span></label>
                            <input type="text" wire:model="documento"
                                class="block w-full px-4 py-2.5 border {{ $errors->has('documento') ? 'border-red-300 ring-red-50' : 'border-gray-200 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl sm:text-sm transition-all bg-gray-50/30"
                                placeholder="8 dígitos">
                            <p class="text-[11px] text-gray-400 mt-1 italic">Este será usado como usuario y contraseña
                                inicial.</p>
                            @error('documento')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección: Contacto y Gestión --}}
                <div>
                    <div class="flex items-center gap-2 mb-6 pb-2 border-b border-gray-100">
                        <i class="ph-fill ph-phone-call text-colegio-500 text-lg"></i>
                        <h2 class="font-bold text-gray-800 uppercase tracking-wider text-xs">Contacto y Gestión</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">Correo Electrónico</label>
                            <input type="email" wire:model="correo"
                                class="block w-full px-4 py-2.5 border {{ $errors->has('correo') ? 'border-red-300 ring-red-50' : 'border-gray-200 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl sm:text-sm transition-all bg-gray-50/30"
                                placeholder="correo@ejemplo.com">
                            @error('correo')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">Teléfono / Celular</label>
                            <input type="text" wire:model="telefono"
                                class="block w-full px-4 py-2.5 border {{ $errors->has('telefono') ? 'border-red-300 ring-red-50' : 'border-gray-200 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl sm:text-sm transition-all bg-gray-50/30"
                                placeholder="9XXXXXXXX">
                            @error('telefono')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-sm font-semibold text-gray-700">Horario Asignado <span
                                    class="text-red-500">*</span></label>
                            <div class="relative">
                                <select wire:model="horario_id"
                                    class="block w-full px-4 py-2.5 border {{ $errors->has('horario_id') ? 'border-red-300 ring-red-50' : 'border-gray-200 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl sm:text-sm transition-all bg-gray-50/30 appearance-none">
                                    <option value="">Seleccione horario...</option>
                                    @foreach ($horarios as $horario)
                                        <option value="{{ $horario->id }}">{{ $horario->name }}</option>
                                    @endforeach
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                                    <i class="ph ph-caret-down"></i>
                                </div>
                            </div>
                            @error('horario_id')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('dashboard.profesores') }}"
                        class="px-6 py-2.5 border border-gray-200 rounded-xl text-sm font-bold text-gray-500 hover:bg-gray-50 transition-all uppercase tracking-widest">
                        Cancelar
                    </a>
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-8 py-2.5 bg-colegio-600 text-white rounded-xl text-sm font-bold hover:bg-colegio-700 transition-all shadow-lg shadow-colegio-200 flex items-center gap-2 uppercase tracking-widest disabled:opacity-50">
                        <span wire:loading.remove>Guardar Registro</span>
                        <span wire:loading class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Procesando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

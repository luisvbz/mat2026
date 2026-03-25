<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-calendar-plus text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Nuevo Evento</h1>
                <p class="text-sm text-gray-500 font-medium">Publicar una nueva actividad en la cartelera</p>
            </div>
        </div>
        <a href="{{ route('dashboard.eventos') }}"
            class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors shadow-sm font-bold uppercase tracking-widest text-[10px]">
            <i class="ph ph-arrow-left mr-2 text-base font-bold"></i> Volver a la lista
        </a>
    </div>

    <livewire:commons.mod-eventos />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form wire:submit.prevent="save" class="space-y-8">
                {{-- Sección: Datos del Evento --}}
                <div>
                    <div class="flex items-center gap-2 mb-6 pb-2 border-b border-gray-50">
                        <i class="ph-fill ph-info text-colegio-500 text-lg"></i>
                        <h2 class="font-bold text-gray-800 uppercase tracking-widest text-[10px]">Información General
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Fecha
                                del Evento <span class="text-red-500">*</span></label>
                            <input type="date" wire:model="date"
                                class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('date') ? 'border-red-300 ring-red-50' : 'border-gray-100 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl text-sm font-bold text-gray-700 transition-all shadow-inner">
                            @error('date')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Hora
                                <span class="text-red-500">*</span></label>
                            <input type="time" wire:model="time"
                                class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('time') ? 'border-red-300 ring-red-50' : 'border-gray-100 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl text-sm font-bold text-gray-700 transition-all shadow-inner">
                            @error('time')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Descripción
                                del Evento <span class="text-red-500">*</span></label>
                            <textarea wire:model="description" rows="3"
                                class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('description') ? 'border-red-300 ring-red-50' : 'border-gray-100 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl text-sm font-bold text-gray-700 transition-all shadow-inner"
                                placeholder="Describa el evento o aviso..."></textarea>
                            @error('description')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Sección: Recursos Adicionales --}}
                <div>
                    <div class="flex items-center gap-2 mb-6 pb-2 border-b border-gray-50">
                        <i class="ph-fill ph-paperclip text-colegio-500 text-lg"></i>
                        <h2 class="font-bold text-gray-800 uppercase tracking-widest text-[10px]">Recursos y Enlaces
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-1.5 relative">
                            <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Tipo
                                de Evento <span class="text-red-500">*</span></label>
                            <select wire:model="type"
                                class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('type') ? 'border-red-300 ring-red-50' : 'border-gray-100 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl text-sm font-bold text-gray-700 transition-all shadow-inner appearance-none">
                                <option value="actividad">Actividad</option>
                                <option value="anuncio">Anuncio / Aviso</option>
                                <option value="reunion">Reunión</option>
                                <option value="otro">Otro</option>
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400 pt-5">
                                <i class="ph ph-caret-down font-bold"></i>
                            </div>
                            @error('type')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Enlace
                                Externo (URL)</label>
                            <input type="url" wire:model="link"
                                class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('link') ? 'border-red-300 ring-red-50' : 'border-gray-100 focus:ring-colegio-500 focus:border-colegio-500' }} rounded-xl text-sm font-bold text-gray-700 transition-all shadow-inner"
                                placeholder="https://ejemplo.com/evento">
                            @error('link')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-1.5 md:col-span-2">
                            <label
                                class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Archivo
                                Adjunto (PDF, Imagen, etc.)</label>
                            <div class="relative group">
                                <input type="file" wire:model="attachment"
                                    class="block w-full text-sm font-bold text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-[10px] file:font-bold file:uppercase file:tracking-widest file:bg-colegio-50 file:text-colegio-700 hover:file:bg-colegio-100 transition-all bg-gray-50 border border-gray-100 rounded-xl cursor-pointer">
                                <div wire:loading wire:target="attachment"
                                    class="absolute top-1/2 -translate-y-1/2 right-4">
                                    <i class="ph ph-spinner-gap animate-spin text-colegio-600 text-xl font-bold"></i>
                                </div>
                            </div>
                            <p class="text-[10px] text-gray-400 italic mt-1 ml-1 font-medium italic">Máximo 10MB.</p>
                            @error('attachment')
                                <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-6 border-t border-gray-100 flex justify-end gap-3">
                    <button type="button" wire:click="cancel"
                        class="px-8 py-3 bg-white border border-gray-200 rounded-xl text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:bg-gray-50 transition-all shadow-sm">
                        Cancelar
                    </button>
                    <button type="submit" wire:loading.attr="disabled"
                        class="px-10 py-3 bg-colegio-600 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-colegio-700 transition-all shadow-lg shadow-colegio-100 disabled:opacity-50">
                        <span wire:loading.remove>Guardar Evento</span>
                        <span wire:loading class="flex items-center gap-2">
                            <i class="ph ph-spinner-gap animate-spin text-lg font-bold"></i> Procesando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

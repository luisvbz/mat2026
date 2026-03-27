<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto relative">
    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="save"
        class="fixed inset-0 z-50 bg-white/70 backdrop-blur-sm flex-col items-center justify-center hidden">
        <div class="animate-spin text-colegio-500 mb-4">
            <i class="ph ph-circle-notch text-5xl"></i>
        </div>
        <div class="text-lg font-semibold text-gray-700 animate-pulse">
            Guardando...
        </div>
    </div>

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <div
            class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-300 flex items-center justify-center text-colegio-600">
            <i class="ph-fill ph-megaphone text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Nuevo Comunicado</h1>
            <p class="text-sm text-gray-800">Comunica información importante a la comunidad educativa.</p>
        </div>
    </div>

    {{-- Form Container --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-6 md:p-8 space-y-6">

        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Título <span class="text-red-500">*</span></label>
            <input wire:model="title" type="text" placeholder="Ej. Invitación a reunión de padres"
                class="block w-full px-3 py-2 rounded-lg border-gray-300 shadow-sm focus:border-colegio-500 focus:ring-colegio-500 sm:text-sm @error('title') border-red-500 ring-red-500 @enderror">
            @error('title')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-1">
            <label class="block text-sm font-medium text-gray-700">Contenido <span class="text-red-500">*</span></label>
            <div wire:ignore class="trix-wrapper">
                <input id="trix-content" type="hidden" name="content">
                <trix-editor input="trix-content"
                    class="trix-content min-h-[250px] bg-white rounded-b-lg border border-gray-300 shadow-sm focus:border-colegio-500 focus:ring-colegio-500 mt-0 @error('content') border-red-500 ring-red-500 @enderror"></trix-editor>
            </div>
            @error('content')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Categoría <span
                        class="text-red-500">*</span></label>
                <select wire:model="category"
                    class="block w-full pl-3 pr-10 py-2 rounded-lg border-gray-300 shadow-sm focus:border-colegio-500 focus:ring-colegio-500 sm:text-sm @error('category') border-red-500 @enderror">
                    <option value="general">General</option>
                    <option value="academico">Académico</option>
                    <option value="administrativo">Administrativo</option>
                    <option value="evento">Evento</option>
                    <option value="urgente">Urgente</option>
                    <option value="cobro">Cobro</option>
                    <option value="actividad">Actividad</option>
                    <option value="otro">Otro</option>
                </select>
                @error('category')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Fecha de Publicación</label>
                <input wire:model="published_at" type="date"
                    class="block w-full px-3 py-2 rounded-lg border-gray-300 shadow-sm focus:border-colegio-500 focus:ring-colegio-500 sm:text-sm">
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-gray-700">Publicado por <span
                        class="text-red-500">*</span></label>
                <select wire:model="publisher"
                    class="block w-full pl-3 pr-10 py-2 rounded-lg border-gray-300 shadow-sm focus:border-colegio-500 focus:ring-colegio-500 sm:text-sm @error('publisher') border-red-500 @enderror">
                    <option value="Dirección">Dirección</option>
                    <option value="Coordinación Académica">Coordinación Académica</option>
                    <option value="Coordinación Administrativa">Coordinación Administrativa</option>
                    <option value="Secretaria">Secretaria</option>
                </select>
                @error('publisher')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="p-4 bg-gray-50 rounded-lg border border-gray-300">
            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" wire:model="is_published"
                    class="form-checkbox h-5 w-5 text-colegio-600 rounded border-gray-300 focus:ring-colegio-500 transition duration-150 ease-in-out">
                <span class="text-sm font-medium text-gray-800">Publicar inmediatamente al guardar</span>
            </label>
        </div>

        <div class="space-y-2">
            <label class="block text-sm font-medium text-gray-700">Archivos Adjuntos</label>
            <div class="flex items-center justify-center w-full">
                <label
                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed rounded-lg cursor-pointer bg-gray-50 border-gray-300 hover:bg-gray-100 focus:outline-none transition-colors">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <i class="ph ph-upload-simple text-3xl text-gray-800 mb-2"></i>
                        <p class="mb-1 text-sm text-gray-800"><span class="font-semibold">Haz clic para buscar</span> o
                            arrastra los archivos</p>
                        <p class="text-xs text-gray-800">Archivos múltiples, máximo 10MB por archivo.</p>
                    </div>
                    <input type="file" wire:model="attachments" multiple class="hidden" />
                </label>
            </div>

            @if (!empty($attachments))
                <div class="mt-2 flex items-center gap-2 text-sm text-colegio-600 font-medium">
                    <i class="ph-fill ph-check-circle"></i> {{ count($attachments) }} archivo(s) seleccionado(s) listos
                    para subir.
                </div>
            @endif

            @error('attachments.*')
                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="pt-6 border-t border-gray-300 flex flex-col sm:flex-row gap-3 justify-end">
            <button wire:click="cancel" type="button"
                class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                <i class="ph ph-x mr-2"></i> Cancelar
            </button>
            <button wire:click="save" type="button"
                class="inline-flex items-center justify-center px-6 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-colegio-600 hover:bg-colegio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-colors">
                <i class="ph ph-floppy-disk mr-2"></i> Guardar Comunicado
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var trixEditor = document.querySelector("trix-editor");

            if (trixEditor) {
                trixEditor.addEventListener("trix-change", function(event) {
                    @this.set('content', trixEditor.value);
                });
            }
        });
    </script>
@endpush

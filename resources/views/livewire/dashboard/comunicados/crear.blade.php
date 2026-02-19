<div class="content-dashboard">
    {{-- Loading overlay --}}
    <div class="loading-matricula" wire:loading wire:target="save" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}" />
            </div>
            <div class="mensaje">
                Guardando.....
            </div>
        </div>
    </div>

    {{-- Header --}}
    <div class="content-dashboard-header">
        <div><i class="fas fa-bullhorn"></i> Nuevo Comunicado</div>
    </div>

    {{-- Form --}}
    <div class="box-content content-dashboard-content">
        <div class="field">
            <label class="label">Título <span class="has-text-danger">*</span></label>
            <div class="control">
                <input wire:model="title" class="input @error('title') is-danger @enderror" type="text"
                    placeholder="Título del comunicado">
            </div>
            @error('title')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label">Contenido <span class="has-text-danger">*</span></label>
            <div class="control" wire:ignore>
                <input id="trix-content" type="hidden" name="content">
                <trix-editor input="trix-content" class="@error('content') is-danger @enderror"></trix-editor>
            </div>
            @error('content')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="columns">
            <div class="column">
                <div class="field">
                    <label class="label">Categoría <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select wire:model="category">
                                <option value="general">General</option>
                                <option value="academico">Académico</option>
                                <option value="administrativo">Administrativo</option>
                                <option value="evento">Evento</option>
                                <option value="urgente">Urgente</option>
                                <option value="cobro">Cobro</option>
                                <option value="actividad">Actividad</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    @error('category')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Fecha de Publicación</label>
                    <div class="control">
                        <input wire:model="published_at" class="input" type="date">
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="field">
                    <label class="label">Publicado por <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select wire:model="publisher">
                                <option value="Dirección">Dirección</option>
                                <option value="Coordinación Académica">Coordinación Académica</option>
                                <option value="Coordinación Administrativa">Coordinación Administrativa</option>
                                <option value="Secretaria">Secretaria</option>
                            </select>
                        </div>
                    </div>
                    @error('publisher')
                        <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="field">
            <div class="control">
                <label class="checkbox">
                    <input type="checkbox" wire:model="is_published">
                    Publicar inmediatamente
                </label>
            </div>
        </div>

        <div class="field">
            <label class="label">Archivos Adjuntos</label>
            <div class="control">
                <div class="file has-name is-fullwidth">
                    <label class="file-label">
                        <input class="file-input" type="file" wire:model="attachments" multiple>
                        <span class="file-cta">
                            <span class="file-icon">
                                <i class="fas fa-upload"></i>
                            </span>
                            <span class="file-label">
                                Seleccionar archivos...
                            </span>
                        </span>
                        <span class="file-name">
                            @if (!empty($attachments))
                                {{ count($attachments) }} archivo(s) seleccionado(s)
                            @else
                                Ningún archivo seleccionado
                            @endif
                        </span>
                    </label>
                </div>
                <p class="help">Máximo 10MB por archivo. Puedes seleccionar múltiples archivos.</p>
            </div>
            @error('attachments.*')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field is-grouped mt-5">
            <div class="control">
                <button wire:click="save" class="button is-success">
                    <i class="fas fa-save mr-2"></i> Guardar Comunicado
                </button>
            </div>
            <div class="control">
                <button wire:click="cancel" class="button">
                    <i class="fas fa-times mr-2"></i> Cancelar
                </button>
            </div>
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

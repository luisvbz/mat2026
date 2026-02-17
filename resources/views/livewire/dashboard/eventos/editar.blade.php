<div class="content-dashboard">
    {{-- Header --}}
    <div class="content-dashboard-header">
        <div><i class="fas fa-edit"></i> Editar Evento</div>
    </div>

    <div class="box-content content-dashboard-content">
        <form wire:submit.prevent="save">
            <div class="columns is-multiline">
                <div class="column is-6">
                    <div class="field">
                        <label class="label">Fecha <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <input wire:model="date" class="input @error('date') is-danger @enderror" type="date">
                        </div>
                        @error('date')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column is-6">
                    <div class="field">
                        <label class="label">Hora <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <input wire:model="time" class="input @error('time') is-danger @enderror" type="time">
                        </div>
                        @error('time')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column is-12">
                    <div class="field">
                        <label class="label">Tipo de Evento <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <div class="select is-fullwidth @error('type') is-danger @enderror">
                                <select wire:model="type">
                                    <option value="actividad">Actividad</option>
                                    <option value="anuncio">Anuncio</option>
                                    <option value="urgente">Urgente</option>
                                    <option value="otro">Otro</option>
                                </select>
                            </div>
                        </div>
                        @error('type')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column is-12">
                    <div class="field">
                        <label class="label">Descripción <span class="has-text-danger">*</span></label>
                        <div class="control">
                            <textarea wire:model="description" class="textarea @error('description') is-danger @enderror"
                                placeholder="Describe el evento..." rows="4"></textarea>
                        </div>
                        @error('description')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column is-12">
                    <div class="field">
                        <label class="label">Enlace (Opcional)</label>
                        <div class="control has-icons-left">
                            <input wire:model="link" class="input @error('link') is-danger @enderror" type="url"
                                placeholder="https://ejemplo.com">
                            <span class="icon is-small is-left">
                                <i class="fas fa-link"></i>
                            </span>
                        </div>
                        @error('link')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="column is-12">
                    <div class="field">
                        <label class="label">Archivo Adjunto (Opcional)</label>
                        @if ($currentAttachment)
                            <div class="notification is-light py-2 px-3 mb-3">
                                <div class="columns is-vcentered is-mobile">
                                    <div class="column is-narrow">
                                        <i class="fas fa-file-alt fa-2x has-text-primary"></i>
                                    </div>
                                    <div class="column">
                                        <p class="is-size-7 has-text-grey mb-1">Archivo actual:</p>
                                        <a href="{{ asset($currentAttachment) }}" target="_blank"
                                            class="has-text-link font-weight-bold">
                                            <i class="fas fa-external-link-alt mr-1"></i> Ver archivo actual
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="file has-name is-fullwidth">
                            <label class="file-label">
                                <input wire:model="attachment" class="file-input" type="file">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">
                                        Cambiar archivo…
                                    </span>
                                </span>
                                <span class="file-name">
                                    {{ $attachment ? $attachment->getClientOriginalName() : 'Selecciona un nuevo archivo para reemplazar el anterior' }}
                                </span>
                            </label>
                        </div>
                        <div wire:loading wire:target="attachment" class="mt-2">
                            <span class="tag is-info is-light">
                                <i class="fas fa-spinner fa-spin mr-2"></i> Subiendo archivo...
                            </span>
                        </div>
                        @error('attachment')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-5 border-top d-flex justify-content-end" style="border-top: 1px solid #eee;">
                <button type="button" wire:click="cancel" class="button is-light mr-3">
                    Cancelar
                </button>
                <button type="submit" class="button is-info px-5">
                    <span wire:loading.remove wire:target="save">Actualizar Evento</span>
                    <span wire:loading wire:target="save"><i class="fas fa-spinner fa-spin mr-2"></i>
                        Actualizando...</span>
                </button>
            </div>
        </form>
    </div>
</div>

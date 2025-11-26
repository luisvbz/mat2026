@section('title')
    Solicitud de Documentos
@endsection
<div class="container" style="padding-bottom: 50px">
    <div class="loading-matricula"  wire:loading wire:target="enviarSolicitud" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}"/>
            </div>
            <div class="mensaje">
                Procesando.....
            </div>
        </div>
    </div>
    <div class="form-container">
        <form wire:submit.prevent="enviarSolicitud">
            <div class="contenedor-formularios">
                <p class="has-text-weight-bold">Llene todos los datos para enviar una solicitud de documentos. Al momento de recibirla se le estaran enviando en el transcurso de 7 dias hábiles</p>
                <hr>
                <div class="separador-form">Datos del Solicitante</div>
                <div class="field">
                    <div class="columns">
                        <div class="column is-3-desktop">
                            <label class="label">Tipo de documento</label>
                            <div class="select is-fullwidth @error('form.tipo_ducumento_solicitante') is-danger @enderror">
                                <select wire:model.debounce.500ms="form.tipo_ducumento_solicitante">
                                    <option value="0">DNI</option>
                                    <option value="1">CE</option>
                                    <option value="2">PTP</option>
                                    <option value="3">Partida de Nac.</option>
                                </select>
                                @error('form.tipo_ducumento_solicitante')
                                <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="column is-3-desktop">
                            <label class="label">Numero de Documento</label>
                            <div class="control">
                                <input type="text" wire:model.debounce.500ms="form.numero_documento_solicitante" class="input @error('form.numero_documento_solicitante') is-danger @enderror" />
                                @error('form.numero_documento_solicitante')
                                <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="column">
                            <label class="label">Nombre Completo</label>
                            <div class="control">
                                <input type="text" wire:model.debounce.500ms="form.nombre_solicitante" class="input @error('form.nombre_solicitante') is-danger @enderror" />
                                @error('form.nombre_solicitante')
                                <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="columns">
                        <div class="column">
                            <label class="label">Telefono Celular</label>
                            <div class="control">
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="form.telefono_celular" class="input @error('form.telefono_celular') is-danger @enderror" />
                                @error('form.telefono_celular')
                                <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="column">
                            <label class="label">Correo electrónico</label>
                            <div class="control">
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="form.correo_electronico" class="input @error('form.correo_electronico') is-danger @enderror" />
                                @error('form.correo_electronico')
                                <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="field ml-1">
                    <label class="checkbox">
                        <input wire:model="form.is_apoderado" type="checkbox">
                        Marque esta casilla si usted es un apoderado.
                    </label>
                </div>
                @if($form['is_apoderado'])
                    <div class="separador-form">Datos del Estudiante</div>
                    <div class="field">
                        <div class="columns">
                            <div class="column is-3-desktop">
                                <label class="label">Tipo de documento</label>
                                <div class="select is-fullwidth @error('form.tipo_documento_alumno') is-danger @enderror">
                                    <select wire:model.debounce.500ms="form.tipo_documento_alumno">
                                        <option value="0">DNI</option>
                                        <option value="1">CE</option>
                                        <option value="2">PTP</option>
                                        <option value="3">Partida de Nac.</option>
                                    </select>
                                    @error('form.tipo_documento_alumno')
                                    <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="column is-3-desktop">
                                <label class="label">Numero de Documento</label>
                                <div class="control">
                                    <input type="text" wire:model.debounce.500ms="form.numero_documento_alumno" class="input @error('form.numero_documento_solicitante') is-danger @enderror" />
                                    @error('form.numero_documento_alumno')
                                    <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="column">
                                <label class="label">Nombre Completo</label>
                                <div class="control">
                                    <input type="text" wire:model.debounce.500ms="form.nombre_alumno" class="input @error('form.nombre_alumno') is-danger @enderror" />
                                    @error('form.nombre_alumno')
                                    <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="separador-form">Documentos a Solicitar (Seleecione los documentos a solicitar)</div>
                @foreach ($tipos as $tipo)
                <div class="field ml-1">
                    <label class="checkbox">
                        <input wire:model="form.documentos" value="{{ $tipo->id}}" type="checkbox">
                        {{ $tipo->nombre }}
                    </label>
                </div>
                @endforeach
                @error('form.documentos')
                <p class="has-text-danger">{{ $message }}</p>
                @enderror
                <div class="separador-form">Adjuntar voucher de pago</div>
                <div class="field">
                    <div class="columns">
                    <div class="column">
                        <div class="file @if($form['archivo'] != null) has-name @endif">
                        <label class="file-label">
                            <input class="file-input" type="file" name="resume" wire:model="form.archivo">
                            <span class="file-cta">
                                                <span class="file-icon">
                                                <i class="fas fa-upload"></i>
                                                </span>
                                                <span class="file-label">
                                                Seleccione el archivo
                                                </span>
                                            </span>
                            @if($form['archivo']  != null)
                            <span class="file-name">
                                                {{ $form['archivo']->getClientOriginalName() }}
                                            </span>
                            @endif
                        </label>
                        </div>
                        @error("form.archivo")
                        <p class="has-text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="column" wire:loading wire:target="form.archivo">
                        <div>Subiendo archivo <i class="fas fa-spinner fa-spin"></i> ...</div>
                    </div>
                    </div>
                </div>
                <hr>
                <div class="field has-text-centered">
                    <button type="submit"
                            wire:loading.remove
                            class="button is-primary">Enviar Solicitud <i class="fas fa-paper-plane ml-2"></i></button>
                </div>
            </div>
        </form>
    </div>
</div>
{{--@push('js')
@endpush--}}

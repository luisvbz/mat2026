@section('title')
    Reservar Citar
@endsection
<div class="container" style="padding-bottom: 50px" x-data="{modalidad: @entangle('form.modalidad')}">
    <div class="loading-matricula"  wire:loading wire:target="reservar" style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}"/>
            </div>
            <div class="mensaje">
                Reservando cita, por favor espere.....
            </div>
        </div>
    </div>
    <div class="form-container">
        <div class="step-formulario">
            <ul class="steps has-content-centered is-balanced">
                <li class="steps-segment @if($step == 1) is-active @endif" style="margin-top: 4px;">
                    <span class="steps-marker">
                        @if($step <= 1) 1 @else <i class="fas fa-check-double"></i> @endif
                    </span>
                    <div class="steps-content">
                        <p class="is-size-5">Buscar Matrícula</p>
                    </div>
                </li>
                <li class="steps-segment @if($step == 2) is-active @endif">
                    <span class="steps-marker">
                        @if($step <= 2) 2 @else <i class="fas fa-check-double"></i> @endif
                    </span>
                    <div class="steps-content">
                        <p class="is-size-5">Seleccionar la cita</p>
                    </div>
                </li>
                <li class="steps-segment @if($step == 3) is-active @endif">
                    <span class="steps-marker">
                        @if($step <= 4) 4 @else <i class="fas fa-check-double"></i> @endif
                    </span>
                    <div class="steps-content">
                        <p class="is-size-5">Finalizado</p>
                    </div>
                </li>
            </ul>
        </div>
        <hr>
        <div class="contenedor-formularios">
            @if($step == 1)
                <form wire:submit.prevent="buscarMatricula">
                    <div class="field">
                        <div class="columns is-centered">
                            <div class="column is-4-desktop">
                                <label class="label">DNI del alumno</label>
                                <div class="control">
                                    <input type="text"  id="cod-matricula" class="input  @error('codigo') is-danger @enderror" style="text-align: center;" wire:model.defer="codigo"/>
                                    @error('codigo')
                                    <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <hr>
                                <div class="notification">
                                    Ingrese el DNI del alumno, sin separaciones ni guiones. Tampoco debe agregar el codigo verificador
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="field">
                        <div class="columns">
                            <div class="column has-text-right">
                                <button class="button is-primary">Continuar <i class="fas fa-arrow-alt-circle-right" style="margin-left: 5px;"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            @elseif($step == 2)
                <form wire:submit.prevent="reservar">
                    <div class="field">
                        <div class="matricula-encontrada">
                            <div class="columns is-centered">
                                <div class="column">
                                    <div class="has-text-centered"><strong>Alumno(a)</strong></div>
                                    <div class="has-text-centered">
                                        {{ trim($matricula->alumno->apellido_paterno.' '.$matricula->alumno->apellido_materno.' '.$matricula->alumno->nombres) }}
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="has-text-centered"><strong>Grado</strong></div>
                                    <div class="has-text-centered">
                                        {{ $matricula->grado | grado }}
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="has-text-centered"><strong>Nivel</strong></div>
                                    <div class="has-text-centered">
                                        {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}
                                    </div>
                                </div>
                                <div class="column">
                                    <div class="has-text-centered"><strong>Año Lectivo</strong></div>
                                    <div class="has-text-centered">
                                        {{ $matricula->anio }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="field">
                        <div class="columns">
                            <div class="column">
                                <label class="label">Seleccione el profesor para reservar su cita</label>
                                <div class="select is-fullwidth @error('form.profesor') is-danger @enderror">
                                    <select wire:model="form.profesor">
                                        <option value="" disabled selected>Seleccione el profesor</option>
                                        @foreach($profesores as $profesor)
                                            <option value="{{ $profesor->id }}">{{ $profesor->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @error('form.profesor')
                                        <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column is-6-desktop">
                            <div class="field">
                                <div class="columns">
                                    <div class="column">
                                        <label class="label">Fecha de la cita</label>
                                        <div class="control">
                                            <input type="text" @if(is_null($profe)) disabled @endif autocomplete="off" wire:model.lazy="form.dia" class="input  @error('form.dia') is-danger @enderror" id="fecha"/>
                                        </div>
                                        @error('form.dia')
                                        <p class="has-text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="column">
                                        <label class="label">Hora disponible</label>
                                        <div class="select is-fullwidth @error('form.hora') is-danger @enderror">
                                            <select wire:model="form.hora" @if(sizeof($horas) == 0) disabled @endif>
                                                <option value="">Seleccione la hora</option>
                                                @foreach($horas as $hora)
                                                    <option value="{{ $hora }}">{{ $hora | date:'h:i a' }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('form.hora')
                                            <p class="has-text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="field">
                                <label class="label">Solicitante</label>
                                <div class="control">
                                    <input type="text"  wire:model.debounce.500ms="form.solicitante" class="input  @error('form.solicitante') is-danger @enderror" placeholder="Indique su nombre"/>
                                </div>
                                @error('form.solicitante')
                                    <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="label">Parentesco</label>
                                <div class="control">
                                    <input type="text"  wire:model.debounce.500ms="form.parentesco" class="input  @error('form.parentesco') is-danger @enderror" placeholder="Indique su parentesco con el alumno"/>
                                </div>
                                @error('form.parentesco')
                                <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="field">
                                <label class="label">Modalidad de la Cita</label>
                                <div class="select is-fullwidth  @error('form.modalidad') is-danger @enderror">
                                    <select wire:model="form.modalidad">
                                        <option value="">Seleccione la modalidad</option>
                                        <option value="V">Virtual</option>
                                        <option value="P">Presencial</option>
                                    </select>
                                </div>
                                @error('form.modalidad')
                                    <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div x-show="modalidad == 'V'" class="field">
                                <label class="label">Correo Electrónico</label>
                                <div class="control">
                                    <input type="text"  wire:model.debounce.500ms="form.correo" class="input  @error('form.correo') is-danger @enderror"/>
                                </div>
                                @error('form.correo')
                                    <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div x-show="modalidad == 'V'" class="field">
                                <label class="label">Teléfono Celular</label>
                                <div class="control">
                                    <input type="text"  wire:model.debounce.500ms="form.telefono" class="input  @error('form.telefono') is-danger @enderror"/>
                                </div>
                                @error('form.telefono')
                                    <p class="has-text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{--
                            <div class="field">
                                <div class="form-group">
                                    <div class="text-center mb-2" wire:ignore>
                                        {!! captcha_img('flat'); !!}
                                    </div>
                                    <label><strong>Ingrese el Captcha</strong></label>
                                    <input wire:model.debounce.500ms="form.captcha" type="text"
                                           class="input  @error('form.captcha') is-danger @enderror">
                                    @error('form.captcha')
                                        <p class="has-text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            --}}

                        </div>
                        @if(!is_null($profe))
                            <div class="column is-6-desktop">
                                <div class="notification is-success is-light">
                                    <p class="has-text-centered has-text-weight-medium is-size-4">Horarios de atención</p>
                                    @if($profe->horario->lunes) <li><strong>Lunes: </strong> {{ $profe->horario->lunes_desde | date:'h:i a' }} a {{ $profe->horario->lunes_hasta | date:'h:i a' }}</li>@endif
                                    @if($profe->horario->martes) <li><strong>Martes: </strong> {{ $profe->horario->martes_desde | date:'h:i a' }} a {{ $profe->horario->martes_hasta | date:'h:i a' }}</li>@endif
                                    @if($profe->horario->miercoles) <li><strong>Miercoles: </strong> {{ $profe->horario->miercoles_desde | date:'h:i a' }} a {{ $profe->horario->miercoles_hasta | date:'h:i a' }}</li>@endif
                                    @if($profe->horario->jueves) <li><strong>Jueves: </strong> {{ $profe->horario->jueves_desde | date:'h:i a' }} a {{ $profe->horario->jueves_hasta | date:'h:i a' }}</li>@endif
                                    @if($profe->horario->viernes) <li><strong>Viernes: </strong> {{ $profe->horario->viernes_desde | date:'h:i a' }} a {{ $profe->horario->viernes_hasta | date:'h:i a' }}</li>@endif
                                </div>
                            </div>
                        @else
                            <div class="notification is-success is-light is-flex is-flex-direction-column is-justify-content-center">
                                <p class="has-text-centered has-text-weight-medium is-size-4">Seleccione el profesor para ver los horarios disponibles</p>
                            </div>
                        @endif
                    </div>

                    <div class="field">
                        <div class="columns">
                            <div class="column has-text-right">
                                <button type="submit" class="button is-primary">Reservar Cita <i class="fas fa-arrow-alt-circle-right" style="margin-left: 5px;"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            @elseif($step == 3)

            @endif
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Livewire.on('paso:dos', () => {
                new Pikaday({
                    field: document.getElementById('fecha'),
                    format: 'DD/MM/YYYY',
                    disableWeekends: true,
                    minDate: new Date(),
                    i18n: {
                        previousMonth : 'Mes Anterior',
                        nextMonth     : 'Siguiente Mes',
                        months        : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                        weekdays      : ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
                        weekdaysShort : ['Dom','Lun','Mar','Mi','Ju','Vi','Sa']
                    },
                    toString(date, format) {
                        // you should do formatting based on the passed format,
                        // but we will just return 'D/M/YYYY' for simplicity
                        var day = date.getDate();
                        day = day < 10 ?`0${day}` : day;

                        var month = date.getMonth() + 1;
                        month = month < 10 ?`0${month}` : month;

                        const year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    },
                    onSelect(date)
                    {
                        var day = date.getDate();
                        day = day < 10 ?`0${day}` : day;

                        var month = date.getMonth() + 1;
                        month = month < 10 ?`0${month}` : month;

                        const year = date.getFullYear();
                        var d = `${day}/${month}/${year}`;
                    }
                });
            });
        });

    </script>
@endpush

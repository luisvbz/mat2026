@section('title')
    Consultar Matricula
@endsection
<div class="container" style="padding-bottom: 50px">
    <div class="loading-matricula"  wire:loading wire:target="buscarMatricula" style="display: none;">
        <div class="loading-matricula-body">
            <div class="spinner">
                <img src="{{ asset('images/loader.svg') }}"/>
            </div>
            <div class="mensaje">
                Buscando.....
            </div>
        </div>
    </div>
    <div class="loading-matricula"  wire:loading wire:target="descargarFicha" style="display: none;">
        <div class="loading-matricula-body">
            <div class="spinner">
                <img src="{{ asset('images/loader.svg') }}"/>
            </div>
            <div class="mensaje">
                Generando.....
            </div>
        </div>
    </div>
    <div class="form-container">
        <div class="contenedor-formularios">
            @if($matricula == null)
            <form wire:submit.prevent="buscarMatricula">
                <div class="field">
                    <div class="columns is-centered">
                        <div class="column is-4-desktop">
                            <label class="label">DNI del alumno</label>
                            <div class="control">
                                <input type="text" onkeyup="mayus(this);" id="cod-matricula" class="input  @error('codigo') is-danger @enderror" style="text-align: center;" wire:model.defer="codigo"/>
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
            @else
                <div class="columns">
                    <div class="column">
                        <h4>COD: {{ $matricula->codigo }} <small><a wire:click="descargarFicha">Descargar ficha <i class="fas fa-file-pdf"></i></a></small></h4>
                    </div>
                    <div class="column has-text-right">
                        <h4>{!! $matricula->statusletter !!}</h4>
                    </div>
                </div>
                <div class="separador-detalle">Datos de Pagos</div>
                <div class="field">
                    <table class="table is-bordered is-striped">
                        <thead>
                        <tr class="has-background-grey-lighter">
                            <th class="has-text-centered">Estado</th>
                            <th>Cocepto</th>
                            <th>Metodo</th>
                            <th>Operacion</th>
                            <th class="has-text-centered">Monto</th>
                            <th>Fecha de Pago</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($matricula->pagos as $pago)
                            <tr>
                                <td class="has-text-centered">{!! $pago->status !!}</td>
                                <td>{{ $pago->concepto == 'M' ? 'Matrícula' : 'Pensión' }}</td>
                                <td>{{ $pago->tipo_pago | mp }}</td>
                                <td>{{ $pago->numero_operacion }}</td>
                                <td class="has-text-right">
                                    <b>S./ </b>{{ $pago->monto_pagado }}
                                </td>
                                <td>{{ $pago->fecha_deposito | dateFormat }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="has-text-centered">No se ha registrados pagos en esta matrícula</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="field">
                    <i class="fas fa-circle has-text-warning"></i> En revisión <i class="fas fa-circle has-text-success"></i> Pago Confirmado <i class="fas fa-circle has-text-danger"></i> Pago anulado por errores de datos
                </div>
                <div class="separador-detalle">Datos de Estudiante</div>
                <div class="columns">
                    <div class="column">
                        <div class="has-text-centered">Apellido paterno</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->apellido_paterno }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Apellido Materno</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->apellido_materno }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Nombre</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->nombres }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">{{ $matricula->alumno->tipo_documento }}</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->numero_documento }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Fecha Nacimiento</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->fecha_nacimiento | dateFormat }}</strong></div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="has-text-centered">Nivel</div>
                        <div class="has-text-centered"><strong>{{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Grado</div>
                        <div class="has-text-centered"><strong>{{ $matricula->grado | grado }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Teléfono Celular</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->celular }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Teléfono Emergencia</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->telefono_emergencia }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Correo Eletrónico</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->correo }}</strong></div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="has-text-centered">Exonerado Religión</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->exonerado_religion == 1 ? 'Sí' : 'No' }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Religión</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->religion == null ? 'N/A' : $matricula->alumno->religion }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Bautizado</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->bautizado == 1 ? 'Sí' : 'No' }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Primera Comunión</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->comunion == 1 ? 'Sí' : 'No' }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Confirmación</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->confirmacion == 1 ? 'Sí' : 'No' }}</strong></div>
                    </div>
                </div>
                <div class="columns">
                    <div class="column">
                        <div class="has-text-centered">Departamneto</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->departamento->nombre }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Provincia</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->provincia->nombre }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Distrito</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->distrito->nombre }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Domicilio</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->domicilio }}</strong></div>
                    </div>
                    <div class="column">
                        <div class="has-text-centered">Colegio Procedencia</div>
                        <div class="has-text-centered"><strong>{{ $matricula->alumno->colegio_procedencia}}</strong></div>
                    </div>
                </div>
                @foreach ($matricula->alumno->padres as $padre)
                    <div class="separador-detalle">Datos @if($padre->parentesco == 'P') del Padre @else de la Madre @endif @if(!$padre['vive'])(Fallecido(a)) @endif</div>
                    <div class="columns">
                        <div class="column">
                            <div class="has-text-centered">Apellidos</div>
                            <div class="has-text-centered"><strong>{{ $padre->apellidos }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Nombres</div>
                            <div class="has-text-centered"><strong>{{ $padre->nombres }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Fecha Nacimiento</div>
                            <div class="has-text-centered"><strong>{{ $padre->fecha_nacimiento | dateFormat }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">{{ $padre->tipo_documento }}</div>
                            <div class="has-text-centered"><strong>{{ $padre->numero_documento }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Vive con el estudiante</div>
                            <div class="has-text-centered"><strong>{{ $padre->vive_estudiante == 1 ? 'Sí' : 'No'}}</strong></div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="has-text-centered">Nivel de Escolaridad</div>
                            <div class="has-text-centered"><strong>{{ $padre->nivel_escolaridad }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Centro de Trabajo</div>
                            <div class="has-text-centered"><strong>{{ $padre->centro_trabajo }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Cargo/Ocupación</div>
                            <div class="has-text-centered"><strong>{{ $padre->cargo_ocupacion }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Estado Civil</div>
                            <div class="has-text-centered"><strong>{{ $padre->estado_civil | edoCivil }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Vive con el estudiante</div>
                            <div class="has-text-centered"><strong>{{ $padre->vive_estudiante == 1 ? 'Sí' : 'No'}}</strong></div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="has-text-centered">Responsable Económico</div>
                            <div class="has-text-centered"><strong>{{ $padre->responsable_economico == 1 ? 'Sí' : 'No' }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Apoderado</div>
                            <div class="has-text-centered"><strong>{{ $padre->apoderado == 1 ? 'Sí' : 'No' }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Domicilio</div>
                            <div class="has-text-centered"><strong>{{ $padre->domicilio }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Telefono Celular</div>
                            <div class="has-text-centered"><strong>{{ $padre->telefono_celular }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Correo Electrónico</div>
                            <div class="has-text-centered"><strong>{{ $padre->correo_electronico }}</strong></div>
                        </div>
                    </div>
                @endforeach
                @foreach($matricula->alumno->apoderados as $apoderado)
                    <div class="separador-detalle">Datos del apoderado</div>
                    <div class="columns">
                        <div class="column">
                            <div class="has-text-centered">Apellidos</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->apellidos }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Nombres</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->nombres }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Parentesco</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->fecha_nacimiento | dateFormat }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">{{ $apoderado->tipo_documento }}</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->numero_documento }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Vive con el estudiante</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->vive_estudiante == 1 ? 'Sí' : 'No'}}</strong></div>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="has-text-centered">Responsable Económico</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->responsable_economico == 1 ? 'Sí' : 'No' }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Apoderado</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->apoderado == 1 ? 'Sí' : 'No' }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Centro Trabajo</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->centro_trabajo }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Telefono Celular</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->telefono_celular }}</strong></div>
                        </div>
                        <div class="column">
                            <div class="has-text-centered">Correo Electrónico</div>
                            <div class="has-text-centered"><strong>{{ $apoderado->correo_electronico }}</strong></div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@push('js')
    <script>
        /*new Cleave('#cod-matricula', {
            delimiters: ['-'],
            blocks: [5, -1, 4],
            uppercase: true
        });*/
        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
    </script>
@endpush

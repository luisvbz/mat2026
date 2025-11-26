<div class="content-dashboard" x-data="{copiar (text) {
        Copy(text);
        Livewire.emit('swal:alert', {icon: 'success', title: 'Copiado!', timeout: 1000});
    }}">
    <div class="content-dashboard-header">
        <div><i class="fas fa-graduation-cap"></i> Detalle Matrícula: {{ $matricula->codigo }} @if($matricula->numero_matricula != null) <span class="has-text-lighter">#{{ $matricula->numero_matricula }}</span> @endif</div>
        <div>{!! $matricula->status !!}</div>
    </div>
    <div class="separador-matricula"><i class="fas fa-money-bill"></i> Datos de Pagos</div>
    <div class="content-dashboard-content box-content mb-5">
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
    </div>
    <div class="separador-matricula"><i class="fas fa-user-graduate"></i> Datos del Estudiante</div>
    <div class="content-dashboard-content box-content mb-5">
        <div class="datos-estudiante">
            <div class="datos-estudiante-left">
                <div class="img">
                    <img src="{{ $matricula->alumno->foto }}"/>
                </div>
                <div class="edad">
                    {{ $matricula->alumno->edad }} años
                </div>
                <div class="edad has-text-primary">
                    {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }} / {{ $matricula->grado | grado }}
                </div>
            </div>
            <div class="datos-estudiante-right">
                <div class="item-dato">
                    <i class="fas fa-id-card-alt"></i> <strong>{{ $matricula->alumno->tipo_documento }}: </strong>{{ $matricula->alumno->numero_documento }} <a @click="copiar('{{  $matricula->alumno->numero_documento }}')"><i class="fa fa-copy has-text-info"></i></a>
                </div>
                <div class="item-dato">
                    <i class="fas fa-id-card"></i> <strong>NOMBRE: </strong>{{ $matricula->alumno->nombre_completo }} <a @click="copiar('{{ $matricula->alumno->nombre_completo }}')"><i class="fa fa-copy has-text-info"></i></a>
                </div>
                <div class="item-dato">
                    <i class="fas fa-calendar-alt"></i> <strong>FECH. NAC.: </strong>{{ $matricula->alumno->fecha_nacimiento | dateFormat }}
                </div>
                <div class="item-dato">
                    <i class="fas fa-phone"></i> <strong>Celular: </strong>{{ $matricula->alumno->celular }} <a @click="copiar('{{  $matricula->alumno->celular }}')"><i class="fa fa-copy has-text-info"></i></a>
                </div>
                <div class="item-dato">
                    <i class="fas fa-hospital"></i> <strong>Emergencia: </strong>{{ $matricula->alumno->telefono_emergencia }} <a @click="copiar('{{  $matricula->alumno->telefono_emergencia }}')"><i class="fa fa-copy has-text-info"></i></a>
                </div>
                <div class="item-dato">
                    <i class="fas fa-at"></i> <strong>Correo Eletrónico: </strong>{{ strtolower($matricula->alumno->correo) }} <a @click="copiar('{{ strtolower($matricula->alumno->correo) }}')"><i class="fa fa-copy has-text-info"></i></a>
                </div>
                <div class="item-dato">
                    <i class="fas fa-map"></i> <strong>Ubicación: </strong>{{ $matricula->alumno->departamento->nombre }}, {{ $matricula->alumno->provincia->nombre }}, {{ $matricula->alumno->distrito->nombre }}
                </div>
                <div class="item-dato">
                    <i class="fas fa-location"></i> <strong>Dirección: </strong>{{ $matricula->alumno->domicilio }}
                </div>
                <div class="item-dato">
                    <i class="fas fa-school"></i> <strong>Colegio de Procedencia: </strong>{{ $matricula->alumno->colegio_procedencia }}
                </div>
                <div class="item-dato">
                    <i class="fas fa-church"></i> <strong>Exonerado de Religión: </strong>{{ $matricula->alumno->exonerado_religion == 1 ? 'Sí' : 'No' }}
                </div>
                <div class="item-dato">
                    <i class="fas fa-church"></i> <strong>Religión: </strong>{{ $matricula->alumno->religion == null ? 'N/A' : strtolower($matricula->alumno->religion) }}
                </div>
                <div class="item-dato">
                    <i class="fas fa-cross"></i> <strong>Bautizado: </strong>{{ $matricula->alumno->bautizado == 1 ? 'Sí' : 'No' }}
                </div>
                <div class="item-dato">
                    <i class="fas fa-cross"></i> <strong>Comunión: </strong>{{ $matricula->alumno->comunion == 1 ? 'Sí' : 'No' }}
                </div>
            </div>
        </div>
    </div>
    @foreach ($matricula->alumno->padres as $padre)
        <div class="separador-matricula"><i class="fas fa-user-alt"></i> Datos @if($padre->parentesco == 'P') del Padre @else de la Madre @endif @if(!$padre['vive'])(Fallecido(a)) @endif</div>
        <div class="content-dashboard-content box-content mb-5">
            <div class="datos-estudiante">
                <div class="datos-estudiante-left">
                    <div class="img">
                        <img src="{{$padre->parentesco == 'P' ? '/images/avatar_male.png' : '/images/avatar_female.png'}}"/>
                    </div>
                </div>
                <div class="datos-estudiante-right">
                    <div class="item-dato">
                        <i class="fas fa-id-card-alt"></i> <strong>{{ $padre->tipo_documento }}: </strong>{{ $padre->numero_documento }} <a @click="copiar('{{ $padre->numero_documento }}')"><i class="fa fa-copy has-text-info"></i></a>
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-id-card"></i> <strong>NOMBRE: </strong>{{ $padre->nombre_completo }} <a @click="copiar('{{ $padre->nombre_completo }}')"><i class="fa fa-copy has-text-info"></i></a>
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-rings-wedding"></i> <strong>edo. civil: </strong>{{ $padre->estado_civil | edoCivil }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-school"></i> <strong>Escolaridad: </strong>{{ $padre->nivel_escolaridad  }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-phone"></i> <strong>Celular: </strong>{{ $padre->telefono_celular }} <a @click="copiar('{{  $padre->telefono_celular }}')"><i class="fa fa-copy has-text-info"></i></a>
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-at"></i> <strong>Correo Eletrónico: </strong>{{ strtolower($padre->correo_electronico) }} <a @click="copiar('{{ strtolower($padre->correo_electronico) }}')"><i class="fa fa-copy has-text-info"></i></a>
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-location"></i> <strong>Dirección: </strong>{{ $padre->domicilio }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-building"></i> <strong>Centro de Trabajo: </strong>{{ $padre->centro_trabajo }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-user-tie"></i> <strong>Cargo/Ocupación: </strong>{{ $padre->cargo_ocupacion }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-question-circle"></i> <strong>¿Vive con el estudiante?: </strong>{{  $padre->vive_estudiante == 1 ? 'Sí' : 'No' }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-question-circle"></i> <strong>¿Reponsable Economico?: </strong>{{  $padre->responsable_economico == 1 ? 'Sí' : 'No' }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-question-circle"></i> <strong>¿Apoderado(a)?: </strong>{{  $padre->apoderado == 1 ? 'Sí' : 'No' }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach($matricula->alumno->apoderados as $apoderado)
        <div class="separador-matricula"><i class="fas fa-file-certificate"></i> Datos del apoderado</div>
        <div class="content-dashboard-content box-content mb-5">
            <div class="datos-estudiante">
                <div class="datos-estudiante-left">
                    <div class="img">
                        <img src="/images/avatar_male.png"/>
                    </div>
                </div>
                <div class="datos-estudiante-right">
                    <div class="item-dato">
                        <i class="fas fa-id-card-alt"></i> <strong>{{ $apoderado->tipo_documento }}: </strong>{{ $apoderado->numero_documento }} <a @click="copiar('{{ $apoderado->numero_documento }}')"><i class="fa fa-copy has-text-info"></i></a>
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-id-card"></i> <strong>NOMBRE: </strong>{{ $apoderado->apellidos }}, {{ ucfirst(strtolower($apoderado->nombres)) }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-users"></i> <strong>parentesco: </strong>{{ $apoderado->parentesco }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-phone"></i> <strong>Celular: </strong>{{ $apoderado->telefono_celular }} <a @click="copiar('{{  $apoderado->telefono_celular }}')"><i class="fa fa-copy has-text-info"></i></a>
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-at"></i> <strong>Correo Eletrónico: </strong>{{ strtolower($apoderado->correo_electronico) }} <a @click="copiar('{{ strtolower($apoderado->correo_electronico) }}')"><i class="fa fa-copy has-text-info"></i></a>
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-building"></i> <strong>Centro de Trabajo: </strong>{{ $apoderado->centro_trabajo }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-school"></i> <strong>Escolaridad: </strong>{{ $apoderado->nivel_escolaridad  }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-graduation-cap"></i> <strong>Grado Obtenido: </strong>{{ $apoderado->grado_obtenido != null ? $apoderado->grado_obtenido : 'N/T'  }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-question-circle"></i> <strong>¿Vive con el estudiante?: </strong>{{  $apoderado->vive_estudiante == 1 ? 'Sí' : 'No' }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-question-circle"></i> <strong>¿Reponsable Economico?: </strong>{{  $apoderado->responsable_economico == 1 ? 'Sí' : 'No' }}
                    </div>
                    <div class="item-dato">
                        <i class="fas fa-question-circle"></i> <strong>¿Apoderado(a)?: </strong>{{  $apoderado->apoderado == 1 ? 'Sí' : 'No' }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

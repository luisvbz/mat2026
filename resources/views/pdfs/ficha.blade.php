<!DOCTYPE html>
<html lang="es">
<head>
    <title>Ficha de Matricula</title>
    <meta charset="UTF-8">
    <style>

            @page {
                footer: page-footer;
            }

            .codigo {
                font-size: 16px;
            }

            .cabecera {
                margin-bottom: 10px;
                border-bottom-color: #0a0a0a;
                border-bottom: 1px solid;
            }
            .tg  {border-collapse:collapse;border-color:#ccc;border-spacing:0; width: 100%;}
            .tg td{background-color:#fff;border-color:#ccc;border-style:solid;border-width:1px;color:#333;
                font-family:Arial, sans-serif;font-size:11px;overflow:hidden;padding:2px 2px;word-break:normal;text-transform: uppercase;}
            .tg th{background-color:#f0f0f0;border-color:#ccc;border-style:solid;border-width:1px;color:#333;
                font-family:Arial, sans-serif;font-size:11px;font-weight:normal;overflow:hidden;padding:2px 2px;word-break:normal;}
            .tg .tg-m5nv{border-color:#656565;text-align:center;vertical-align:top}
            .tg .tg-m5nv-left{border-color:#656565;text-align:left;vertical-align:top}
            .tg .tg-x9uu{border-color:#656565;font-weight:bold;text-align:center;vertical-align:top}
            .tg .tg-x9uu-left{border-color:#656565;font-weight:bold;text-align:left;vertical-align:top}

            .footer {
                position: fixed;
                bottom: 1cm;
            }
    </style>
</head>
<body>
    <div class="cabecera">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div class="logo">
                        <img src="{{ asset('images/logo_web.png') }}" width="300"/>
                    </div>
                </td>
                <td style="text-align: right;">
                    <div style="font-size: 20px;"><strong>{{ $matricula->codigo }}</strong></div>
                </td>
            </tr>
        </table>
    </div>
    <div class="fecha-matricula" style="margin-bottom: 10px;">
        <table class="tg">
            <thead>
            <tr>
                <th colspan="3" class="tg-x9uu" style="font-size: 14px;">FICHA DE MATRÍCULA {{ $matricula->anio }}</th>
            </tr>
            <tr>
                <th class="tg-x9uu">FECHA</th>
                <th class="tg-x9uu">GRADO</th>
                <th class="tg-x9uu">NIVEL</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="tg-m5nv" style="width: 20%;">{{ $matricula->created_at | dateFormat }}</td>
                <td class="tg-m5nv">{{ $matricula->grado | grado }}</td>
                <td class="tg-m5nv">{{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="datos-estudiante" style="margin-bottom: 10px;">
        <table class="tg">
            <tr>
                <th class="tg-x9uu" colspan="4">DATOS DEL ESTUDIANTE</th>
            </tr>
            <tr>
                <th class="tg-x9uu">Tipo Doc.</th>
                <td class="tg-m5nv">{{ $matricula->alumno->tipo_documento }}</td>
                <th class="tg-x9uu">Número de documento</th>
                <td class="tg-m5nv">{{ $matricula->alumno->numero_documento }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Primer Apellido</th>
                <td class="tg-m5nv">{{ $matricula->alumno->apellido_paterno }}</td>
                <th class="tg-x9uu">Segundo Apellido</th>
                <td class="tg-m5nv">{{ $matricula->alumno->apellido_materno }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Nombres</th>
                <td colspan="3" class="tg-m5nv-left">{{ $matricula->alumno->nombres }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Fecha Nac.</th>
                <td class="tg-m5nv">{{ $matricula->alumno->fecha_nacimiento | dateFormat }}</td>
                <th class="tg-x9uu">Género</th>
                <td class="tg-m5nv">{{ $matricula->alumno->genero == 'M' ? 'Masculino' : 'Femenino' }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Nacionalidad</th>
                <td class="tg-m5nv">{{ $matricula->alumno->nacionalidad }}</td>
                <th class="tg-x9uu">Departamento</th>
                <td class="tg-m5nv">{{ $matricula->alumno->departamento->nombre }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Provincia</th>
                <td class="tg-m5nv">{{ $matricula->alumno->provincia->nombre }}</td>
                <th class="tg-x9uu">Distrito</th>
                <td class="tg-m5nv">{{ $matricula->alumno->distrito->nombre }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Domicilio</th>
                <td colspan="3" class="tg-m5nv-left">{{ $matricula->alumno->domicilio }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Telefono fijo</th>
                <td class="tg-m5nv">{{ $matricula->alumno->telefono_fijo }}</td>
                <th class="tg-x9uu">Celulares</th>
                <td class="tg-m5nv">{{ $matricula->alumno->celular }} / {{ $matricula->alumno->telefono_emergencia }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Religión</th>
                <td class="tg-m5nv">{{ $matricula->alumno->religion }}</td>
                <th class="tg-x9uu">Parroquia</th>
                <td class="tg-m5nv">{{ $matricula->alumno->parroquia }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Exonerado Religión</th>
                <td class="tg-m5nv">{{ $matricula->alumno->exonerado_religion == 1 ? 'Sí' : 'No' }}</td>
                <th class="tg-x9uu">Bautizado</th>
                <td class="tg-m5nv">{{ $matricula->alumno->bautizado == 1 ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Primera Comunión</th>
                <td class="tg-m5nv">{{ $matricula->alumno->comunion == 1 ? 'Sí' : 'No' }}</td>
                <th class="tg-x9uu">Confirmación</th>
                <td class="tg-m5nv">{{ $matricula->alumno->confirmacion == 1 ? 'Sí' : 'No' }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Necesidades especiales</th>
                <td class="tg-m5nv">{{ $matricula->alumno->nee == 1 ? 'Sí' : 'No' }}</td>
                <th class="tg-x9uu">Descripción</th>
                <td class="tg-m5nv">{{ $matricula->alumno->nee_descripcion }}</td>
            </tr>
            <tr>
                <th class="tg-x9uu">Colegio de Procedencia</th>
                <td class="tg-m5nv">{{ $matricula->alumno->colegio_procedencia }}</td>
                <th class="tg-x9uu">Situación Final</th>
                <td class="tg-m5nv">{{ $matricula->alumno->situacion_final }}</td>
            </tr>
        </table>
    </div>
    @foreach($matricula->alumno->padres as $padre)
        <div class="datos-padre" style="margin-bottom: 10px;">
            <table class="tg">
                <tr>
                    <th class="tg-x9uu" colspan="4">DATOS {{ $padre->parentesco == 'P' ? 'DEL PADRE' : 'DE LA MADRE' }}</th>
                </tr>
                <tr>
                    <th class="tg-x9uu">Tipo Doc.</th>
                    <td class="tg-m5nv">{{ $padre->tipo_documento }}</td>
                    <th class="tg-x9uu">Número de documento</th>
                    <td class="tg-m5nv">{{ $padre->numero_documento }}</td>
                </tr>
                <tr>
                    <th class="tg-x9uu">Apellidos</th>
                    <td class="tg-m5nv">{{ $padre->apellidos }}</td>
                    <th class="tg-x9uu">Nombres</th>
                    <td class="tg-m5nv">{{ $padre->nombres }}</td>
                </tr>
                @if($padre->vive)
                    <tr>
                        <th class="tg-x9uu">Domicilio</th>
                        <td colspan="3" class="tg-m5nv-left">{{ $padre->domicilio }}</td>
                    </tr>
                    <tr>
                        <th class="tg-x9uu">Telefono Celular</th>
                        <td class="tg-m5nv">{{ $padre->telefono_celular }}</td>
                        <th class="tg-x9uu">Correo Electrónico</th>
                        <td class="tg-m5nv">{{ $padre->correo_electronico }}</td>
                    </tr>
                    <tr>
                        <th class="tg-x9uu">Estado Civil</th>
                        <td class="tg-m5nv">{{ $padre->estado_civil |edoCivil }}</td>
                        <th class="tg-x9uu">Nivel Escolaridad</th>
                        <td class="tg-m5nv">{{ $padre->nivel_escolaridad }}</td>
                    </tr>
                    <tr>
                        <th class="tg-x9uu">Centro de Trabajo</th>
                        <td class="tg-m5nv">{{ $padre->centro_trabajo}}</td>
                        <th class="tg-x9uu">Cargo/Ocupación</th>
                        <td class="tg-m5nv">{{ $padre->cargo_ocupacion }}</td>
                    </tr>
                    <tr>
                        <th class="tg-x9uu">Fecha Nac.</th>
                        <td class="tg-m5nv">{{ $padre->fecha_nacimiento | dateFormat }}</td>
                        <th class="tg-x9uu">Apoderado</th>
                        <td class="tg-m5nv">{{ $padre->apoderado == 1 ? 'SÍ' : 'NO'}}</td>
                    </tr>
                    <tr>
                        <th class="tg-x9uu">Responsable económico</th>
                        <td class="tg-m5nv">{{ $padre->responsable_economico == 1 ? 'SÍ' : 'NO'}}</td>
                        <th class="tg-x9uu">Vive con el estudiante</th>
                        <td class="tg-m5nv">{{ $padre->vive_estudiante == 1 ? 'SÍ' : 'NO' }}</td>
                    </tr>
                @endif
            </table>
        </div>
    @endforeach
    @foreach($matricula->alumno->apoderados as $apoderado)
        <div class="datos-padre" style="margin-bottom: 10px;">
            <table class="tg">
                <tr>
                    <th class="tg-x9uu" colspan="4">DATOS DEL APODERADO Y/O RESPONSABLE ECONÓMICO DISTINTO A PADRE/MADRE</th>
                </tr>
                <tr>
                    <th class="tg-x9uu">Tipo Doc.</th>
                    <td class="tg-m5nv">{{ $apoderado->tipo_documento }}</td>
                    <th class="tg-x9uu">Número de documento</th>
                    <td class="tg-m5nv">{{ $apoderado->numero_documento }}</td>
                </tr>
                <tr>
                    <th class="tg-x9uu">Apellidos</th>
                    <td class="tg-m5nv">{{ $apoderado->apellidos }}</td>
                    <th class="tg-x9uu">Nombres</th>
                    <td class="tg-m5nv">{{ $apoderado->nombres }}</td>
                </tr>
                <tr>
                    <th class="tg-x9uu">Parentesco</th>
                    <td class="tg-m5nv">{{ $apoderado->parentesco }}</td>
                    <th class="tg-x9uu">Vive con el estudiante</th>
                    <td class="tg-m5nv">{{ $apoderado->vive_estudiante == 1 ? 'SÍ' : 'NO' }}</td>
                </tr>
                <tr>
                    <th class="tg-x9uu">Telefono Celular</th>
                    <td class="tg-m5nv">{{ $apoderado->telefono_celular }}</td>
                    <th class="tg-x9uu">Correo Electrónico</th>
                    <td class="tg-m5nv">{{ $apoderado->correo_electronico }}</td>
                </tr>
                <tr>
                    <th class="tg-x9uu">Nivel Escolaridad</th>
                    <td class="tg-m5nv">{{ $apoderado->nivel_escolaridad }}</td>
                    <th class="tg-x9uu">Grado Obtenido</th>
                    <td class="tg-m5nv">{{ $apoderado->grado_obtenido}}</td>
                </tr>
                <tr>
                    <th class="tg-x9uu">Apoderado</th>
                    <td class="tg-m5nv">{{ $apoderado->apoderado == 1 ? 'SÍ' : 'NO'}}</td>
                    <th class="tg-x9uu">Responsable económico</th>
                    <td class="tg-m5nv">{{ $apoderado->responsable_economico == 1 ? 'SÍ' : 'NO'}}</td>
                </tr>
                <tr>
                    <th class="tg-x9uu">Centro de Trabajo</th>
                    <td class="tg-m5nv-left" colspan="3">{{ $apoderado->centro_trabajo}}</td>
                </tr>
            </table>
        </div>
    @endforeach
    <div style="position: fixed; bottom: -15px;">
        <table style="width: 100%;">
            <tr>
                <td>
                    <div style="padding: 3px; border: 1px solid #ccc;">
                        <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->margin(0)->size(93)->generate(
                            "https://martricula.iepdivinosalvador.net.pe/verificador-matricula/$matricula->codigo"
                        )) !!}" alt="QrCode">
                    </div>
                </td>
                <td style="font-size: 14px; line-height: 20px;">
                    Yo, <strong>______________________________________________________________________________________</strong> con documento <strong>________________________________________</strong> declaro que soy el responsable del pago de la matricula y pensiones de enseñanza.
                </td>
                {{--
                @foreach($matricula->alumno->padres as $padre)
                    @if($padre->vive)
                    <td style="text-align: center; font-size: 11px;">
                        ________________________________<br>
                        FIRMA {{ $padre->parentesco == 'P' ? 'DEL PAPÁ' : 'DE LA MAMÁ' }}<br>
                        {{ $padre->tipo_documento }}: {{$padre->numero_documento}}
                    </td>
                    @endif
                @endforeach
                @foreach($matricula->alumno->apoderados as $apoderado)
                    <td style="text-align: center; font-size: 11px;">
                        ________________________________<br>
                        FIRMA DEL APODERADO(A)<br>
                        {{ $apoderado->tipo_documento }}: {{$apoderado->numero_documento}}
                    </td>
                @endforeach
                 --}}
            </tr>
        </table>
    </div>
    <pagebreak page-selector="posterior"/>
    <div style="padding: 20px; margin: 15px;">
        <h3 style="text-align: center;">DECLARACIÓN JURADA DEL SEGURO DE SALUD DEL ESTUDIANTE</h3><br>
        <p style="text-align: justify; font-size: 17px;">
            Yo, <b>{{ $matricula->salud->nombres }}</b>, con documento de identidad N° <b>{{ $matricula->salud->numero_documento }}</b>,
            en representación de mi hijo(a) con nombre <b>{{ $matricula->alumno->apellido_paterno.' '.$matricula->alumno->apellido_materno }}, {{ $matricula->alumno->nombres }}</b>
            con documento de identidad N° <b>{{ $matricula->alumno->numero_docuemento }}</b>,
            declaro bajo juramento que, autorizo e informo a la Instituciòn Educativa Privada (En adelante el “COLEGIO”),
            con Ruc 10254934475 y domicilio en Jr. Cailloma Nº 574 Cercado de Lima, de lo siguiente:
        </p>
        <ol>
            <li>Conozco, que el COLEGIO no tiene convenio con ninguna clínica, hospital u otros análogos para la contratación de los seguros de salud de mi hijo(a), por lo que, no he sido informado de ningún programa de protección de salud.</li>
            <li>
                Informo, que soy el único responsable de la protección de salud de mi hijo(a), por lo que, pongo de conocimiento del COLEGIO, el seguro de protección de salud y el establecimiento donde deberá ser derivado mi hijo(a) en caso de emergencia:<br>
                <b>Nombre del establecimiento: </b> {{ $matricula->salud->nombre_establecimiento }}<br>
                <b>Dirección: </b> {{  $matricula->salud->direccion  }}.<br>
                <b>Referencia: </b> {{  $matricula->salud->referencia  }}.<br>
                <b>Tipo de Seguro: </b> {{  $matricula->salud->tipo_seguro != 'OTRO' ? $matricula->salud->tipo_seguro :$matricula->salud->otro_seguro }}.<br>
            </li>
            <li>Acepto, que soy el único responsable en mantener activo el seguro de protección de salud de mi hijo(a), por lo que, los gastos derivados en caso de desprotección ante una emergencia son de mi responsabilidad.</li>
            <li>Conozco, que en caso de emergencia el COLEGIO activará su protocolo de contingencias administrativas, referido al procedimiento de emergencia por accidentes.</li>
        </ol>
        <div style="position: fixed; bottom: -15px;">
            <table style="width: 100%;">
                <tr>
                    <td style="font-size: 12px;">
                        Yo, <strong>{{ $matricula->salud->nombres }}</strong> con documento <strong>{{ $matricula->salud->tipo_documento }} {{ $matricula->salud->numero_documento }}</strong> declaro que soy el unico responsable del seguro de salud de mi hijo(a).
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>

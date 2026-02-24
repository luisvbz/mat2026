<div class="content-dashboard-content" x-data="{ tipo: @entangle('vista') }">
    <livewire:commons.mod-asistencia />
    <div class="content-dashboard">
        <div class="content-dashboard-header">
            <div><i class="fas fa-calendar-check"></i> Asistencia de Estudiantes</div>
            <div class="has-text-right">
                <a href="{{ route('asistencias.feriados') }}" class="button is-info is-small">
                    <i class="fas fa-calendar-times mr-2"></i> Gestión de Feriados
                </a>
            </div>
        </div>

        <!-- Barra de filtros principales -->
        <div class="content-dashboard-search-bar">
            <div class="columns is-vcentered">
                <div class="column is-2">
                    <label class="label is-size-7">Nivel</label>
                    <div class="select is-fullwidth">
                        <select wire:model="nivel">
                            <option value="">Seleccione nivel...</option>
                            <option value="P">Primaria</option>
                            <option value="S">Secundaria</option>
                        </select>
                    </div>
                </div>
                <div class="column is-2">
                    <label class="label is-size-7">Grado</label>
                    <div class="select is-fullwidth">
                        <select wire:model="grado" @if (!$grados || count($grados) == 0) disabled @endif>
                            <option value="">Seleccione grado...</option>
                            @foreach ($grados as $g)
                                <option value="{{ $g->numero }}">{{ $g->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="column is-2">
                    <label class="label is-size-7">Fecha</label>
                    <div class="is-fullwidth">
                        <input type="date" wire:model='day' class="input" />
                    </div>
                </div>
                <div class="column is-3">
                    <label class="label is-size-7">Vista</label>
                    <div class="buttons has-addons">
                        <button @click="tipo = 'dia'" class="button is-small"
                            :class="tipo == 'dia' ? 'is-success is-selected' : ''">
                            <span class="icon is-small">
                                <i class="fas fa-calendar-day"></i>
                            </span>
                            <span>Día</span>
                        </button>
                        <button @click="tipo = 'semana'" class="button is-small"
                            :class="tipo == 'semana' ? 'is-success is-selected' : ''">
                            <span class="icon is-small">
                                <i class="fas fa-calendar-week"></i>
                            </span>
                            <span>Semana</span>
                        </button>
                        <button @click="tipo = 'mes'" class="button is-small"
                            :class="tipo == 'mes' ? 'is-success is-selected' : ''">
                            <span class="icon is-small">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                            <span>Mes</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel de Reportes -->
        <div class="box mb-4"
            style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); border-left: 4px solid #17a2b8;">
            <div class="columns is-vcentered">
                <div class="column">
                    <h6 class="title is-6 mb-2">
                        <span class="icon-text">
                            <span class="icon has-text-info">
                                <i class="fas fa-file-pdf"></i>
                            </span>
                            <span>Generar Reporte de Asistencias</span>
                        </span>
                    </h6>
                    <p class="subtitle is-7 has-text-grey mt-1">
                        Genera un informe detallado de asistencias en formato PDF o Excel
                        @if (empty($grado))
                            <br><span class="has-text-info"><i class="fas fa-info-circle"></i> Sin grado seleccionado:
                                se generará reporte para todos los grados</span>
                        @endif
                    </p>
                </div>
                <div class="column is-narrow">
                    <div class="field is-grouped">
                        <div class="control">
                            <label class="label is-size-7">Año</label>
                            <div class="select is-small">
                                <select wire:model="anio_reporte">
                                    @for ($i = 2020; $i <= date('Y') + 1; $i++)
                                        <option value="{{ $i }}"
                                            @if ($i == date('Y')) selected @endif>{{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="control">
                            <label class="label is-size-7">Mes</label>
                            <div class="select is-small">
                                <select wire:model="mes_reporte">
                                    <option value="03" @if (date('m') == '03') selected @endif>Marzo
                                    </option>
                                    <option value="04" @if (date('m') == '04') selected @endif>Abril
                                    </option>
                                    <option value="05" @if (date('m') == '05') selected @endif>Mayo
                                    </option>
                                    <option value="06" @if (date('m') == '06') selected @endif>Junio
                                    </option>
                                    <option value="07" @if (date('m') == '07') selected @endif>Julio
                                    </option>
                                    <option value="08" @if (date('m') == '08') selected @endif>Agosto
                                    </option>
                                    <option value="09" @if (date('m') == '09') selected @endif>
                                        Septiembre</option>
                                    <option value="10" @if (date('m') == '10') selected @endif>Octubre
                                    </option>
                                    <option value="11" @if (date('m') == '11') selected @endif>Noviembre
                                    </option>
                                    <option value="12" @if (date('m') == '12') selected @endif>Diciembre
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="control">
                            <label class="label is-size-7">&nbsp;</label>
                            <div class="buttons">
                                <button wire:click="generarReporteAsistencia" class="button is-info is-small"
                                    @if (empty($nivel)) disabled title="Seleccione nivel" @endif
                                    wire:loading.attr="disabled" wire:target="generarReporteAsistencia">
                                    <span class="icon is-small" wire:loading.remove
                                        wire:target="generarReporteAsistencia">
                                        <i class="fas fa-file-pdf"></i>
                                    </span>
                                    <span class="icon is-small" wire:loading wire:target="generarReporteAsistencia">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    <span wire:loading.remove wire:target="generarReporteAsistencia">
                                        @if (empty($grado))
                                            PDF (Todos)
                                        @else
                                            PDF
                                        @endif
                                    </span>
                                    <span wire:loading wire:target="generarReporteAsistencia">Generando...</span>
                                </button>

                                <button wire:click="exportarExcelAsistencia" class="button is-success is-small"
                                    @if (empty($nivel)) disabled title="Seleccione nivel" @endif
                                    wire:loading.attr="disabled" wire:target="exportarExcelAsistencia">
                                    <span class="icon is-small" wire:loading.remove
                                        wire:target="exportarExcelAsistencia">
                                        <i class="fas fa-file-excel"></i>
                                    </span>
                                    <span class="icon is-small" wire:loading wire:target="exportarExcelAsistencia">
                                        <i class="fas fa-spinner fa-spin"></i>
                                    </span>
                                    <span wire:loading.remove wire:target="exportarExcelAsistencia">
                                        @if (empty($grado))
                                            Excel (Todos)
                                        @else
                                            Excel
                                        @endif
                                    </span>
                                    <span wire:loading wire:target="exportarExcelAsistencia">Generando...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensaje informativo cuando no se ha seleccionado nivel -->
        @if (empty($nivel))
            <div class="notification is-info is-light">
                <span class="icon">
                    <i class="fas fa-info-circle"></i>
                </span>
                <span>
                    <strong>Seleccione nivel</strong> para visualizar las asistencias de los estudiantes y poder
                    generar reportes. Si no selecciona grado, se generará un reporte con todos los grados del nivel.
                </span>
            </div>
        @endif

        <!-- Mensaje informativo cuando se ha seleccionado nivel pero no grado -->
        @if (!empty($nivel) && empty($grado))
            <div class="notification is-warning is-light">
                <span class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </span>
                <span>
                    <strong>Sin grado seleccionado:</strong> Para visualizar asistencias en pantalla debe seleccionar un
                    grado específico.
                    Sin embargo, puede generar un reporte PDF con todos los grados del nivel
                    {{ $nivel == 'P' ? 'Primaria' : 'Secundaria' }}.
                </span>
            </div>
        @endif

        <!-- Vista por Día -->
        @if ($vista == 'dia' && sizeof($alumnos) > 0)
            <div class="box-content content-dashboard-content">
                <div class="table-container">
                    <table class="table is-fullwidth is-bordered is-striped is-hoverable">
                        <thead>
                            <tr class="is-size-7 has-background-grey-lighter has-text-white has-text-weight-bold">
                                <td>
                                    <span class="icon-text">
                                        <span class="icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </span>
                                        <span>Alumno</span>
                                    </span>
                                </td>
                                <td style="width: 5%;" class="has-text-centered">Estado</td>
                                <td style="width: 10%;" class="has-text-centered">
                                    <span class="icon-text">
                                        <span class="icon">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <span>Entrada</span>
                                    </span>
                                </td>
                                <td style="width: 10%;" class="has-text-centered">Observación E.</td>
                                <td style="width: 10%;" class="has-text-centered">
                                    <span class="icon-text">
                                        <span class="icon">
                                            <i class="fas fa-door-open"></i>
                                        </span>
                                        <span>Salida</span>
                                    </span>
                                </td>
                                <td style="width: 10%;" class="has-text-centered">Observación S.</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                <tr>
                                    <td class="has-text-weight-semibold">
                                        {{ $alumno['nombre'] }}
                                    </td>
                                    @foreach ($alumno['dias'] as $dia)
                                        <td class="has-text-centered">
                                            @if ($dia['tipo'] == 'N')
                                                <span class="tag is-success is-light">
                                                    <i class="fas fa-check mr-1"></i> Presente
                                                </span>
                                            @elseif($dia['tipo'] == 'T')
                                                <span class="tag is-warning is-light" style="cursor: pointer;"
                                                    wire:click="mostrarJustificarTardanza({{ $dia['asistencia_id'] }})"
                                                    title="Click para justificar">
                                                    <i class="fas fa-hourglass mr-1"></i> Tardanza
                                                </span>
                                            @elseif($dia['tipo'] == 'TJ')
                                                <span class="tag is-success is-light">
                                                    <i class="fas fa-check-circle mr-1"></i> T. Justificada
                                                </span>
                                            @elseif($dia['tipo'] == 'F')
                                                <span class="tag is-light">
                                                    <i class="fas fa-calendar-times mr-1"></i> Feriado
                                                </span>
                                            @elseif($dia['tipo'] == 'FI')
                                                <span class="tag is-danger is-light">
                                                    <i class="fas fa-times mr-1"></i> Falta
                                                </span>
                                            @elseif($dia['tipo'] == 'FJ')
                                                <span class="tag is-info is-light">
                                                    <i class="fas fa-check-square mr-1"></i> F. Justificada
                                                </span>
                                            @else
                                                <span class="tag is-light">
                                                    <i class="fas fa-clock mr-1"></i> Sin registro
                                                </span>
                                            @endif
                                        </td>
                                        @if ($dia['tipo'] == 'FI')
                                            <td colspan="4"
                                                class="has-text-danger has-background-danger-light has-text-centered">
                                                <strong>Falta Injustificada</strong>
                                            </td>
                                        @elseif($dia['tipo'] == 'FJ')
                                            <td colspan="4" class="has-background-info-light has-text-centered">
                                                <strong>Falta Justificada (Permiso)</strong>
                                            </td>
                                        @elseif($dia['tipo'] == 'F')
                                            <td colspan="4"
                                                class="has-background-light has-text-centered has-text-grey">
                                                <strong>Día Feriado</strong>
                                            </td>
                                        @else
                                            <td class="has-text-centered">
                                                @if ($dia['entrada'])
                                                    <span class="tag is-primary is-light">
                                                        {{ \Carbon\Carbon::parse($dia['entrada'])->format('h:i A') }}
                                                    </span>
                                                @else
                                                    <span class="has-text-grey">-</span>
                                                @endif
                                            </td>
                                            <td
                                                class="has-text-centered @if ($dia['tardanza_entrada']) has-text-danger @endif">
                                                @if ($dia['tardanza_entrada'])
                                                    <span class="tag is-warning is-small">
                                                        {{ $dia['tardanza_entrada'] }}
                                                    </span>
                                                @else
                                                    <span class="has-text-grey is-size-7">-</span>
                                                @endif
                                            </td>
                                            <td class="has-text-centered">
                                                @if ($dia['salida'])
                                                    <span class="tag is-link is-light">
                                                        {{ \Carbon\Carbon::parse($dia['salida'])->format('h:i A') }}
                                                    </span>
                                                @else
                                                    <span class="has-text-grey">-</span>
                                                @endif
                                            </td>
                                            <td
                                                class="has-text-centered @if ($dia['salida_anticipada'] && $dia['tipo'] == 'T') has-text-danger @endif">
                                                @if ($dia['salida_anticipada'])
                                                    <span class="tag is-warning is-small">
                                                        {{ $dia['salida_anticipada'] }}
                                                    </span>
                                                @else
                                                    <span class="has-text-grey is-size-7">-</span>
                                                @endif
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Vista por Semana/Mes -->
        @elseif(in_array($vista, ['semana', 'mes']) && sizeof($alumnos) > 0)
            <div class="box-content content-dashboard-content">
                <div class="table-container">
                    <table class="table is-fullwidth is-bordered is-striped is-hoverable">
                        <thead>
                            <tr class="is-size-7 has-background-gray has-text-white has-text-weight-bold">
                                <td rowspan="2" style="width: 30%; vertical-align: middle;">
                                    <span class="icon-text">
                                        <span class="icon">
                                            <i class="fas fa-user-graduate"></i>
                                        </span>
                                        <span>Alumno</span>
                                    </span>
                                </td>
                                @foreach ($dias as $dia)
                                    <td class="has-text-centered" style="min-width: 50px;">
                                        <strong>{{ $dia['dia_letra'] }}</strong>
                                    </td>
                                @endforeach
                            </tr>
                            <tr class="is-size-7 has-background-gray has-text-white has-text-weight-bold">
                                @foreach ($dias as $dia)
                                    <td class="has-text-centered">
                                        {{ \Carbon\Carbon::parse($dia['fecha'])->format('d/m') }}
                                    </td>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alumnos as $alumno)
                                <tr class="has-background-light">
                                    <td rowspan="2" class="has-text-weight-semibold"
                                        style="vertical-align: middle;">
                                        <span class="icon-text">
                                            <span class="icon has-text-info">
                                                <i class="fas fa-user"></i>
                                            </span>
                                            <span>{{ $alumno['nombre'] }}</span>
                                        </span>
                                    </td>
                                    @foreach ($alumno['dias'] as $dia)
                                        <td class="has-text-centered" style="background: #f0f8ff;">
                                            @if ($dia['entrada'])
                                                <span class="tag is-primary is-small">
                                                    <i class="fas fa-sign-in-alt mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($dia['entrada'])->format('h:i') }}
                                                </span>
                                            @else
                                                <span class="has-text-grey is-size-7">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                                <tr>
                                    @foreach ($alumno['dias'] as $dia)
                                        <td class="has-text-centered" style="background: #fff8f0;">
                                            @if ($dia['salida'])
                                                <span class="tag is-link is-small">
                                                    <i class="fas fa-sign-out-alt mr-1"></i>
                                                    {{ \Carbon\Carbon::parse($dia['salida'])->format('h:i') }}
                                                </span>
                                            @else
                                                <span class="has-text-grey is-size-7">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Estado vacío mejorado -->
        @if (sizeof($alumnos) == 0 && !empty($nivel) && !empty($grado))
            <div class="has-text-centered py-6">
                <div class="icon is-large has-text-grey-light mb-4">
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <h4 class="title is-4 has-text-grey">No hay registros de asistencia</h4>
                <p class="subtitle is-6 has-text-grey">
                    No se encontraron estudiantes matriculados en {{ $nivel == 'P' ? 'Primaria' : 'Secundaria' }} -
                    @if ($grados && $grado)
                        {{ collect($grados)->where('numero', $grado)->first()->nombre ?? $grado }}
                    @else
                        Grado {{ $grado }}
                    @endif
                    para la fecha seleccionada.
                </p>
            </div>
        @endif
    </div>
</div>

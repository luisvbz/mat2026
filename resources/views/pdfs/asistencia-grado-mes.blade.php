<html>
<title>Informe de Asistencia Mensual</title>

<head>
    <style type="text/css">
        @page {
            header: page-header;
            footer: page-footer;
            margin: 10mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .tabla-info {
            border-collapse: collapse;
            width: 100%;
            margin: 0 auto;
            background-color: white;
        }

        .tabla-info td {
            border: 1px solid #333;
            padding: 6px 10px;
            font-size: 11px;
        }

        .label {
            background-color: #f8f8f8;
            font-weight: bold;
            text-align: center;
            width: 80px;
            color: #333;
        }

        .value {
            background-color: white;
            text-align: center;
            min-width: 120px;
            font-weight: normal;
        }

        .tabla-info tr:hover {
            background-color: #f9f9f9;
        }

        .header-info {
            display: flex;
            align-items: flex-start;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
            margin-bottom: 15px;
            gap: 15px;
        }

        .header-info img {
            width: 80px;
            height: auto;
            flex-shrink: 0;
        }

        .info-institucional {
            flex: 1;
            text-align: center;
            font-size: 12px;
            font-weight: bold;
            line-height: 1.4;
            padding-top: 5px;
        }

        .institucion-nombre {
            font-size: 14px;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .institucion-detalles {
            font-size: 10px;
            color: #7f8c8d;
            font-weight: normal;
        }

        .info-reporte {
            display: table;
            width: 100%;
            margin-bottom: 15px;
            font-size: 11px;
        }

        .info-left,
        .info-right {
            display: table-cell;
            vertical-align: top;
            width: 50%;
        }

        .info-right {
            text-align: right;
        }

        .tabla-asistencias {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            font-size: 9px;
        }

        .tabla-asistencias td,
        .tabla-asistencias th {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
        }

        .header-tabla {
            background-color: #efefef;
            font-weight: bold;
            font-size: 12px;
        }

        .header-dias {
            background-color: #d9d9d9;
            font-weight: bold;
            font-size: 8px;
            writing-mode: vertical-lr;
            text-orientation: mixed;
            height: 40px;
        }

        .numero-alumno {
            width: 25px;
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .nombre-alumno {
            text-align: left;
            padding-left: 5px;
            min-width: 180px;
            background-color: #f9f9f9;
            font-size: 11px;
        }

        .dia-celda {
            width: 12px;
            font-size: 11px;
            font-weight: bold;
        }

        .dia-celda-feriado {
            width: 12px;
            font-size: 11px;
            font-weight: bold;
            background: repeating-linear-gradient(135deg,
                    #f0f0f0,
                    #f0f0f0 6px,
                    #d3d3d3 8px,
                    #f0f0f0 10px);
        }

        .leyenda {
            margin-top: 15px;
            font-size: 11px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
        }

        .leyenda-item {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 3px;
        }

        .titulo-reporte {
            background-color: #4a4a4a;
            color: white;
            font-weight: bold;
            font-size: 12px;
            text-align: center;
            padding: 8px;
            margin-bottom: 10px;
        }

    </style>
</head>

<body>
    <div style="text-align: center; padding-bottom: 5px; border-bottom: 1px solid #000; margin-bottom: 10px;">
        <img src="{{ asset('images/logo_web.png') }}" width="350px">
    </div>
    <table class="tabla-info">
        <tr>
            <td class="label">Año</td>
            <td class="value">{{ $datosReporte['anio'] }}</td>
            <td class="label">Grado</td>
            <td class="value"> {{ strtoupper($datosReporte['gradoInfo']->nombre ?? '') }}</td>
        </tr>
        <tr>
            <td class="label">Mes</td>
            <td class="value">{{ $datosReporte['mes'] }}</td>
            <td class="label">Nivel</td>
            <td class="value">{{ ucfirst($datosReporte['gradoInfo']->nivel == 'P' ? 'Primaria' : 'Secundaria') }}</td>
        </tr>
    </table>
    <hr />
    <div class="titulo-reporte">
        INFORME DE ASISTENCIA MENSUAL
    </div>

    <table class="tabla-asistencias">
        <thead>
            <tr>
                <th class="header-tabla numero-alumno">#</th>
                <th class="header-tabla nombre-alumno">NOMBRES</th>
                @foreach ($datosReporte['diasLaborables'] as $dia)
                <th class="header-tabla dia-celda">{{ str_pad($dia, 2, '0', STR_PAD_LEFT) }}</th>
                @endforeach
            </tr>
            <tr>
                <td class="header-dias"></td>
                <td class="header-dias"></td>
                @foreach ($datosReporte['diasSemana'] as $diaInfo)
                <td class="header-dias">{{ $diaInfo['letra'] }}</td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach ($datosReporte['alumnos'] as $alumno)
            <tr>
                <td class="numero-alumno">{{ $contador }}</td>
                <td class="nombre-alumno">{{ $alumno->nombre_completo }}</td>
                @foreach ($datosReporte['diasLaborables'] as $dia)
                @php
                $columna = 'dia_' . $dia;
                $asistencia = $alumno->$columna ?? '.';
                @endphp
                @if ($asistencia == 'FE')
                <td class="dia-celda-feriado"></td>
                @else
                <td class="dia-celda">{{ $asistencia }}</td>
                @endif
                @endforeach
            </tr>
            @php $contador++; @endphp
            @endforeach
        </tbody>
    </table>

    <div class="leyenda">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <div style="flex: 1;">
                <span class="leyenda-item"><strong>A</strong> Asistió</span>
                <span class="leyenda-item"><strong>F</strong> Falta</span>
                <span class="leyenda-item"><strong>T</strong> Tardanza</span>
                <span class="leyenda-item"><strong>J</strong> Falta justificada</span>
                <span class="leyenda-item"><strong>U</strong> Tardanza justificada</span><br>
            </div>

        </div>
    </div>
    <div>
        @if (!empty($feriados))
        <div style="margin-top: 10px; font-size: 10px;">
            <strong>Feriados o días no laborables excepcionales del mes:</strong>
            <ul style="margin: 5px 0 0 18px; padding: 0;">
                @foreach ($feriados as $feriado)
                <li>{{ $feriado['fecha_feriado'] | date:'d/m/Y' }}
                    - {{ $feriado['descripcion'] }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <htmlpageheader name="page-header">
        <div style="text-align: right; font-size: 10px; padding-top: 5px;">
            {{ date('d/m/Y') }}
        </div>
    </htmlpageheader>

    <htmlpagefooter name="page-footer">
        <div style="font-size: 10px; padding-bottom: 5px;">
            Reporte generado el <b>{{ date('d/m/Y H:i:s') }}</b> por <b>{{ auth()->user()->name ?? 'Sistema' }}</b>
        </div>
    </htmlpagefooter>
</body>

</html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<table>
    @foreach ($datosReporte['grados'] as $gradoData)
        <thead>
            <tr>
                <th colspan="{{ count($datosReporte['diasLaborables']) + 2 }}"
                    style="font-size: 16px; font-weight: bold; text-align: center;">
                    INFORME DE ASISTENCIA MENSUAL - {{ strtoupper($gradoData['gradoInfo']->nombre) }}
                </th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; text-align: left;">Año:</th>
                <th colspan="{{ count($datosReporte['diasLaborables']) }}" style="text-align: left;">
                    {{ $datosReporte['anio'] }}</th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; text-align: left;">Mes:</th>
                <th colspan="{{ count($datosReporte['diasLaborables']) }}" style="text-align: left;">
                    {{ $datosReporte['mes'] }}</th>
            </tr>
            <tr>
                <th colspan="2" style="font-weight: bold; text-align: left;">Nivel:</th>
                <th colspan="{{ count($datosReporte['diasLaborables']) }}" style="text-align: left;">
                    {{ ucfirst($datosReporte['nivel'] == 'P' ? 'Primaria' : 'Secundaria') }}</th>
            </tr>
            <tr></tr>
            <tr>
                <th style="border: 1px solid #000; background-color: #efefef; font-weight: bold;">#</th>
                <th style="border: 1px solid #000; background-color: #efefef; font-weight: bold;">NOMBRES</th>
                @foreach ($datosReporte['diasLaborables'] as $dia)
                    <th style="border: 1px solid #000; background-color: #efefef; font-weight: bold;">
                        {{ str_pad($dia, 2, '0', STR_PAD_LEFT) }}</th>
                @endforeach
            </tr>
            <tr>
                <th style="border: 1px solid #000;"></th>
                <th style="border: 1px solid #000;"></th>
                @foreach ($datosReporte['diasSemana'] as $diaInfo)
                    <th
                        style="border: 1px solid #000; background-color: #d9d9d9; font-weight: bold; text-align: center;">
                        {{ $diaInfo['letra'] }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $contador = 1; @endphp
            @foreach ($gradoData['alumnos'] as $alumno)
                <tr>
                    <td style="border: 1px solid #000; text-align: center;">{{ $contador }}</td>
                    <td style="border: 1px solid #000;">{{ $alumno->nombre_completo }}</td>
                    @foreach ($datosReporte['diasLaborables'] as $dia)
                        @php
                            $columna = 'dia_' . $dia;
                            $asistencia = $alumno->$columna ?? '.';
                        @endphp
                        <td
                            style="border: 1px solid #000; text-align: center; @if ($asistencia == 'FE') background-color: #d3d3d3; @endif">
                            {{ $asistencia == 'FE' ? '' : $asistencia }}
                        </td>
                    @endforeach
                </tr>
                @php $contador++; @endphp
            @endforeach
        </tbody>
        <tr></tr>
        <tr></tr> <!-- Extra space between grades -->
    @endforeach
</table>

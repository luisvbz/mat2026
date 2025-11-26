<html>
<title>Resumen de Pagos</title>

<head>
    <style type="text/css">
        @page {
            footer: page-footer;
        }

        .tabla-datos {
            padding: 15px;
        }

        .tg {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        .tg td {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: Arial, sans-serif;
            font-size: 10px;
            overflow: hidden;
            padding: 5px 2px;
            word-break: normal;
        }

        .tg th {
            border-color: black;
            border-style: solid;
            border-width: 1px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg .tg-3x8j {
            background-color: #c0c0c0;
            border-color: #000000;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-fm1b {
            background-color: #efefef;
            border-color: #000000;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-wp8o {
            border-color: #000000;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-wkkj {
            background-color: #efefef;
            border-color: #000000;
            font-weight: bold;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-73oq {
            border-color: #000000;
            text-align: left;
            vertical-align: top
        }
    </style>
</head>

<body>
    @php $i = 1; @endphp
    @foreach ($relacion as $grado)
        <div class="tabla-datos">
            <table class="tg">
                <thead>
                    <tr>
                        <th class="tg-3x8j" colspan="12">REPORTE DE PAGOS DE ALUMNOS DE
                            {{ $grado->grado | gradoNumero }} DE {{ $grado->nivel }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="tg-fm1b" colspan="2">AÑO 2026</td>
                        <td class="tg-fm1b" colspan="10">MESES</td>
                    </tr>
                    <tr>
                        <td class="tg-fm1b">N°</td>
                        <td class="tg-wkkj">APELLIDOS Y NOMBRES</td>
                        <td class="tg-fm1b">MARZO</td>
                        <td class="tg-fm1b">ABRIL</td>
                        <td class="tg-fm1b">MAYO</td>
                        <td class="tg-fm1b">JUNIO</td>
                        <td class="tg-fm1b">JULIO</td>
                        <td class="tg-fm1b">AGOSTO</td>
                        <td class="tg-fm1b">SETIEMBRE</td>
                        <td class="tg-fm1b">OCTUBRE</td>
                        <td class="tg-fm1b">NOVIEMBRE</td>
                        <td class="tg-fm1b">DICIEMBRE</td>
                    </tr>
                    @php $aux = 1; @endphp
                    @forelse ($grado->alumnos as $alumno)
                        <tr>
                            <td class="tg-wp8o">{{ $aux }}</td>
                            <td class="tg-73oq">{{ $alumno->alumno }}</td>
                            @foreach ($alumno->meses as $mes)
                                <td class="tg-wp8o">
                                    @if ($mes['pagado'] !== null)
                                        <img src="{{ $mes['pagado'] == 1 ? asset('images/check.png') : asset('images/warning.png') }}"
                                            width="15px">
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                        @php $aux++; @endphp
                    @empty
                        <tr>
                            <td style="text-align: center;" colspan="12">NO SE HAN INSCRITO ALUMNOS EN ESTE GRADO</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
        @php $i++; @endphp
        @if (!$loop->last)
            <pagebreak />
        @endif
    @endforeach
    <htmlpagefooter name="page-footer">
        Reporte generado el <b>{{ date('d/m/Y') }}</b> por <b>{{ auth()->user()->name }}</b>
    </htmlpagefooter>
</body>

</html>

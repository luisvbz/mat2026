<html>
<title>Resumen de matriculas</title>
<head>
    <style type="text/css">
        @page {
            header: page-header;
            footer: page-footer;
        }
        .tabla-datos {
            padding: 15px;
        }
        .tg  {border-collapse:collapse;border-spacing:0;width: 100%;}
        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;
            overflow:hidden;padding:5px 2px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;
            font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-fm1b{background-color:#efefef;border-color:#000000;font-weight:bold;text-align:center;vertical-align:top}
        .tg .tg-wp8o{border-color:#000000;text-align:center;vertical-align:top}
        .tg .tg-pykm{background-color:#9b9b9b;font-weight:bold;text-align:center;vertical-align:top}
        .tg .tg-wkkj{background-color:#efefef;border-color:#000000;font-weight:bold;text-align:left;vertical-align:top}
        .tg .tg-73oq{border-color:#000000;text-align:left;vertical-align:top}
    </style>
</head>
<body>
@php $i = 1; @endphp
@foreach($matriculas as $grado)
    <div class="tabla-datos">
        <div style="text-align: center; padding-bottom: 5px; border-bottom: 1px solid #000; margin-bottom: 10px;">
            <img src="{{ asset('images/logo_web.png') }}" width="350px">
        </div>
        <table class="tg">
            <tbody>
            <tr>
                <td class="tg-fm1b">N°</td>
                <td class="tg-fm1b" style="text-align: left;">ALUMNO</td>
                <td class="tg-fm1b">DNI</td>
                <td class="tg-fm1b">DNI MADRE</td>
                <td class="tg-fm1b">DNI PADRE</td>
            </tr>
            @php
                $aux = 1;
            @endphp
            @forelse ($grado->alumnos as $alumno)
                <tr>
                    <td class="tg-wp8o">{{ $aux }}</td>
                    <td class="tg-wp8o" style="text-align: left;">{{ $alumno->alumno }}</td>
                    <td class="tg-wp8o">{{ $alumno->dni_alumno  }}</td>
                    <td class="tg-wp8o">{{ $alumno->dni_mama  }}</td>
                    <td class="tg-wp8o">{{ $alumno->dni_papa  }}</td>
                </tr>
                @php $aux++; @endphp
            @empty
                <tr>
                    <td style="text-align: center;" colspan="3">NO SE HAN INSCRITO ALUMNOS EN ESTE GRADO</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @php $i++; @endphp
    @if(!$loop->last)
        <pagebreak/>
    @endif
@endforeach
<htmlpageheader name="page-header">
    <div style="text-align: right; font-size: 10px; padding-top: 5px;">
        {{ date('d/m/Y') }}
    </div>
</htmlpageheader>
<htmlpagefooter name="page-footer">
    <div style="font-size: 10px; padding-bottom: 5px;">
        Reporte generado el  <b>{{ date('d/m/Y') }}</b> por <b>{{ auth()->user()->name }}</b>
    </div>
</htmlpagefooter>
</body>
</html>

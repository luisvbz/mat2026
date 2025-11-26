<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Asistencia Profesores</title>
    <style type="text/css">
        .tg {
            border-collapse: collapse;
            border-spacing: 0;
        }

        .tg td {
            border-color: #000;
            border-style: solid;
            border-width: 0.5px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg th {
            border-color: #000;
            border-style: solid;
            border-width: 0.5px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            font-weight: normal;
            overflow: hidden;
            padding: 10px 5px;
            word-break: normal;
        }

        .tg .tg-0dt9 {
            background-color: #ffccc9;
            border-color: inherit;
            color: #cb0000;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-oii0 {
            background-color: #A8EFA8;
            border-color: inherit;
            color: #009901;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-8yz1 {
            background-color: #FFCCC9;
            border-color: inherit;
            color: #CB0000;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-zlqz {
            background-color: #c0c0c0;
            border-color: inherit;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-c3ow {
            border-color: inherit;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-0pky {
            border-color: inherit;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-fymr {
            border-color: inherit;
            font-weight: bold;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-7btt {
            border-color: inherit;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-duhk {
            background-color: #a8efa8;
            border-color: inherit;
            color: #009901;
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-amwm {
            font-weight: bold;
            text-align: center;
            vertical-align: top
        }

        .tg .tg-b3sw {
            background-color: #efefef;
            font-weight: bold;
            text-align: left;
            vertical-align: top
        }

        .tg .tg-3o7q {
            background-color: #ffccc9;
            color: #fe0000;
            font-weight: bold;
            text-align: left;
            vertical-align: top
        }

    </style>
</head>
<body>
    @foreach ($profes as $profe)
    <table class="tg" style="width: 100%;">
        <thead>
            <tr>
                <th class="tg-0pky" colspan="2" rowspan="3" style="text-align:center;">
                    <img src="{{ public_path('/images/fotos/p/'.$profe->documento.'.jpg') }}" alt="logo" style="width: 100px;">
                </th>
                <th class="tg-fymr">NOMBRE</th>
                <th class="tg-0pky" colspan="3">{{ $profe->apellidos}}, {{ $profe->nombres}}</th>
            </tr>
            <tr>
                <th class="tg-fymr">CARGO</th>
                <th class="tg-0pky" colspan="3">{{ $profe->cargo }}</th>
            </tr>
            <tr>
                <th class="tg-fymr">MES</th>
                <th class="tg-0pky" colspan="3">{{ $mes }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="tg-7btt" colspan="2">TARDANZAS</td>
                <td class="tg-c3ow">{{ $profe->total_tardanzas }}</td>
                <td class="tg-0pky" colspan="3">{{ $profe->total_tiempo_tardanza  }}</td>
            </tr>
            <tr>
                <td class="tg-zlqz" colspan="2">FECHA</td>
                <td class="tg-zlqz">ENTRADA</td>
                <td class="tg-zlqz">OBSERVACIÓN</td>
                <td class="tg-zlqz">SALIDA</td>
                <td class="tg-zlqz">OBSERVACIÓN</td>
            </tr>
            @foreach($profe->asistencias as $a)
            @if($a->tipo == 'N')
            <tr>
                <td class="tg-7btt" colspan="2">{{ $a->dia | date:'d-m-Y' }}</td>
                <td class="tg-c3ow">{{$a->entrada | date:'h:i:s a' }}</td>
                <td class="tg-duhk">A TIEMPO</td>
                <td class="tg-c3ow">{{$a->salida | date:'h:i:s a' }}</td>
                @if($a->salida_anticipada || $a->comentario_salida)
                <td class="tg-8yz1">{{ $a->salida_anticipada  }}</td>
                @else
                <td class="tg-oii0">A TIEMPO</td>
                @endif
            </tr>
            @elseif($a->tipo == 'T')
            <tr>
                <td class="tg-7btt" colspan="2">{{ $a->dia | date:'d-m-Y' }}</td>
                <td class="tg-c3ow">{{$a->entrada | date:'h:i:s a' }}</td>
                <td class="tg-0dt9">{{$a->tardanza_entrada }}</td>
                <td class="tg-c3ow">{{$a->salida | date:'h:i:s a' }}</td>
                @if($a->salida_anticipada || $a->comentario_salida)
                <td class="tg-8yz1">{{ $a->salida_anticipada  }}</td>
                @else
                <td class="tg-oii0">A TIEMPO</td>
                @endif
            </tr>
            @elseif($a->tipo == 'FI')
            <tr>
                <td class="tg-amwm" colspan="2">{{ $a->dia | date:'d-m-Y' }}</td>
                <td class="tg-3o7q" colspan="4">FALTA INJUSTIFICADA</td>
            </tr>
            @elseif($a->tipo == 'NL')
            <tr>
                <td class="tg-amwm" colspan="2">{{ $a->dia | date:'d-m-Y' }}</td>
                <td class="tg-b3sw" colspan="4">NO LABORABLE SEGÚN SU HORARIO</td>
            </tr>
            @elseif($a->tipo == 'FJ')
            <tr>
                <td class="tg-amwm" colspan="2">{{ $a->dia | date:'d-m-Y' }}</td>
                <td class="tg-b3sw" colspan="4">FALTA JUSTIFICADA</td>
            </tr>
            @elseif($a->tipo == 'F')
            <tr>
                <td class="tg-amwm" colspan="2">{{ $a->dia | date:'d-m-Y' }}</td>
                <td class="tg-b3sw" colspan="4">{{ $a->feriado->descripcion ?? 'Feriado' }}</td>
            </tr>
            @endif
            @endforeach
        </tbody>
    </table>
    <pagebreak />
    @endforeach
</body>
</html>

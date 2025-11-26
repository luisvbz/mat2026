<html>
<title>Reporte de deudores</title>
<head>
    <style type="text/css">
        .titulo {
            margin-bottom: 10px;
            text-align: center;
            font-size: 20px;

        }
        .tg  {border-collapse:collapse;border-color:#ccc;border-spacing:0;width: 100%;}
        .tg td{background-color:#fff;border-color:#ccc;border-style:solid;border-width:1px;color:#333;
            font-family:Arial, sans-serif;font-size:14px;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg th{background-color:#f0f0f0;border-color:#ccc;border-style:solid;border-width:1px;color:#333;
            font-family:Arial, sans-serif;font-size:14px;font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-m5nv{border-color:#656565;text-align:left;vertical-align:top}
        .tg .tg-x9uu{border-color:#656565;font-weight:bold;text-align:center;vertical-align:top}
        .tg .tg-ur59{border-color:#343434;text-align:left;vertical-align:top}
    </style>
</head>
<body>
    <div class="titulo">
        <b>REPORTE DE ALUMNOS QUE ADEUDAN AL COLEGIO AL {{ date('d/m/Y') }}</b>
    </div>
    <div class="tabla-de-datos">
        <table class="tg">
            <thead>
            <tr>
                <th class="tg-x9uu" style="text-align: center;">N°</th>
                <th class="tg-x9uu">NIVEL</th>
                <th class="tg-x9uu"><span style="font-weight:700;font-style:normal">GRADO</span></th>
                <th class="tg-x9uu">ALUMNO</th>
                <th class="tg-x9uu"><span style="font-weight:700;font-style:normal">PENSIONES QUE ADEUDA</span></th>
                <th class="tg-x9uu">TOTAL</th>
            </tr>
            </thead>
            <tbody>
            @php $i = 1; $total = 0.00; @endphp
            @foreach($deudores as $deudor)
                <tr>
                    <td class="tg-m5nv" style="text-align: center;">{{ $i }}</td>
                    <td class="tg-m5nv">{{ $deudor->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}</td>
                    <td class="tg-ur59"><span style="font-weight:400;font-style:normal">{{ $deudor->grado | grado }}</span></td>
                    <td class="tg-m5nv">{{ $deudor->alumno }}</td>
                    <td class="tg-ur59"><span style="font-weight:400;font-style:normal">{{ implode(",", $deudor->meses) }}</span></td>
                    <td class="tg-ur59" style="text-align: right;"><span style="font-weight:400;font-style:normal"><b>S./</b> {{ number_format($deudor->total->sum('monto'), 2,'.',',') }}</span></td>
                </tr>
                @php $i++; $total = $total + $deudor->total->sum('monto'); @endphp
            @endforeach
                <tr>
                    <td COLSPAN="5" class="tg-ur59" style="text-align: right;"><b>TOTAL ADEUDADO</b></td>
                    <td class="tg-ur59" style="text-align: right;"><b>S./</b> {{ number_format($total,  2,'.',',') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

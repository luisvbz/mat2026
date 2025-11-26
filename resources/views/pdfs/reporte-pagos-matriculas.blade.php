<html>
    <title>Reporte de pago de pensiones</title>
    <head>
        <style type="text/css">
            @page {
                footer: page-footer;
            }
            .tg  {border-collapse:collapse;border-spacing:0;width: 100%;}
            .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:14px;
                font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
            .tg .tg-3x8j{background-color:#c0c0c0;border-color:#000000;font-size:16px;font-weight:bold;text-align:center;vertical-align:top}
            .tg .tg-fm1b{background-color:#efefef;border-color:#000000;font-weight:bold;text-align:center;vertical-align:top}
            .tg .tg-wp8o{border-color:#000000;text-align:center;vertical-align:top}
            .tg .tg-wkkj{background-color:#efefef;border-color:#000000;font-weight:bold;text-align:left;vertical-align:top}
            .tg .tg-73oq{border-color:#000000;text-align:left;vertical-align:top}
        </style>
    </head>
    <body>
    <div class="table">
        <table class="tg">
            <thead>
            <tr>
                <th class="tg-3x8j" colspan="7">REPORTE DE PAGOS DE MATRICULAS</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="tg-fm1b">N°</td>
                <td class="tg-wkkj">APELLIDOS Y NOMBRES</td>
                <td class="tg-fm1b">NIVEL</td>
                <td class="tg-fm1b">GRADO</td>
                <td class="tg-fm1b">TIPO</td>
                <td class="tg-fm1b">MONTO</td>
                <td class="tg-fm1b">FECHA DE PAGO</td>
            </tr>
            @php $i = 1; @endphp
            @foreach($pagos as $pago)
            <tr>
                <td class="tg-wp8o">{{ $i }}</td>
                <td class="tg-73oq">{{ $pago->matricula->alumno->nombre_completo }}</td>
                <td class="tg-wp8o">{{ $pago->matricula->nivel == 'S' ? 'SECUNDARIA' : 'PRIMARIA' }}</td>
                <td class="tg-wp8o">{{ $pago->matricula->grado | grado }}</td>
                <td class="tg-wp8o">{{ $pago->tipo_pago | mp  }}</td>
                <td class="tg-wp8o" style="text-align: right;">S./ {{ $pago->monto_pagado }}</td>
                <td class="tg-wp8o">{{ $pago->fecha_deposito |dateFormat }}</td>
            </tr>
            @php $i++; @endphp
            @endforeach
            </tbody>
        </table>
    </div>
    <htmlpagefooter name="page-footer">
        Reporte generado el  <b>{{ date('d/m/Y') }}</b> por <b>{{ auth()->user()->name }}</b>
    </htmlpagefooter>
    </body>
</html>

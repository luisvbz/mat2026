<html>
<title>Reporte de Matriculas</title>
<head>
    <style type="text/css">
        .titulo {
            margin-bottom: 10px;
            text-align: center;
            font-size: 15px;

        }
        
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;
          overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg th{border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;
          font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;}
        .tg .tg-amwm{font-weight:bold;text-align:center;vertical-align:top}
        .tg .tg-yfcz{background-color:#ffffff;font-size:11px;text-align:left;vertical-align:top}
    </style>
</head>
<body>
    <div class="titulo">
        <b>REPORTE DE MATRICULAS AL {{ date('d/m/Y') }}</b>
    </div>
    <table style="border-collapse:collapse;border-spacing:0;">
        <thead>
            <tr style="background-color: #dedede;">
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;text-align: center; width: 5%;"><strong>N</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>ALUMNO</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>GRADO</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>EDAD</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>DIRECCIÓN</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>TELÉFONO</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>PADRE</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>MADRE</strong></th>
                <th style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:12px;           font-weight:normal;overflow:hidden;padding:10px 5px;word-break:normal;"><strong>COLEGIO</strong></th>
            </tr>
        </thead>
        <tbody>
        @foreach($matriculas as $m)
            <tr>
                <td  style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normaltext-align: center;">{{ $m->numero_matricula }}</td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;">{{ $m->alumno }}</td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;">{{ $m->grado }}</td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;text-align: center;">{{ $m->edad }}</td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;">{{ $m->direccion }}</td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;">{{ $m->telefono }} </td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;">{{ $m->padre }}</td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;">{{ $m->madre }}</td>
                <td style="border-color:black;border-style:solid;border-width:1px;font-family:Arial, sans-serif;font-size:10px;           overflow:hidden;padding:10px 5px;word-break:normal;">{{ $m->colegio_procedencia }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html>
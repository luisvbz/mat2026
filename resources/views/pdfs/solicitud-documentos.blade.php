<html>
<title>Solicitud {{ \Str::slug($solicitud->nombre_solicitante) }}-{{ $solicitud->created_at->format('Y') }}</title>
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
<div class="tabla-datos">
    <div style="text-align: center; padding-bottom: 5px; border-bottom: 1px solid #000; margin-bottom: 10px;">
        <img src="{{ asset('images/logo_web.png') }}" width="350px">
    </div>
</div>
<div>
    <p>SEÑORA DIRECTORA DE LA INSTITUCION EDUCATIVA DIVINO SALVADOR</p><br>
    <div>
        <p>Yo, <b>{{ $solicitud->nombre_solicitante }}</b> con <b>{{ $solicitud->tipo_documento_solicitante == 0 ? 'DNI' : 'CE'}}: {{ $solicitud->numero_documento_solicitante }}</b> @if($solicitud->is_apoderado), Apoderador de {{ $solicitud->nombre_alumno }} identificado con <b>{{ $solicitud->tipo_documento_alumno == 0 ? 'DNI' : 'CE'}}: {{ $solicitud->numero_documento_alumno }}</b> @endif. Me presento ante usted con el debido respeto de solicitar los siguientes documentos:</p>
    </div> 
    <div>
        <ul>
             @foreach($solicitud->documentos as $doc)
                <li>{{ $doc->nombre }}</li>
             @endforeach
        </ul>
    </div>
    <div>
        <p>POR LO EXPUESTO</p>
        <p>Pido a usted acceder a mi solicitud por ser de justicia.</p>
    </div>
    <div style="text-align:center;">
        <p>
            <b>{{ $solicitud->tipo_documento_solicitante == 0 ? 'DNI' : 'CE'}}:</b> {{ $solicitud->numero_documento_solicitante }}
        </p>
        <p>
            {{ $solicitud->nombre_solicitante }}
        </p>
        <p>
            <b>Teléfono Celular:</b> {{ $solicitud->numero_celular }}
        </p>
        <p>
            <b>Correo Electrónico:</b> {{ $solicitud->correo_electronico }}
        </p>
    </div>
</div>
<pagebreak page-selector="posterior"/>
<div class="tex-align:center; width: 100%;margin: 0 auto;">
    <img src="{{ storage_path('app/comprobantes/'.$solicitud->voucher)}}" style="max-width: 70%;"/>
</div>
<htmlpageheader name="page-header">
    <div style="text-align: right; font-size: 10px; padding-top: 5px;">
        {{ $solicitud->created_at | date:'d/m/Y' }}
    </div>
</htmlpageheader>
<htmlpagefooter name="page-footer">
    <div style="font-size: 10px; padding-bottom: 5px;">
        Generada el  <b>{{ $solicitud->created_at | date:'d/m/Y' }}</b>
    </div>
</htmlpagefooter>
</body>
</html>

Se ha generado una nueva solicitud de documentos en la plataforma:<br>
<b>Solicitante:</b> {{ $solicitud->nombre_solicitante }}<br>
<b>{{ $solicitud->tipo_documento_solicitante == 0 ? 'DNI' : 'CE' }}:</b> {{ $solicitud->numero_documento_solicitante }}<br>
<b>Teléfono:</b> {{ $solicitud->numero_celular }}<br>
<b>Correo:</b> {{ $solicitud->correo_electronico }}<br>
@if($solicitud->is_apoderado)
    <b>Alumno:</b> {{ $solicitud->nombre_alumno }}<br>
    <b>{{ $solicitud->tipo_documento_alumno == 0 ? 'DNI' : 'CE' }}:</b> {{ $solicitud->numero_documento_alumno }}<br>
@endif
<br>
<b>Documentos Solicitados</b>
<ul>
    @foreach($solicitud->documentos as $doc)
    <li>{{ $doc->nombre }}</li>
    @endforeach
</ul>

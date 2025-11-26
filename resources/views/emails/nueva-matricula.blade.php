Se ha generado una nueva matrícula en el sistema;<br>
<b>COD:</b> {{ $matricula->codigo }}<br>
<b>Alumno:</b> {{ $matricula->alumno->apellido_paterno.' '.$matricula->alumno->apellido_materno }}, {{ $matricula->alumno->nombres }}<br>
<b>Nivel/Grado:</b> {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}/{{ $matricula->grado | grado }}

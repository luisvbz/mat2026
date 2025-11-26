Se ha generado un nuevo pago en la plataforma:<br>
<b>Matrícula COD:</b> {{ $pago->matricula->codigo }}<br>
<b>Alumno:</b> {{ $pago->matricula->alumno->apellido_paterno.' '.$pago->matricula->alumno->apellido_materno }}, {{ $pago->matricula->alumno->nombres }}<br>
<b>Nivel/Grado:</b> {{ $pago->matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}/{{ $pago->matricula->grado | grado }}<br>
<b>Monto Registrado</b> {{ $pago->monto_pagado }}<br>
<b>Fecha de Pago: </b> {{ $pago->fecha_deposito | dateFormat }}<br>
<b>Tipo de pago:</b> {{ $pago->tipo_pago | mp }}<br>
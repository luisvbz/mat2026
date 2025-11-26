Se ha generado un nuevo pago por pensión en la plataforma:<br>
<b>Matrícula COD:</b> {{ $pension->matricula->codigo }}<br>
<b>Alumno:</b> {{ $pension->matricula->alumno->nombre_completo }}<br>
<b>Nivel/Grado:</b> {{ $pension->matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }}/{{ $pension->matricula->grado | grado }}<br>
<b>Mes Pagado</b> {{ $pension->mes | mes }}<br>
<b>Monto Pagado</b> {{ $pension->costo }}<br>
<b>Fecha de Pago: </b> {{ $pension->fecha_pago | dateFormat }}<br>

<table>
    <thead>
        <tr>
            <th style="background-color: #4f81bd; color: #ffffff; font-weight: bold;">Nombre del padre/madre
                (Solicitante)</th>
            <th style="background-color: #4f81bd; color: #ffffff; font-weight: bold;">Alumno</th>
            <th style="background-color: #4f81bd; color: #ffffff; font-weight: bold;">Nivel</th>
            <th style="background-color: #4f81bd; color: #ffffff; font-weight: bold;">Grado</th>
            <th style="background-color: #4f81bd; color: #ffffff; font-weight: bold;">Profesor</th>
            <th style="background-color: #4f81bd; color: #ffffff; font-weight: bold;">Fecha Y hora de la cita</th>
            <th style="background-color: #4f81bd; color: #ffffff; font-weight: bold;">Estado</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->parent->nombre_completo ?? 'N/A' }}</td>
                <td>{{ $appointment->student->nombre_completo ?? 'N/A' }}</td>
                <td>
                    @if ($appointment->student && $appointment->student->matricula)
                        {{ $appointment->student->matricula->nivel == 'P' ? 'Primaria' : 'Secundaria' }}
                    @else
                        N/A
                    @endif
                </td>
                <td>
                    @if ($appointment->student && $appointment->student->matricula)
                        {{ $appointment->student->matricula->grado }}
                    @else
                        N/A
                    @endif
                </td>
                <td>{{ $appointment->teacher->nombre_completo ?? 'N/A' }}</td>
                <td>
                    {{ $appointment->date->format('d/m/Y') }}
                    {{ $appointment->time ? $appointment->time->format('H:i') : '' }}
                </td>
                <td>
                    @switch($appointment->status)
                        @case('pending')
                            Pendiente
                        @break

                        @case('confirmed')
                            Confirmada
                        @break

                        @case('rejected')
                            Rechazada
                        @break

                        @case('completed')
                            Completada
                        @break

                        @case('cancelled')
                            Cancelada
                        @break

                        @default
                            {{ $appointment->status }}
                    @endswitch
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

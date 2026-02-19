<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f7eaea;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
        }

        .header {
            padding: 40px 20px;
            text-align: center;
            color: #ffffff;
        }

        .header img {
            height: 80px;
            margin-bottom: 15px;
        }

        .confirmed {
            background: #6E211F;
        }

        /* Usamos base institucional */
        .rejected {
            background: #2f100e;
        }

        /* Tono más oscuro/serio */
        .content {
            padding: 40px;
        }

        .footer {
            background: #fbf3e7;
            color: #7c4f2a;
            padding: 25px;
            text-align: center;
            font-size: 13px;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
            margin-top: 25px;
        }

        .btn-confirmed {
            background: #DA9C64;
            box-shadow: 0 4px 12px rgba(218, 156, 100, 0.3);
        }

        .btn-rejected {
            background: #6E211F;
        }

        .info-box {
            background: #fbf3e7;
            border-radius: 16px;
            padding: 25px;
            margin: 25px 0;
        }

        h1 {
            margin: 0;
            font-size: 26px;
        }

        .label {
            font-weight: bold;
            color: #6E211F;
            text-transform: uppercase;
            font-size: 11px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .status-confirmed {
            background: #f7eaea;
            color: #6E211F;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header {{ $appointment->status === 'confirmed' ? 'confirmed' : 'rejected' }}">
            <img src="https://2026.iepdivinosalvador.net.pe/images/logo.png" alt="IEP Divino Salvador">
            <h1>Actualización de Cita</h1>
        </div>
        <div class="content">
            <p>Estimado(a) <strong>{{ $appointment->parent->nombre_completo }}</strong>,</p>

            @if ($appointment->status === 'confirmed')
                <div class="status-badge status-confirmed">CITA CONFIRMADA</div>
                <p>El docente ha revisado su solicitud y ha <strong>confirmado</strong> la reunión.</p>

                <div class="info-box" style="border-left: 5px solid #DA9C64;">
                    <p><span class="label">Fecha Programada:</span><br>{{ $appointment->date->format('d/m/Y') }}</p>
                    <p><span class="label">Hora:</span><br>{{ $appointment->time->format('H:i') }}</p>
                    <p><span class="label">Docente:</span><br>{{ $appointment->teacher->nombre_completo }}</p>
                </div>

                <center>
                    <a href="https://app.iepdivinosalvador.net.pe/citas" class="btn btn-confirmed">Ver en Calendario</a>
                </center>
            @else
                <p>Le informamos que su solicitud de cita con el docente
                    <strong>{{ $appointment->teacher->nombre_completo }}</strong>
                    ha sido declinada o requiere reprogramación.
                </p>

                <div class="info-box" style="border-left: 5px solid #2f100e;">
                    <p>Si la reunión es urgente, por favor póngase en contacto con la secretaría de la institución o
                        intente
                        solicitar un nuevo horario a través del portal.</p>
                </div>

                <center>
                    <a href="https://app.iepdivinosalvador.net.pe/citas" class="btn btn-rejected">Ir a Mis Citas</a>
                </center>
            @endif
        </div>
        <div class="footer">
            <p><strong>IEP Divino Salvador</strong><br>Sistema de Calidad Educativa</p>
        </div>
    </div>
</body>

</html>

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
            background: #6E211F;
            color: #ffffff;
            padding: 40px 20px;
            text-align: center;
        }

        .header img {
            height: 80px;
            margin-bottom: 15px;
        }

        .content {
            padding: 40px;
        }

        .footer {
            background: #fbf3e7;
            color: #7c4f2a;
            padding: 25px;
            text-align: center;
            font-size: 13px;
            border-top: 1px solid #f3d4aa;
        }

        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: #DA9C64;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-weight: bold;
            margin-top: 25px;
            box-shadow: 0 4px 12px rgba(218, 156, 100, 0.3);
        }

        .info-box {
            background: #fbf3e7;
            border-radius: 16px;
            padding: 25px;
            margin: 25px 0;
            border-left: 5px solid #6E211F;
        }

        h1 {
            margin: 0;
            font-size: 26px;
            letter-spacing: -0.5px;
        }

        .label {
            font-weight: bold;
            color: #6E211F;
            text-transform: uppercase;
            font-size: 11px;
            display: block;
            margin-bottom: 4px;
        }

        .value {
            font-size: 16px;
            margin-bottom: 12px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://2026.iepdivinosalvador.net.pe/images/logo.png" alt="IEP Divino Salvador">
            <h1>Nueva Solicitud de Cita</h1>
        </div>
        <div class="content">
            <p>Estimado(a) docente <strong>{{ $appointment->teacher->nombre_completo }}</strong>,</p>
            <p>Se ha registrado una nueva solicitud de reunión en el portal escolar:</p>

            <div class="info-box">
                <span class="label">Padre / Madre</span>
                <span class="value">{{ $appointment->parent->nombre_completo }}</span>

                <span class="label">Estudiante</span>
                <span class="value">{{ $appointment->student->nombre_completo }}
                    ({{ $appointment->student->matricula->grado ?? 'N/A' }})</span>

                <span class="label">Fecha Propuesta</span>
                <span class="value">{{ $appointment->date ? $appointment->date->format('d/m/Y') : 'Pendiente' }}</span>

                <span class="label">Hora Propuesta</span>
                <span class="value">{{ $appointment->time ? $appointment->time->format('H:i') : 'Pendiente' }}</span>

                <span class="label">Motivo de la cita</span>
                <span class="value">{{ $appointment->subject }}</span>
            </div>

            <p>Por favor, ingrese al sistema para confirmar el horario propuesto o asignar uno nuevo según su
                disponibilidad.</p>

            <center>
                <a href="{{ config('app.frontend_url') }}/profesor/citas" class="btn">Gestionar en el Portal</a>
            </center>
        </div>
        <div class="footer">
            <p><strong>IEP Divino Salvador</strong><br>Sistema de Gestión Escolar &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>

</html>

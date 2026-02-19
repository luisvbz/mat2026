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
            background: #868686;
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
            font-size: 24px;
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

        .category-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            background: #f7eaea;
            color: #6E211F;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="https://2026.iepdivinosalvador.net.pe/images/logo.png" alt="IEP Divino Salvador">
            <h1>Aviso de Comunicación</h1>
        </div>
        <div class="content">
            <p>Estimado padre / madre de familia,</p>
            <p>Le informamos que se ha publicado una nueva comunicación en la plataforma escolar que podría ser de su
                interés:</p>

            <div class="info-box">
                <div class="category-tag">{{ strtoupper($communication->category) }}</div>

                <span class="label">Título</span>
                <span class="value">{{ $communication->title }}</span>

                <span class="label">Fecha</span>
                <span
                    class="value">{{ $communication->published_at ? $communication->published_at->format('d/m/Y H:i') : now()->format('d/m/Y H:i') }}</span>
            </div>

            <p>Para leer el contenido completo y descargar los archivos adjuntos (si los hubiera), por favor ingrese a
                la plataforma.</p>

            <center>
                <a href="https://app.iepdivinosalvador.net.pe/comunicado/{{ $communication->id }}" class="btn">Ver en
                    la Plataforma</a>
            </center>
        </div>
        <div class="footer">
            <p><strong>IEP Divino Salvador</strong><br>Sistema de Gestión Escolar &copy; {{ date('Y') }}</p>
        </div>
    </div>
</body>

</html>

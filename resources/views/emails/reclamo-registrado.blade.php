{{-- resources/views/emails/reclamo-registrado.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Reclamo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .header {
            background: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin: -20px -20px 20px -20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .info-box {
            background: #dbeafe;
            border: 1px solid #93c5fd;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .info-row {
            margin: 10px 0;
        }

        .info-label {
            font-weight: bold;
            color: #1e40af;
        }

        .footer {
            background: #f8fafc;
            padding: 15px;
            margin: 20px -20px -20px -20px;
            text-align: center;
            font-size: 12px;
            color: #64748b;
            border-radius: 0 0 8px 8px;
        }

        .success-badge {
            display: inline-block;
            background: #10b981;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
        }

        .important {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 12px;
            margin: 15px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🛡️ Confirmación de Registro</h1>
            <p style="margin: 5px 0 0 0;">Libro de Reclamaciones</p>
        </div>

        <div style="text-align: center; margin-bottom: 20px;">
            <span class="success-badge">✅ Reclamo Registrado Exitosamente</span>
        </div>

        <p>Estimado/a <strong>{{ $nombreCompleto }}</strong>,</p>

        <p>Su reclamo ha sido registrado exitosamente en nuestro sistema. A continuación, encontrará los detalles de su
            registro:</p>

        <div class="info-box">
            <div class="info-row">
                <span class="info-label">Número de Registro:</span>
                <strong style="font-size: 16px; color: #dc2626;">{{ $numeroRegistro }}</strong>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Registro:</span> {{ $fechaRegistro }}
            </div>
            <div class="info-row">
                <span class="info-label">Tipo:</span> {{ ucfirst($reclamo->tipo_reclamo) }}
            </div>
            <div class="info-row">
                <span class="info-label">Estado:</span> Pendiente
            </div>
        </div>

        <div class="important">
            <strong>📋 Resumen de su reclamo:</strong><br>
            <strong>Bien/Servicio:</strong> {{ $reclamo->tipo_bien }}<br>
            <strong>Fecha del Incidente:</strong> {{ $reclamo->fecha_incidente->format('d/m/Y') }}<br>
            @if ($reclamo->monto_reclamado)
                <strong>Monto Reclamado:</strong> {{ $reclamo->monto_formateado }}<br>
            @endif
        </div>

        <p><strong>Detalle del reclamo:</strong></p>
        <div style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 12px; border-radius: 4px; margin: 10px 0;">
            {{ $reclamo->detalle_reclamo }}
        </div>

        <p><strong>Su pedido:</strong></p>
        <div style="background: #f9fafb; border: 1px solid #e5e7eb; padding: 12px; border-radius: 4px; margin: 10px 0;">
            {{ $reclamo->pedido }}
        </div>

        <div class="important">
            <strong>⏰ Importante:</strong> Conforme al Decreto Supremo N° 011-2011-PCM, tenemos un plazo máximo de
            <strong>30 días calendario</strong> para responder a su reclamo. Le enviaremos una respuesta a este correo
            electrónico.
        </div>

        <p><strong>Sus datos de contacto registrados:</strong></p>
        <div style="background: #f3f4f6; padding: 12px; border-radius: 4px; margin: 10px 0;">
            <div class="info-row"><span class="info-label">Nombre:</span> {{ $reclamo->nombre_completo }}</div>
            <div class="info-row"><span class="info-label">Documento:</span>
                {{ strtoupper($reclamo->tipo_documento) }}: {{ $reclamo->numero_documento }}</div>
            <div class="info-row"><span class="info-label">Email:</span> {{ $reclamo->email }}</div>
            @if ($reclamo->telefono)
                <div class="info-row"><span class="info-label">Teléfono:</span> {{ $reclamo->telefono }}</div>
            @endif
            <div class="info-row"><span class="info-label">Dirección:</span> {{ $reclamo->direccion }},
                {{ $reclamo->distrito }}, {{ $reclamo->provincia }}, {{ $reclamo->departamento }}</div>

            @if ($reclamo->es_menor_edad && $reclamo->nombre_apoderado)
                <hr style="margin: 10px 0; border: none; border-top: 1px solid #d1d5db;">
                <div class="info-row"><span class="info-label">Apoderado:</span>
                    {{ $reclamo->nombre_apoderado_completo }}</div>
                <div class="info-row"><span class="info-label">DNI Apoderado:</span> {{ $reclamo->dni_apoderado }}
                </div>
            @endif
        </div>

        <p>Para cualquier consulta sobre su reclamo, puede contactarnos mencionando su número de registro:
            <strong>{{ $numeroRegistro }}</strong>
        </p>

        <div class="footer">
            <p><strong>Institución Educativa Privada Divino Salvador</strong><br>
                Este es un correo automático, por favor no responda a este mensaje.<br>
                <em>Generado el {{ now()->format('d/m/Y H:i') }}</em>
            </p>
        </div>
    </div>
</body>

</html>

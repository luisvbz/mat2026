<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo Reclamo Registrado</title>
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
            max-width: 700px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .header {
            background: #dc2626;
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

        .alert-box {
            background: #fee2e2;
            border: 1px solid #fecaca;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }

        .info-section {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 6px;
            margin: 15px 0;
        }

        .info-row {
            margin: 8px 0;
            display: flex;
        }

        .info-label {
            font-weight: bold;
            color: #374151;
            min-width: 140px;
        }

        .info-value {
            flex: 1;
        }

        .priority-high {
            color: #dc2626;
            font-weight: bold;
        }

        .status-pending {
            background: #fbbf24;
            color: white;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
        }

        .section-title {
            background: #1f2937;
            color: white;
            padding: 8px 12px;
            margin: 20px 0 10px 0;
            border-radius: 4px;
            font-weight: bold;
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

        .action-buttons {
            text-align: center;
            margin: 20px 0;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 5px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>🚨 Nuevo Reclamo Registrado</h1>
            <p style="margin: 5px 0 0 0;">Sistema de Libro de Reclamaciones</p>
        </div>

        <div class="alert-box">
            <strong>⚠️ Atención Administrador:</strong> Se ha registrado un nuevo reclamo que requiere su atención.
            Recuerde que tiene un plazo máximo de <strong>30 días calendario</strong> para responder conforme al D.S. N°
            011-2011-PCM.
        </div>

        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Número de Registro:</span>
                <span class="info-value priority-high">{{ $numeroRegistro }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha de Registro:</span>
                <span class="info-value">{{ $fechaRegistro }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Tipo:</span>
                <span class="info-value">{{ $tipoReclamo }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Estado:</span>
                <span class="info-value"><span class="status-pending">PENDIENTE</span></span>
            </div>
            <div class="info-row">
                <span class="info-label">Fecha del Incidente:</span>
                <span class="info-value">{{ $reclamo->fecha_incidente->format('d/m/Y') }}</span>
            </div>
            @if ($reclamo->monto_reclamado)
                <div class="info-row">
                    <span class="info-label">Monto Reclamado:</span>
                    <span class="info-value priority-high">{{ $reclamo->monto_formateado }}</span>
                </div>
            @endif
        </div>

        <div class="section-title">👤 Datos del Reclamante</div>
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Nombre Completo:</span>
                <span class="info-value">{{ $nombreCompleto }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Documento:</span>
                <span class="info-value">{{ strtoupper($reclamo->tipo_documento) }}:
                    {{ $reclamo->numero_documento }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-value">{{ $reclamo->email }}</span>
            </div>
            @if ($reclamo->telefono)
                <div class="info-row">
                    <span class="info-label">Teléfono:</span>
                    <span class="info-value">{{ $reclamo->telefono }}</span>
                </div>
            @endif
            <div class="info-row">
                <span class="info-label">Dirección:</span>
                <span class="info-value">{{ $reclamo->direccion }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Ubicación:</span>
                <span class="info-value">{{ $reclamo->distrito }}, {{ $reclamo->provincia }},
                    {{ $reclamo->departamento }}</span>
            </div>

            @if ($reclamo->es_menor_edad && $reclamo->nombre_apoderado)
                <div class="info-row">
                    <span class="info-label">⚠️ Menor de Edad:</span>
                    <span class="info-value">SÍ</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Apoderado:</span>
                    <span class="info-value">{{ $reclamo->nombre_apoderado_completo }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">DNI Apoderado:</span>
                    <span class="info-value">{{ $reclamo->dni_apoderado }}</span>
                </div>
                @if ($reclamo->telefono_apoderado)
                    <div class="info-row">
                        <span class="info-label">Tel. Apoderado:</span>
                        <span class="info-value">{{ $reclamo->telefono_apoderado }}</span>
                    </div>
                @endif
            @endif
        </div>

        <div class="section-title">🏷️ Bien o Servicio Reclamado</div>
        <div class="info-section">
            <div class="info-row">
                <span class="info-label">Tipo:</span>
                <span class="info-value">{{ $reclamo->tipo_bien }}</span>
            </div>
            <div class="info-row" style="align-items: flex-start;">
                <span class="info-label">Descripción:</span>
                <span class="info-value">{{ $reclamo->descripcion_bien }}</span>
            </div>
        </div>

        <div class="section-title">📋 Detalle del Reclamo</div>
        <div class="info-section">
            <p><strong>Detalle de los hechos:</strong></p>
            <div
                style="background: white; border: 1px solid #d1d5db; padding: 12px; border-radius: 4px; margin: 8px 0;">
                {{ $reclamo->detalle_reclamo }}
            </div>

            <p><strong>Pedido del reclamante:</strong></p>
            <div
                style="background: white; border: 1px solid #d1d5db; padding: 12px; border-radius: 4px; margin: 8px 0;">
                {{ $reclamo->pedido }}
            </div>

            @if ($reclamo->observaciones)
                <p><strong>Observaciones adicionales:</strong></p>
                <div
                    style="background: white; border: 1px solid #d1d5db; padding: 12px; border-radius: 4px; margin: 8px 0;">
                    {{ $reclamo->observaciones }}
                </div>
            @endif
        </div>

        <div class="action-buttons">
            <a href="{{ config('app.url') }}/admin/reclamos/{{ $reclamo->id }}" class="btn btn-primary">
                Ver Reclamo Completo
            </a>
            <a href="{{ config('app.url') }}/admin/reclamos" class="btn btn-secondary">
                Ir a Panel de Reclamos
            </a>
        </div>

        <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 12px; margin: 20px 0;">
            <strong>📅 Fecha límite de respuesta:</strong> {{ $reclamo->created_at->addDays(30)->format('d/m/Y') }}<br>
            <strong>⏱️ Días restantes:</strong> {{ $reclamo->created_at->addDays(30)->diffInDays(now()) }} días
        </div>

        <div class="footer">
            <p><strong>Sistema de Libro de Reclamaciones</strong><br>
                Institución Educativa Privada Divino Salvador<br>
                <em>Notificación automática generada el {{ now()->format('d/m/Y H:i') }}</em>
            </p>
        </div>
    </div>
</body>

</html>

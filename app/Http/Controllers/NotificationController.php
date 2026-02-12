<?php

namespace App\Http\Controllers;

use App\Services\OneSignalService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function __construct(
        protected OneSignalService $oneSignal
    ) {}

    // ────────────────────────────────────────────────────────────
    //  EJEMPLOS DE USO
    // ────────────────────────────────────────────────────────────

    /**
     * 1. Notificación simple a TODOS los suscriptores.
     *    Sin enlace.
     */
    public function notifyAll(): JsonResponse
    {
        $result = $this->oneSignal->sendToAll(
            title:   '¡Hola a todos! 👋',
            message: 'Tenemos novedades para ti.',
        );

        return response()->json($result);
    }

    /**
     * 2. Notificación con LINK a todos.
     *    Al hacer clic abrirá la URL indicada.
     */
    public function notifyAllWithLink(): JsonResponse
    {
        $result = $this->oneSignal->sendToAll(
            title:   '🚀 Nueva oferta disponible',
            message: 'Haz clic para ver los detalles de la promoción.',
            url:     'https://tu-sitio.com/ofertas/123',
        );

        return response()->json($result);
    }

    /**
     * 3. Notificación a un usuario específico por su Player ID.
     */
    public function notifyPlayer(string $playerId): JsonResponse
    {
        $result = $this->oneSignal->sendToPlayers(
            playerIds: $playerId,
            title:     '📦 Tu pedido está en camino',
            message:   'Estimado cliente, tu pedido #456 fue enviado.',
            url:       'https://tu-sitio.com/pedidos/456',
        );

        return response()->json($result);
    }

    /**
     * 4. Notificación a múltiples usuarios por Player IDs.
     */
    public function notifyMultiplePlayers(): JsonResponse
    {
        $playerIds = [
            'player-id-1',
            'player-id-2',
            'player-id-3',
        ];

        $result = $this->oneSignal->sendToPlayers(
            playerIds: $playerIds,
            title:     '📢 Mensaje para el equipo',
            message:   'Reunión a las 3pm hoy.',
            url:       'https://tu-sitio.com/reuniones/hoy',
        );

        return response()->json($result);
    }

    /**
     * 5. Notificación a usuarios por External User ID
     *    (tu propio ID de usuario mapeado en OneSignal).
     */
    public function notifyUser(int $userId): JsonResponse
    {
        $result = $this->oneSignal->sendToExternalUsers(
            externalIds: (string) $userId,
            title:       '🔔 Tienes un nuevo mensaje',
            message:     'Alguien te envió un mensaje privado.',
            url:         "https://tu-sitio.com/mensajes",
        );

        return response()->json($result);
    }

    /**
     * 6. Notificación a un segmento (creado en OneSignal Dashboard).
     *    Ejemplos de segmentos: 'Active Users', 'Inactive Users', 'Paid Users'
     */
    public function notifySegment(): JsonResponse
    {
        $result = $this->oneSignal->sendToSegments(
            segments: ['Active Users', 'Paid Users'],
            title:    '💎 Beneficio exclusivo',
            message:  'Como usuario activo tienes un 20% de descuento.',
            url:      'https://tu-sitio.com/descuento-exclusivo',
        );

        return response()->json($result);
    }

    /**
     * 7. Notificación con imagen.
     */
    public function notifyWithImage(): JsonResponse
    {
        $result = $this->oneSignal->sendWithImage(
            target:   ['included_segments' => ['All']],
            title:    '🖼️ ¡Mira esto!',
            message:  'Nueva colección disponible ahora.',
            imageUrl: 'https://tu-sitio.com/images/coleccion-banner.jpg',
            url:      'https://tu-sitio.com/coleccion',
        );

        return response()->json($result);
    }

    /**
     * 8. Notificación programada (se enviará en el futuro).
     */
    public function notifyScheduled(): JsonResponse
    {
        $result = $this->oneSignal->sendScheduled(
            target:      ['included_segments' => ['All']],
            title:       '⏰ Recordatorio',
            message:     'No olvides tu cita de mañana a las 10am.',
            scheduledAt: now()->addHours(18)->format('Y-m-d H:i:s') . ' UTC',
            url:         'https://tu-sitio.com/citas',
        );

        return response()->json($result);
    }

    /**
     * 9. Enviar notificación desde un Form Request.
     */
    public function sendFromRequest(Request $request): JsonResponse
    {
        $request->validate([
            'title'    => 'required|string|max:100',
            'message'  => 'required|string|max:500',
            'url'      => 'nullable|url',
            'segments' => 'nullable|array',
        ]);

        $segments = $request->input('segments', ['All']);

        $result = $this->oneSignal->sendToSegments(
            segments: $segments,
            title:    $request->title,
            message:  $request->message,
            url:      $request->url,
        );

        return response()->json($result);
    }

    /**
     * 10. Cancelar notificación programada.
     */
    public function cancel(string $notificationId): JsonResponse
    {
        $result = $this->oneSignal->cancel($notificationId);

        return response()->json($result);
    }

    /**
     * 11. Ver estado de una notificación enviada.
     */
    public function status(string $notificationId): JsonResponse
    {
        $result = $this->oneSignal->getNotification($notificationId);

        return response()->json($result);
    }
}

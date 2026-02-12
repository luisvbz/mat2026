<?php

namespace App\Tools;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OneSignalService
{
    /** @var string */
    protected $appId;

    /** @var string */
    protected $apiKey;

    /** @var string */
    protected $baseUrl = 'https://api.onesignal.com';

    public function __construct()
    {
        $this->appId  = config('onesignal.app_id');
        $this->apiKey = config('onesignal.api_key');
        
        Log::debug('OneSignal Config Loaded', [
            'app_id' => $this->appId,
            'api_key_prefix' => substr($this->apiKey, 0, 10) . '...'
        ]);
    }

    // ─────────────────────────────────────────────────
    //  MÉTODOS PRINCIPALES
    // ─────────────────────────────────────────────────

    /**
     * Enviar notificación a TODOS los suscriptores.
     *
     * @param  string  $title
     * @param  string  $message
     * @param  string|null  $url
     * @param  array  $extra
     * @return array
     */
    public function sendToAll($title, $message, $url = null, array $extra = []): array
    {
        $payload = $this->buildPayload(
            $title,
            $message,
            $url,
            ['included_segments' => ['All']],
            $extra
        );

        return $this->send($payload);
    }

    /**
     * Enviar notificación a uno o varios playerIds (device tokens).
     *
     * @param  string|array  $playerIds
     * @param  string  $title
     * @param  string  $message
     * @param  string|null  $url
     * @param  array  $extra
     * @return array
     */
    public function sendToPlayers($playerIds, $title, $message, $url = null, array $extra = []): array
    {
        $payload = $this->buildPayload(
            $title,
            $message,
            $url,
            ['include_player_ids' => (array) $playerIds],
            $extra
        );

        return $this->send($payload);
    }

    /**
     * Enviar notificación a uno o varios External User IDs.
     * Útil cuando mapeas tu propio user_id con OneSignal.
     *
     * @param  string|array  $externalIds
     * @param  string  $title
     * @param  string  $message
     * @param  string|null  $url
     * @param  array  $extra
     * @return array
     */
    public function sendToExternalUsers($externalIds, $title, $message, $url = null, array $extra = []): array
    {
        $payload = $this->buildPayload(
            $title,
            $message,
            $url,
            ['include_external_user_ids' => (array) $externalIds],
            $extra
        );

        return $this->send($payload);
    }

    /**
     * Enviar notificación a un segmento específico.
     * Los segmentos se crean en el dashboard de OneSignal.
     *
     * @param  string|array  $segments
     * @param  string  $title
     * @param  string  $message
     * @param  string|null  $url
     * @param  array  $extra
     * @return array
     */
    public function sendToSegments($segments, $title, $message, $url = null, array $extra = []): array
    {
        $payload = $this->buildPayload(
            $title,
            $message,
            $url,
            ['included_segments' => (array) $segments],
            $extra
        );

        return $this->send($payload);
    }

    /**
     * Enviar notificación con imagen adjunta.
     *
     * @param  array   $target
     * @param  string  $title
     * @param  string  $message
     * @param  string  $imageUrl
     * @param  string|null  $url
     * @param  array   $extra
     * @return array
     */
    public function sendWithImage(array $target, $title, $message, $imageUrl, $url = null, array $extra = []): array
    {
        $extra['big_picture']          = $imageUrl; // Android
        $extra['ios_attachments']      = ['image' => $imageUrl]; // iOS
        $extra['chrome_web_image']     = $imageUrl; // Web

        $payload = $this->buildPayload(
            $title,
            $message,
            $url,
            $target,
            $extra
        );

        return $this->send($payload);
    }

    /**
     * Programar una notificación para una fecha/hora específica (UTC).
     *
     * @param  array   $target
     * @param  string  $title
     * @param  string  $message
     * @param  \DateTimeInterface|string  $scheduledAt  Ej: '2025-12-25 09:00:00'
     * @param  string|null  $url
     * @param  array   $extra
     * @return array
     */
    public function sendScheduled(array $target, $title, $message, $scheduledAt, $url = null, array $extra = []): array
    {
        $extra['send_after'] = $scheduledAt instanceof \DateTimeInterface
            ? $scheduledAt->format('Y-m-d H:i:s \G\M\T')
            : $scheduledAt;

        $payload = $this->buildPayload(
            $title,
            $message,
            $url,
            $target,
            $extra
        );

        return $this->send($payload);
    }

    /**
     * Cancelar una notificación programada o en curso.
     *
     * @param  string  $notificationId
     * @return array
     */
    public function cancel(string $notificationId): array
    {
        $response = Http::withHeaders($this->headers())
            ->delete("{$this->baseUrl}/notifications/{$notificationId}", [
                'app_id' => $this->appId,
            ]);

        return $this->parseResponse($response);
    }

    /**
     * Consultar el estado / estadísticas de una notificación enviada.
     *
     * @param  string  $notificationId
     * @return array
     */
    public function getNotification(string $notificationId): array
    {
        $response = Http::withHeaders($this->headers())
            ->get("{$this->baseUrl}/notifications/{$notificationId}", [
                'app_id' => $this->appId,
            ]);

        return $this->parseResponse($response);
    }

    // ─────────────────────────────────────────────────
    //  HELPERS INTERNOS
    // ─────────────────────────────────────────────────

    /**
     * Construye el payload base para la API de OneSignal.
     *
     * @param  string       $title
     * @param  string       $message
     * @param  string|null  $url
     * @param  array        $target
     * @param  array        $extra
     * @return array
     */
    protected function buildPayload($title, $message, $url, array $target, array $extra = []): array
    {
        $payload = array_merge([
            'app_id'   => $this->appId,
            'headings' => ['en' => $title],
            'contents' => ['en' => $message],
        ], $target, $extra);

        // URL de destino al hacer clic
        if ($url) {
            $payload['url'] = $url;
        }

        return $payload;
    }

    /**
     * Realiza el POST a la API de OneSignal.
     *
     * @param  array  $payload
     * @return array
     */
    protected function send(array $payload): array
    {
        try {
            $response = Http::withHeaders($this->headers())
                ->post("{$this->baseUrl}/notifications?c=push", $payload);

                /// Quiero ver el request enviado completo
                

            $result = $this->parseResponse($response);

            if (isset($result['errors'])) {
                Log::warning('OneSignal warning', ['errors' => $result['errors'], 'payload' => $payload]);
            }

            return $result;
        } catch (\Throwable $e) {
            Log::error('OneSignal request failed', [
                'error'   => $e->getMessage(),
                'payload' => $payload,
            ]);

            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Cabeceras HTTP requeridas por OneSignal.
     *
     * @return array
     */
    protected function headers(): array
    {
        // OneSignal V2 / Organization keys use 'Key' scheme instead of 'Basic'
        $prefix = strpos($this->apiKey, 'os_v2_') === 0 ? 'Key' : 'Basic';

        return [
            'Authorization' => "Key {$this->apiKey}"
        ];
    }

    /**
     * Normaliza la respuesta HTTP en un array.
     *
     * @param  \Illuminate\Http\Client\Response  $response
     * @return array
     */
    protected function parseResponse(\Illuminate\Http\Client\Response $response): array
    {
        $data = $response->json() ?? [];

        if (! $response->successful()) {
            Log::error('OneSignal API error', [
                'status' => $response->status(),
                'body'   => $data,
            ]);
        }

        return array_merge(['http_status' => (int) $response->status()], $data);
    }
}

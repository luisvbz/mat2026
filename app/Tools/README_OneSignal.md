# 🔔 OneSignal Service para Laravel

Servicio para enviar notificaciones push desde Laravel usando la API REST de OneSignal v1, incluyendo soporte para enviar links al hacer clic.

---

## 📁 Archivos incluidos

| Archivo | Destino en tu proyecto |
|---|---|
| `OneSignalService.php` | `app/Services/OneSignalService.php` |
| `onesignal.php` | `config/onesignal.php` |
| `NotificationController.php` | `app/Http/Controllers/NotificationController.php` |

---

## ⚙️ Instalación

### 1. Copia los archivos

```bash
# Crear directorio si no existe
mkdir -p app/Services

# Copiar archivos
cp OneSignalService.php app/Services/OneSignalService.php
cp onesignal.php config/onesignal.php
cp NotificationController.php app/Http/Controllers/NotificationController.php
```

### 2. Agrega tus credenciales en `.env`

```env
ONESIGNAL_APP_ID=tu-app-id-aqui
ONESIGNAL_API_KEY=tu-rest-api-key-aqui
```

> Encuéntralos en: **OneSignal Dashboard → Settings → Keys & IDs**

### 3. Limpia el caché de configuración

```bash
php artisan config:clear
```

---

## 🛣️ Rutas de ejemplo (routes/api.php)

```php
use App\Http\Controllers\NotificationController;

Route::prefix('notifications')->group(function () {
    Route::post('all',              [NotificationController::class, 'notifyAll']);
    Route::post('all-with-link',    [NotificationController::class, 'notifyAllWithLink']);
    Route::post('player/{id}',      [NotificationController::class, 'notifyPlayer']);
    Route::post('user/{id}',        [NotificationController::class, 'notifyUser']);
    Route::post('segment',          [NotificationController::class, 'notifySegment']);
    Route::post('send',             [NotificationController::class, 'sendFromRequest']);
    Route::delete('{id}',           [NotificationController::class, 'cancel']);
    Route::get('{id}/status',       [NotificationController::class, 'status']);
});
```

---

## 🚀 Uso básico en cualquier clase

```php
use App\Services\OneSignalService;

// Inyección de dependencia (recomendado)
public function __construct(protected OneSignalService $oneSignal) {}

// O instanciación directa
$oneSignal = app(OneSignalService::class);
```

---

## 📋 Métodos disponibles

### `sendToAll(title, message, url?, extra?)`
Envía a **todos** los suscriptores.

```php
$this->oneSignal->sendToAll(
    title:   '¡Novedad!',
    message: 'Tenemos algo nuevo para ti.',
    url:     'https://tu-sitio.com/novedad', // 👈 link al hacer clic
);
```

---

### `sendToPlayers(playerIds, title, message, url?, extra?)`
Envía a uno o varios **Player IDs** (device tokens de OneSignal).

```php
$this->oneSignal->sendToPlayers(
    playerIds: ['abc-123', 'def-456'],
    title:     'Hola',
    message:   'Este mensaje es solo para ti.',
    url:       'https://tu-sitio.com/perfil',
);
```

---

### `sendToExternalUsers(externalIds, title, message, url?, extra?)`
Envía usando tu propio **ID de usuario** (requiere tener mapeado el external_id en OneSignal).

```php
$this->oneSignal->sendToExternalUsers(
    externalIds: '42',   // o un array: ['42', '99']
    title:       'Nuevo mensaje',
    message:     'Tienes una respuesta.',
    url:         'https://tu-sitio.com/mensajes',
);
```

---

### `sendToSegments(segments, title, message, url?, extra?)`
Envía a un **segmento** definido en el dashboard de OneSignal.

```php
$this->oneSignal->sendToSegments(
    segments: ['Active Users'],
    title:    'Oferta exclusiva',
    message:  '20% de descuento solo hoy.',
    url:      'https://tu-sitio.com/oferta',
);
```

---

### `sendWithImage(target, title, message, imageUrl, url?, extra?)`
Envía con una **imagen** (soporta Android, iOS y Web).

```php
$this->oneSignal->sendWithImage(
    target:   ['included_segments' => ['All']],
    title:    '¡Mira esto!',
    message:  'Nueva colección disponible.',
    imageUrl: 'https://tu-sitio.com/banner.jpg',
    url:      'https://tu-sitio.com/coleccion',
);
```

---

### `sendScheduled(target, title, message, scheduledAt, url?, extra?)`
**Programa** una notificación para enviar en el futuro.

```php
$this->oneSignal->sendScheduled(
    target:      ['included_segments' => ['All']],
    title:       'Recordatorio',
    message:     'Tu evento empieza en 1 hora.',
    scheduledAt: now()->addHour()->format('Y-m-d H:i:s') . ' UTC',
    url:         'https://tu-sitio.com/evento',
);
```

---

### `cancel(notificationId)`
**Cancela** una notificación programada o en progreso.

```php
$this->oneSignal->cancel('notification-uuid-aqui');
```

---

### `getNotification(notificationId)`
Obtiene el **estado y estadísticas** de una notificación.

```php
$data = $this->oneSignal->getNotification('notification-uuid-aqui');
// $data['successful'], $data['failed'], $data['remaining'], etc.
```

---

## 🔗 El parámetro `url` (link al hacer clic)

Cuando pasas el parámetro `url`, OneSignal abre esa URL al hacer clic en la notificación:

- **Web Push**: abre una nueva pestaña del navegador.
- **Android**: abre el navegador o la app según el esquema de la URL (puede ser `https://...` o deep link como `miapp://ruta`).
- **iOS**: igual que Android.

### Deep links (app móvil)

```php
// URL web normal
url: 'https://tu-sitio.com/productos/99'

// Deep link para app Android/iOS
url: 'miapp://productos/99'
```

---

## 📦 Respuesta de la API

```json
{
    "http_status": 200,
    "id": "notification-uuid",
    "recipients": 1500,
    "external_id": null
}
```

En caso de error:

```json
{
    "http_status": 400,
    "errors": ["All included players are not subscribed"]
}
```

---

## ✅ Requisitos

- **Laravel** 9, 10 u 11
- **PHP** 8.1+
- `illuminate/http` (incluido en Laravel)
- Cuenta en [OneSignal](https://onesignal.com) (plan gratuito disponible)

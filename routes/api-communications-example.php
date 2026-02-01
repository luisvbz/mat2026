/*
|--------------------------------------------------------------------------
| API Routes - Comunicados
|--------------------------------------------------------------------------
|
| Agrega estas rutas a tu archivo routes/api.php
|
*/

use App\Http\Controllers\Api\CommunicationController;

Route::middleware('auth:sanctum')->group(function () {
    
    // Listar todos los comunicados publicados
    // GET /api/communications
    // Query params: ?category=academico
    Route::get('/communications', [CommunicationController::class, 'index']);
    
    // Obtener un comunicado específico
    // GET /api/communications/{id}
    Route::get('/communications/{id}', [CommunicationController::class, 'show']);
    
    // Marcar comunicado como leído
    // POST /api/communications/{id}/mark-read
    Route::post('/communications/{id}/mark-read', [CommunicationController::class, 'markAsRead']);
    
    // Estadísticas de lectura (solo para administradores)
    // GET /api/communications/{id}/stats
    Route::get('/communications/{id}/stats', [CommunicationController::class, 'readStats']);
});

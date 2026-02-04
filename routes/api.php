<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\Api\AgendaController;
use App\Http\Controllers\Api\CommonController;
use App\Http\Controllers\Api\ParentController;
use App\Http\Controllers\Api\CuentasController;
use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AsistenciasController;
use App\Http\Controllers\Api\CommunicationController;
use App\Http\Controllers\Api\TacherController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/bot-telegram', [\App\Http\Controllers\TelegramController::class, 'updates']);

Route::post('/auth/login', [AuthController::class, 'login']);
// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    // Rutas comunes
    Route::get('/grades/{level}', [CommonController::class, 'getGrades']);
    Route::get('/grades/{gradeId}/students', [CommonController::class, 'getStudentsByGrade']);
    Route::get('/teachers', [CommonController::class, 'getTeacherUsers']);

    Route::prefix('parent')->group(function () {
        Route::get('/children', [\App\Http\Controllers\Api\ParentController::class, 'children']);
        Route::get('/children/{childId}/agenda', [AgendaController::class, 'getMessages']);
        Route::put('/children/{childId}/agenda/{messageId}/read', [AgendaController::class, 'markAsRead']);
        Route::post('/children/{childId}/agenda/{messageId}/reply', [AgendaController::class, 'replyToMessage']);
        Route::get('/children/{childId}/asistencia', [AsistenciasController::class, 'getAttendanceByChild']);
        Route::get('/children/{childId}/cuentas', [CuentasController::class, 'getEstadoCuenta']);

        Route::get('/communications', [CommunicationController::class, 'index']);
        Route::get('/communications/{id}', [CommunicationController::class, 'show']);
        Route::post('/communications/{id}/mark-read', [CommunicationController::class, 'markAsRead']);
        Route::get('/communications/{id}/stats', [CommunicationController::class, 'readStats']);

        Route::get('/appointments', [AppointmentController::class, 'parentIndex']);
        Route::post('/appointments', [AppointmentController::class, 'parentStore']);
    });

    Route::prefix('teacher')->group(function () {
        // Agenda
        Route::get('/agendas/stats', [TacherController::class, 'getStats']);
        Route::get('/students/agendas', [AgendaController::class, 'getMyAgendasTeacher']);
        Route::get('/students/agendas/{studentId}', [AgendaController::class, 'getAgendaByTeacher']);
        Route::post('/students/agenda/{messageId}/mark-as-read', [AgendaController::class, 'markMessageAsRead']);
        Route::post('/students/{studentId}/agenda', [AgendaController::class, 'writeMessage']);

        Route::get('/appointments', [AppointmentController::class, 'teacherIndex']);
        Route::put('/appointments/{id}/confirm', [AppointmentController::class, 'teacherConfirm']);
        Route::put('/appointments/{id}/reject', [AppointmentController::class, 'teacherReject']);


        // Citas
        /* Route::get('/appointments', [AppointmentController::class, 'teacherIndex']);
        Route::post('/appointments', [AppointmentController::class, 'teacherStore']);
        Route::put('/appointments/{id}/confirm', [AppointmentController::class, 'teacherConfirm']);
        Route::put('/appointments/{id}/reject', [AppointmentController::class, 'teacherReject']); */
    });
});

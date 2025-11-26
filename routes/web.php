<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', \App\Http\Livewire\Frontend\Index::class)->name('principal');
Route::get('/matricular', \App\Http\Livewire\Frontend\Matricular::class)->name('matricular');
Route::get('/libro-de-reclamaciones', \App\Http\Livewire\Frontend\LibroReclamaciones::class)->name('libro.reclamaciones');
Route::get('/registrar-pago', \App\Http\Livewire\Frontend\RegistrarPago::class)->name('registrar.pago');
Route::get('/estado-de-cuenta', \App\Http\Livewire\Frontend\EstadoCuenta::class)->name('estado.cuenta');
Route::get('/consultar-matricula/{codigo?}', \App\Http\Livewire\Frontend\ConsultarMatricula::class)->name('consultar.matricula');
Route::get('/solicitud-de-documentos', \App\Http\Livewire\Frontend\SolicitudDocumentos::class)->name('solicitud.documentos');
Route::get('/reserva-de-citas', \App\Http\Livewire\Frontend\ReservaDeCitas::class)->name('reserva-de-citas');
Route::get('/asistencia/{token}', \App\Http\Livewire\Asistencia\Index::class)->name('asistencias');
Route::get('/ver-asistencias', \App\Http\Livewire\Asistencia\VerAsistencia::class)->name('ver.asistencias');


Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');

    //return bcrypt('silvanaiepds2023');
});

Route::get('/enviar-recordatotrio', function () {
    //Artisan::call('test:cron');
    Artisan::call('verificar:deudores');
})->middleware('auth');

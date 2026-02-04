<?php

use Illuminate\Support\Facades\Route;



Route::middleware(['auth'])->group(function () {
    Route::get('/', \App\Http\Livewire\Dashboard\Index::class)->name('dashboard.principal')->middleware('role:Admin|Operador');
    Route::get('/matriculas', \App\Http\Livewire\Dashboard\Matriculas\Index::class)->name('dashboard.matriculas')->middleware('role:Admin|Operador');
    Route::get('/matriculas/migrar', \App\Http\Livewire\Dashboard\Matriculas\MatricularAntiguo::class)->name('dashboard.matriculas-old')->middleware('role:Admin|Operador');
    Route::get('/solcitudes-de-documentos', \App\Http\Livewire\Dashboard\Solicitudes::class)->name('dashboard.solicitudes')->middleware('role:Admin|Operador');
    Route::get('/recordatorios', \App\Http\Livewire\Dashboard\Recordatorios::class)->name('dashboard.recordatorios')->middleware('role:Admin|Operador');
    Route::get('/matriculas/{codigo}/detalle', \App\Http\Livewire\Dashboard\Matriculas\Detalle::class)->name('dashboard.detalle-matricula')->middleware('role:Admin|Operador');
    Route::get('/contabilidad', \App\Http\Livewire\Dashboard\Contabilidad\Index::class)->name('dashboard.contabilidad')->middleware('role:Admin|Operador');
    Route::get('/contabilidad/pagos-matriculas', \App\Http\Livewire\Dashboard\Pagos\Index::class)->name('contabilidad.pagos-matricula')->middleware('role:Admin|Operador');
    Route::get('/contabilidad/pagos-pensiones', \App\Http\Livewire\Dashboard\Contabilidad\PagosPensiones::class)->name('contabilidad.pagos-pensiones')->middleware('role:Admin|Operador');
    Route::get('/contabilidad/reportes', \App\Http\Livewire\Dashboard\Contabilidad\Reportes::class)->name('contabilidad.reportes')->middleware('role:Admin|Operador');
    Route::get('/contabilidad/cronograma-de-pagos', \App\Http\Livewire\Dashboard\Contabilidad\Cronograma::class)->name('contabilidad.cronograma')->middleware('role:Admin|Operador');
    Route::get('/configuracion-general', \App\Http\Livewire\Dashboard\Configuracion::class)
        ->middleware('role:Admin')
        ->name('dashboard.configuracion');

    Route::get('/asistencias', \App\Http\Livewire\Dashboard\Asistencias\Index::class)
        ->name('asistencias.index');
    Route::get('/asistencias/inasistentes', \App\Http\Livewire\Dashboard\Asistencias\Inasistentes::class)
        ->name('asistencias.inasistentes');

    Route::get('/asistencias-profesores', \App\Http\Livewire\Dashboard\Asistencias\Personal\Asistencias\Lista::class)
        ->name('asistencias.profesores.index');

    Route::get('/permisos-profesores', \App\Http\Livewire\Dashboard\Asistencias\Personal\Permisos\Index::class)
        ->name('permisos-profesores.index');

    Route::get('/permisos-profesores/nuevo', \App\Http\Livewire\Dashboard\Asistencias\Personal\Permisos\Nuevo::class)
        ->name('permisos-profesores.nuevo');

    Route::get('/permisos-profesores/{id}/editat', \App\Http\Livewire\Dashboard\Asistencias\Personal\Permisos\Editar::class)
        ->name('permisos-profesores.editar');

    Route::get('/permisos-alumnos', \App\Http\Livewire\Dashboard\Asistencias\Permisos\Index::class)
        ->name('permisos-alumnos.index');

    Route::get('/permisos-alumnos/nuevo', \App\Http\Livewire\Dashboard\Asistencias\Permisos\Nuevo::class)
        ->name('permisos-alumnos.nuevo');

    Route::get('/permisos-alumnos/{id}/editat', \App\Http\Livewire\Dashboard\Asistencias\Permisos\Edita::class)
        ->name('permisos-alumnos.editar');

    Route::get('/marcacion', \App\Http\Livewire\Dashboard\Asistencias\Marcacion::class)
        ->name('marcacion');

    Route::get('/profesores', \App\Http\Livewire\Dashboard\Profesores\Index::class)->name('dashboard.profesores')->middleware('role:Admin|Operador');
    Route::get('/profesores/nuevo', \App\Http\Livewire\Dashboard\Profesores\Nuevo::class)->name('dashboard.profesores.nuevo')->middleware('role:Admin|Operador');
    Route::get('/profesores/{id}/editar', \App\Http\Livewire\Dashboard\Profesores\Editar::class)->name('dashboard.profesores.editar')->middleware('role:Admin|Operador');
    Route::get('/profesores/{id}/detalle', \App\Http\Livewire\Dashboard\Profesores\Detalle::class)->name('dashboard.profesores.detalle')->middleware('role:Admin|Operador');
    Route::get('/profesores/horarios', \App\Http\Livewire\Dashboard\Profesores\Horarios::class)->name('dashboard.profesores.horarios')->middleware('role:Admin|Operador');
    Route::get('/comunicados', \App\Http\Livewire\Dashboard\Comunicados::class)->name('dashboard.comunicados')->middleware('role:Admin|Operador');
    Route::get('/comunicados/crear', \App\Http\Livewire\Dashboard\Comunicados\Crear::class)->name('dashboard.comunicados.crear')->middleware('role:Admin|Operador');
    Route::get('/comunicados/{id}/editar', \App\Http\Livewire\Dashboard\Comunicados\Editar::class)->name('dashboard.comunicados.editar')->middleware('role:Admin|Operador');
});

Route::get('/login', \App\Http\Livewire\Dashboard\Login::class)->name('admin.login');

@php
    $route = Route::currentRouteName();
@endphp
<div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('dashboard.profesores') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'dashboard.profesores' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'dashboard.profesores' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-users text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Profesores</h3>
            <p class="text-xs text-gray-500">Listado Maestro</p>
        </div>
    </a>

    <a href="{{ route('dashboard.profesores.nuevo') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'dashboard.profesores.nuevo' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'dashboard.profesores.nuevo' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-user-plus text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Nuevo</h3>
            <p class="text-xs text-gray-500">Registrar Personal</p>
        </div>
    </a>

    <a href="{{ route('dashboard.profesores.horarios') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'dashboard.profesores.horarios' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'dashboard.profesores.horarios' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-clock text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Horarios</h3>
            <p class="text-xs text-gray-500">Gestión de Turnos</p>
        </div>
    </a>

    <a href="{{ route('asistencias.profesores.index') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'asistencias.profesores.index' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'asistencias.profesores.index' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-calendar-blank text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Asistencia</h3>
            <p class="text-xs text-gray-500">Control Diario</p>
        </div>
    </a>
</div>

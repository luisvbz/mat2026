<div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('asistencias.index') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'asistencias.index' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'asistencias.index' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-calendar-check text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Asistencias</h3>
            <p class="text-xs text-gray-500">Estudiantes</p>
        </div>
    </a>

    <a href="{{ route('permisos-alumnos.index') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'permisos-alumnos.index' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'permisos-alumnos.index' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-file-text text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Permisos</h3>
            <p class="text-xs text-gray-500">Alumno</p>
        </div>
    </a>

    <a href="{{ route('asistencias.profesores.index') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'asistencias.profesores.index' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'asistencias.profesores.index' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-users-three text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Asistencia</h3>
            <p class="text-xs text-gray-500">Personal</p>
        </div>
    </a>

    <a href="{{ route('permisos-profesores.index') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'permisos-profesores.index' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'permisos-profesores.index' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-clipboard-text text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Permisos</h3>
            <p class="text-xs text-gray-500">Personal</p>
        </div>
    </a>
</div>

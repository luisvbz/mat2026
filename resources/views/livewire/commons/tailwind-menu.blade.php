<div class="flex flex-col h-full bg-white border-r border-gray-200">
    <!-- Logo -->
    <div class="flex items-center justify-center p-6 border-b border-gray-100">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Institucional" class="h-16 object-contain" />
    </div>

    <!-- Menu Items -->
    <div class="flex-1 overflow-y-auto py-4">
        <nav class="space-y-1 px-3">
            <a href="{{ route('dashboard.principal') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'dashboard.principal') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-house text-2xl w-6 text-center {{ str_starts_with($route, 'dashboard.principal') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Inicio</span>
            </a>

            <a href="{{ route('dashboard.matriculas') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'dashboard.matriculas') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-student text-2xl w-6 text-center {{ str_starts_with($route, 'dashboard.matriculas') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Matrículas</span>
            </a>

            <a href="{{ route('dashboard.contabilidad') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'dashboard.contabilidad') || str_starts_with($route, 'contabilidad.') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-money text-2xl w-6 text-center {{ str_starts_with($route, 'dashboard.contabilidad') || str_starts_with($route, 'contabilidad.') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Contabilidad</span>
            </a>

            <a href="{{ route('asistencias.index') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'asistencias') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-user-check text-2xl w-6 text-center {{ str_starts_with($route, 'asistencias') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Asistencias</span>
            </a>

            <a href="{{ route('asistencias.inasistentes') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'asistencias.inasistentes' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-calendar-blank text-2xl w-6 text-center {{ $route == 'asistencias.inasistentes' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Inasistencias HOY</span>
            </a>

            <a href="{{ route('dashboard.profesores') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'dashboard.profesores') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-chalkboard-teacher text-2xl w-6 text-center {{ str_starts_with($route, 'dashboard.profesores') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Profesores</span>
            </a>

            <a href="{{ route('dashboard.citas') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'dashboard.citas') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-calendar-check text-2xl w-6 text-center {{ str_starts_with($route, 'dashboard.citas') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Citas</span>
            </a>

            <a href="{{ route('dashboard.comunicados') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'dashboard.comunicados') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-megaphone text-2xl w-6 text-center {{ str_starts_with($route, 'dashboard.comunicados') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Comunicados</span>
            </a>

            <a href="{{ route('dashboard.eventos') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ str_starts_with($route, 'dashboard.eventos') ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-calendar-star text-2xl w-6 text-center {{ str_starts_with($route, 'dashboard.eventos') ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Eventos</span>
            </a>

            {{--   <a href="{{ route('dashboard.recordatorios') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.recordatorios' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="ph ph-clock text-2xl w-6 text-center {{ $route == 'dashboard.recordatorios' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Recordatorios</span>
            </a>

            @if ($isAdmin)
                <a href="{{ route('dashboard.configuracion') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
                   {{ $route == 'dashboard.configuracion' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                    <i
                        class="ph ph-gear text-2xl w-6 text-center {{ $route == 'dashboard.configuracion' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                    <span class="ml-3 font-medium">Configuración</span>
                </a>
            @endif --}}
        </nav>
    </div>

    <!-- User & Logout -->
    <div class="p-4 border-t border-gray-100">
        <button wire:click="logout"
            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-red-600 transition-colors bg-red-50 rounded-xl hover:bg-red-100 hover:text-red-700">
            <i class="ph ph-sign-out text-xl text-center"></i>
            <span class="ml-2 font-semibold">Cerrar Sesión</span>
        </button>
    </div>
</div>

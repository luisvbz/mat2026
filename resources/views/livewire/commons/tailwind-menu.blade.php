<div class="flex flex-col h-full bg-white border-r border-gray-200">
    <!-- Logo -->
    <div class="flex items-center justify-center p-6 border-b border-gray-100">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Instittucional" class="h-16 object-contain" />
    </div>

    <!-- Menu Items -->
    <div class="flex-1 overflow-y-auto py-4">
        <nav class="space-y-1 px-3">
            <a href="{{ route('dashboard.principal') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.principal' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-home w-6 text-center {{ $route == 'dashboard.principal' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Inicio</span>
            </a>

            <a href="{{ route('dashboard.matriculas') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.matriculas' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-graduation-cap w-6 text-center {{ $route == 'dashboard.matriculas' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Matrículas</span>
            </a>

            <a href="{{ route('dashboard.contabilidad') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.contabilidad' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-money-bill w-6 text-center {{ $route == 'dashboard.contabilidad' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Contabilidad</span>
            </a>

            <a href="{{ route('asistencias.index') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'asistencias.index' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-user-check w-6 text-center {{ $route == 'asistencias.index' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Asistencias</span>
            </a>

            <a href="{{ route('asistencias.inasistentes') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'asistencias.inasistentes' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-calendar-day w-6 text-center {{ $route == 'asistencias.inasistentes' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Inasistencias HOY</span>
            </a>

            <a href="{{ route('dashboard.profesores') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.profesores' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-chalkboard-teacher w-6 text-center {{ $route == 'dashboard.profesores' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Profesores</span>
            </a>

            <a href="{{ route('dashboard.citas') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.citas' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-calendar-alt w-6 text-center {{ $route == 'dashboard.citas' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Citas</span>
            </a>

            <a href="{{ route('dashboard.comunicados') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ in_array($route, ['dashboard.comunicados', 'dashboard.comunicados.stats']) ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-bullhorn w-6 text-center {{ in_array($route, ['dashboard.comunicados', 'dashboard.comunicados.stats']) ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Comunicados</span>
            </a>

            <a href="{{ route('dashboard.eventos') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.eventos' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-calendar w-6 text-center {{ $route == 'dashboard.eventos' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Eventos</span>
            </a>

            <a href="{{ route('dashboard.recordatorios') }}"
                class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
               {{ $route == 'dashboard.recordatorios' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                <i
                    class="fas fa-clock w-6 text-center {{ $route == 'dashboard.recordatorios' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                <span class="ml-3 font-medium">Recordatorios</span>
            </a>

            @if ($isAdmin)
                <a href="{{ route('dashboard.configuracion') }}"
                    class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 group 
                   {{ $route == 'dashboard.configuracion' ? 'bg-colegio-500 text-white shadow-md' : 'text-gray-600 hover:bg-colegio-50 hover:text-colegio-600' }}">
                    <i
                        class="fas fa-cogs w-6 text-center {{ $route == 'dashboard.configuracion' ? 'text-white' : 'text-gray-400 group-hover:text-colegio-500' }}"></i>
                    <span class="ml-3 font-medium">Configuración</span>
                </a>
            @endif
        </nav>
    </div>

    <!-- User & Logout -->
    <div class="p-4 border-t border-gray-100">
        <button wire:click="logout"
            class="flex items-center justify-center w-full px-4 py-3 text-sm font-medium text-red-600 transition-colors bg-red-50 rounded-xl hover:bg-red-100 hover:text-red-700">
            <i class="fas fa-sign-out-alt w-5 text-center"></i>
            <span class="ml-2">Cerrar Sesión</span>
        </button>
    </div>
</div>

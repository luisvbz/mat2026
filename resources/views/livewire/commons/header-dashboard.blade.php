<div class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between sticky top-0 z-30 shadow-sm">
    <div class="flex items-center">
        <!-- Placeholder for breadcrumbs or page title -->
        <h2 class="text-lg font-medium text-gray-800 hidden sm:block">Panel de Administración</h2>
    </div>

    <div class="flex items-center space-x-4">
        <div class="flex items-center group cursor-default">
            <div class="flex flex-col items-end mr-3">
                <span
                    class="text-sm font-bold text-gray-800 group-hover:text-colegio-600 transition-colors">{{ auth()->user()->name }}</span>
                <span
                    class="text-xs text-gray-500">{{ auth()->user()->hasRole('Admin') ? 'Administrador' : 'Operador' }}</span>
            </div>
            <div
                class="bg-gradient-to-tr from-colegio-500 to-colegio-400 text-white w-10 h-10 rounded-xl shadow flex items-center justify-center font-bold relative overflow-hidden ring-2 ring-white">
                <i class="fas fa-user"></i>
            </div>
        </div>
    </div>
</div>

@section('title')
    IEPS
@endsection
<div>
    <!-- Services Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
        <!-- Matrícula 2026 -->
        <div class="glass-card rounded-2xl p-8 card-hover transition-all duration-500 cursor-pointer group relative overflow-hidden"
            onclick="goLink('{{ route('matricular') }}')">
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary/5 to-primary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-primary to-red-800 rounded-xl flex items-center justify-center mb-6 icon-bounce group-hover:animate-glow institutional-shadow">
                    <i class="fas fa-user-graduate text-white text-2xl"></i>
                </div>
                <h3
                    class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-primary transition-colors duration-300">
                    Matrícula 2026
                </h3>
                <p class="text-gray-600 mb-6 group-hover:text-gray-700 transition-colors duration-300 leading-relaxed">
                    Proceso de nueva matrícula para el año académico 2026. Complete su registro de manera segura y
                    eficiente.
                </p>
                <div class="flex items-center text-primary group-hover:text-red-800 transition-colors duration-300">
                    <span class="font-medium">Iniciar proceso</span>
                    <i
                        class="fas fa-chevron-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                </div>
            </div>
        </div>

        <!-- Registrar Pago -->
        <div class="glass-card rounded-2xl p-8 card-hover transition-all duration-500 cursor-pointer group relative overflow-hidden"
            onclick="goLink('{{ route('registrar.pago') }}')">
            <div
                class="absolute inset-0 bg-gradient-to-br from-secondary/5 to-secondary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-secondary to-gray-800 rounded-xl flex items-center justify-center mb-6 icon-bounce group-hover:animate-glow institutional-shadow">
                    <i class="fas fa-file-invoice-dollar text-white text-2xl"></i>
                </div>
                <h3
                    class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-secondary transition-colors duration-300">
                    Registrar Pago
                </h3>
                <p class="text-gray-600 mb-6 group-hover:text-gray-700 transition-colors duration-300 leading-relaxed">
                    Registro de pagos de matrícula y pensiones. Mantenga actualizada su cuenta de manera segura.
                </p>
                <div class="flex items-center text-secondary group-hover:text-gray-800 transition-colors duration-300">
                    <span class="font-medium">Registrar pago</span>
                    <i
                        class="fas fa-chevron-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                </div>
            </div>
        </div>

        <!-- Estado de Cuenta -->
        <div class="glass-card rounded-2xl p-8 card-hover transition-all duration-500 cursor-pointer group relative overflow-hidden"
            onclick="goLink('{{ route('estado.cuenta') }}')">
            <div
                class="absolute inset-0 bg-gradient-to-br from-contrast3/5 to-contrast3/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-contrast3 to-yellow-800 rounded-xl flex items-center justify-center mb-6 icon-bounce group-hover:animate-glow institutional-shadow">
                    <i class="fas fa-file-invoice text-white text-2xl"></i>
                </div>
                <h3
                    class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-contrast3 transition-colors duration-300">
                    Estado de Cuenta
                </h3>
                <p class="text-gray-600 mb-6 group-hover:text-gray-700 transition-colors duration-300 leading-relaxed">
                    Consulte el estado actual de su cuenta académica y verifique pagos pendientes o realizados.
                </p>
                <div
                    class="flex items-center text-contrast3 group-hover:text-yellow-800 transition-colors duration-300">
                    <span class="font-medium">Consultar estado</span>
                    <i
                        class="fas fa-chevron-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                </div>
            </div>
        </div>
        <!-- Asistencias -->
        <div class="glass-card rounded-2xl p-8 card-hover transition-all duration-500 cursor-pointer group relative overflow-hidden md:col-span-2 lg:col-span-1"
            onclick="goLink('{{ route('ver.asistencias') }}')">
            <div
                class="absolute inset-0 bg-gradient-to-br from-contrast3/5 to-yellow-700/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-contrast3 to-yellow-800 rounded-xl flex items-center justify-center mb-6 icon-bounce group-hover:animate-glow institutional-shadow">
                    <i class="fas fa-clipboard-check text-white text-2xl"></i>
                </div>
                <h3
                    class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-contrast3 transition-colors duration-300">
                    Control de Asistencias
                </h3>
                <p class="text-gray-600 mb-6 group-hover:text-gray-700 transition-colors duration-300 leading-relaxed">
                    Consulte el registro de asistencias del estudiante y el seguimiento académico institucional.
                </p>
                <div
                    class="flex items-center text-contrast3 group-hover:text-yellow-800 transition-colors duration-300">
                    <span class="font-medium">Ver registros</span>
                    <i
                        class="fas fa-chevron-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-8 card-hover transition-all duration-500 cursor-pointer group relative overflow-hidden"
            onclick="goLink('{{ route('libro.reclamaciones') }}')">
            <div
                class="absolute inset-0 bg-gradient-to-br from-primary/5 to-primary/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
            </div>
            <div class="relative z-10">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-primary to-red-800 rounded-xl flex items-center justify-center mb-6 icon-bounce group-hover:animate-glow institutional-shadow">
                    <i class="fas fa-book text-white text-2xl"></i>
                </div>
                <h3
                    class="text-xl font-semibold text-gray-800 mb-3 group-hover:text-primary transition-colors duration-300">
                    Libro de Reclamaciones
                </h3>
                <p class="text-gray-600 mb-6 group-hover:text-gray-700 transition-colors duration-300 leading-relaxed">
                    Un espacio para atender sus reclamos y quejas con transparencia.
                </p>
                <div class="flex items-center text-primary group-hover:text-red-800 transition-colors duration-300">
                    <span class="font-medium">Registrar Reclamo o Queja</span>
                    <i
                        class="fas fa-chevron-right ml-2 group-hover:translate-x-2 transition-transform duration-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>

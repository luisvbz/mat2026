<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    <livewire:commons.mod-asistencia />

    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center mr-4">
                    <i class="ph-fill ph-hand-tap text-2xl"></i>
                </span>
                Marcación de Asistencia
            </h1>
            <p class="text-gray-500 text-sm mt-1 ml-16">Sistema de marcación manual o integración biométrica.</p>
        </div>
    </div>

    {{-- Contenido Pendiente --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center mt-6">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-50 mb-6">
            <i class="ph-fill ph-person-simple-bike text-4xl text-yellow-500"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Sección en Construcción</h2>
        <p class="text-gray-500 max-w-md mx-auto">
            El módulo de marcación de asistencia estará disponible en futuras actualizaciones del sistema.
        </p>
    </div>
</div>

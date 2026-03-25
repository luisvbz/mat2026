<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mr-4">
                    <i class="ph-fill ph-pencil-simple text-2xl"></i>
                </span>
                Editar Permiso
            </h1>
        </div>
        <div>
            <a href="{{ route('permisos-alumnos.index') }}"
                class="inline-flex flex-row items-center text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white px-4 py-2 rounded-lg border border-gray-300 shadow-sm transition-colors">
                <i class="ph-bold ph-arrow-left mr-2"></i> Regresar
            </a>
        </div>
    </div>

    {{-- Contenido Pendiente --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-yellow-50 mb-6">
            <i class="ph-fill ph-person-simple-bike text-4xl text-yellow-500"></i>
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Sección en Construcción</h2>
        <p class="text-gray-500 max-w-md mx-auto">
            La funcionalidad para editar permisos existentes estará disponible en futuras actualizaciones del sistema.
        </p>
    </div>
</div>

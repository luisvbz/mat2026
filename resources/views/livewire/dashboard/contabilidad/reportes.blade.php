<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <div
            class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-300 flex items-center justify-center text-colegio-600">
            <i class="ph-fill ph-chart-bar text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Reportes Contables</h1>
            <p class="text-sm text-gray-800">Genera y descarga análisis financieros y de deudas</p>
        </div>
    </div>

    <livewire:commons.mod-contable />

    {{-- Loading Overlay --}}
    <div wire:loading.flex
        class="fixed inset-0 z-50 bg-white/70 backdrop-blur-sm flex-col items-center justify-center hidden">
        <div class="animate-spin text-colegio-500 mb-4">
            <i class="ph ph-circle-notch text-5xl"></i>
        </div>
        <div class="text-lg font-semibold text-gray-700 animate-pulse">
            Procesando reporte, por favor espere...
        </div>
    </div>

    {{-- Report Options Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Deudores PDF --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-6 flex flex-col items-start hover:shadow-md transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="ph-fill ph-file-pdf text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-2">Deudores de Pensiones (PDF)</h3>
            <p class="text-sm text-gray-800 mb-6 flex-1">Lista completa de alumnos con pensiones pendientes formato PDF.
                Ideal para impresión directa.</p>
            <button wire:click="reporteDeudores"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white border border-red-200 text-red-600 rounded-lg font-medium hover:bg-red-50 transition-colors">
                <i class="ph ph-download-simple"></i> Generar PDF
            </button>
        </div>

        {{-- Deudores CSV --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-6 flex flex-col items-start hover:shadow-md transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="ph-fill ph-file-csv text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-2">Deudores de Pensiones (CSV)</h3>
            <p class="text-sm text-gray-800 mb-6 flex-1">Exporta la lista de alumnos morosos a un archivo Excel/CSV para
                filtrado y cruce de datos.</p>
            <button wire:click="reporteDeudoresCSV"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white border border-green-200 text-green-700 rounded-lg font-medium hover:bg-green-50 transition-colors">
                <i class="ph ph-download-simple"></i> Exportar a CSV
            </button>
        </div>

        {{-- Resumen Grados --}}
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-300 p-6 flex flex-col items-start hover:shadow-md transition-all group">
            <div
                class="w-12 h-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                <i class="ph-fill ph-chart-pie-slice text-2xl"></i>
            </div>
            <h3 class="font-bold text-gray-800 text-lg mb-2">Resumen por Grados</h3>
            <p class="text-sm text-gray-800 mb-6 flex-1">Reporte detallado de pagos organizados por grados y meses en
                formato PDF.</p>
            <button wire:click="resumenPagoGrados"
                class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-white border border-blue-200 text-blue-700 rounded-lg font-medium hover:bg-blue-50 transition-colors">
                <i class="ph ph-download-simple"></i> Generar Reporte
            </button>
        </div>

    </div>
</div>

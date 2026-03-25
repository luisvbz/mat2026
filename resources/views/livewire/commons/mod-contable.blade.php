<div class="mb-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
    <a href="{{ route('contabilidad.cronograma') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'contabilidad.cronograma' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'contabilidad.cronograma' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-calendar-blank text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Cronograma</h3>
            <p class="text-xs text-gray-500">Calendario de pagos</p>
        </div>
    </a>

    <a href="{{ route('contabilidad.pagos-pensiones') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'contabilidad.pagos-pensiones' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'contabilidad.pagos-pensiones' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-receipt text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Pensiones</h3>
            <p class="text-xs text-gray-500">Pagos mensuales</p>
        </div>
    </a>

    <a href="{{ route('contabilidad.pagos-matricula') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'contabilidad.pagos-matricula' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'contabilidad.pagos-matricula' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-money text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Matrículas</h3>
            <p class="text-xs text-gray-500">Pagos de inscripción</p>
        </div>
    </a>

    <a href="{{ route('contabilidad.reportes') }}"
        class="flex items-center p-4 bg-white border {{ $route == 'contabilidad.reportes' ? 'border-colegio-500 shadow-md ring-1 ring-colegio-500' : 'border-gray-200' }} rounded-xl hover:shadow-md transition-all group">
        <div
            class="w-12 h-12 rounded-lg {{ $route == 'contabilidad.reportes' ? 'bg-colegio-50 text-colegio-600' : 'bg-gray-50 text-gray-500 group-hover:bg-colegio-50 group-hover:text-colegio-600' }} flex items-center justify-center mr-4 transition-colors">
            <i class="ph-fill ph-chart-bar text-2xl"></i>
        </div>
        <div>
            <h3 class="font-bold text-gray-800">Reportes</h3>
            <p class="text-xs text-gray-500">Análisis contable</p>
        </div>
    </a>
</div>

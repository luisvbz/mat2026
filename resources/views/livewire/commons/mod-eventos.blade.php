<div class="mb-6">
    <div class="flex items-center gap-1 bg-white p-1.5 rounded-2xl shadow-sm border border-gray-300 w-fit">
        <a href="{{ route('dashboard.eventos') }}"
            class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ $route == 'dashboard.eventos' ? 'bg-colegio-600 text-white shadow-lg shadow-colegio-100' : 'text-gray-800 hover:bg-gray-50 hover:text-gray-600' }}">
            <i class="ph ph-list-bullets mr-2 text-base font-bold"></i> Lista de Eventos
        </a>
        <a href="{{ route('dashboard.eventos.crear') }}"
            class="px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest transition-all {{ $route == 'dashboard.eventos.crear' ? 'bg-colegio-600 text-white shadow-lg shadow-colegio-100' : 'text-gray-800 hover:bg-gray-50 hover:text-gray-600' }}">
            <i class="ph ph-plus-circle mr-2 text-base font-bold"></i> Nuevo Evento
        </a>
    </div>
</div>

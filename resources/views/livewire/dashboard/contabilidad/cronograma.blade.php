<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    <div class="flex items-center gap-3 mb-6">
        <div
            class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
            <i class="ph-fill ph-calendar-blank text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Cronograma de Pagos</h1>
            <p class="text-sm text-gray-500">Gestión del calendario de mensualidades</p>
        </div>
    </div>

    <livewire:commons.mod-contable />

    <div class="flex flex-wrap items-center gap-6 p-4 bg-white rounded-xl border border-gray-100 shadow-sm">
        <span class="text-sm font-semibold text-gray-700 border-r border-gray-200 pr-6">Leyenda de Estados:</span>
        <div class="flex items-center gap-2 px-3 py-1 bg-yellow-50 rounded-full text-yellow-700"><i
                class="ph-fill ph-circle text-yellow-500"></i> <span class="text-xs font-bold">No iniciada</span></div>
        <div class="flex items-center gap-2 px-3 py-1 bg-green-50 rounded-full text-green-700"><i
                class="ph-fill ph-circle text-green-500"></i> <span class="text-xs font-bold">Activa</span></div>
        <div class="flex items-center gap-2 px-3 py-1 bg-red-50 rounded-full text-red-700"><i
                class="ph-fill ph-circle text-red-500"></i> <span class="text-xs font-bold">Vencida</span></div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-4 font-semibold text-center w-24">Estado</th>
                        <th class="px-5 py-4 font-semibold">Orden</th>
                        <th class="px-5 py-4 font-semibold">Mes</th>
                        <th class="px-5 py-4 font-semibold">Costo</th>
                        <th class="px-5 py-4 font-semibold text-center">Fecha de Vencimiento</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($cronograma as $item)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4 text-center">
                                @php
                                    $statusParts = explode('>', $item->status);
                                    $firstPart = reset($statusParts);
                                @endphp
                                {!! str_replace(
                                    ['has-text-warning', 'has-text-success', 'has-text-danger', 'fas fa-circle'],
                                    ['text-yellow-500', 'text-green-500', 'text-red-500', 'ph-fill ph-circle text-lg'],
                                    $firstPart . '>',
                                ) !!}
                            </td>
                            <td class="px-5 py-4 font-bold text-gray-800">{{ $item->orden_letras }}</td>
                            <td class="px-5 py-4 capitalize">{{ $item->mes | mes }}</td>
                            <td class="px-5 py-4 font-bold text-gray-800">
                                <span
                                    class="text-gray-400 font-normal mr-1">S/.</span>{{ number_format($item->costo, 2) }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span
                                    class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-medium text-xs">
                                    {{ $item->fecha_vencimiento | dateFormat }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-gray-500">No hay cronograma configurado
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

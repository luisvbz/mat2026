<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-calendar-star text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Gestión de Eventos</h1>
                <p class="text-sm text-gray-500 font-medium">Cartelera de actividades y anuncios</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative flex-1 md:w-80">
                <input wire:model="search" type="text"
                    class="w-full bg-white border border-gray-100 rounded-xl px-4 py-2.5 pl-10 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-sm"
                    placeholder="Buscar evento...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="ph ph-magnifying-glass font-bold"></i>
                </div>
            </div>
            <a href="{{ route('dashboard.eventos.crear') }}"
                class="inline-flex items-center px-4 py-2.5 bg-colegio-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-colegio-700 transition-all shadow-md shadow-colegio-100">
                <i class="ph ph-plus-circle mr-2 text-base font-bold"></i> Nuevo Evento
            </a>
        </div>
    </div>

    <livewire:commons.mod-eventos />

    {{-- Events Content --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead
                    class="text-[10px] text-gray-500 uppercase font-bold tracking-widest bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Fecha y Hora</th>
                        <th class="px-6 py-4 text-center">Tipo</th>
                        <th class="px-6 py-4">Descripción</th>
                        <th class="px-6 py-4">Recursos</th>
                        <th class="px-6 py-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($events as $event)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <p class="font-bold text-gray-800 tracking-tight">{{ $event->date->format('d/m/Y') }}
                                </p>
                                <p class="text-[10px] text-colegio-500 font-bold uppercase">
                                    {{ $event->time->format('h:i A') }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest
                                    {{ $event->type === 'actividad' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">
                                    {{ $event->type }}
                                </span>
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-sm font-medium text-gray-700 line-clamp-2 max-w-xs"
                                    title="{{ $event->description }}">
                                    {{ $event->description }}
                                </p>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    @if ($event->link)
                                        <a href="{{ $event->link }}" target="_blank"
                                            class="w-9 h-9 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400 hover:text-colegio-600 hover:border-colegio-200 transition-all shadow-sm group"
                                            title="Ver enlace externo">
                                            <i
                                                class="ph ph-link text-xl group-hover:scale-110 transition-transform"></i>
                                        </a>
                                    @endif
                                    @if ($event->attachment)
                                        <a href="{{ asset($event->attachment) }}" target="_blank"
                                            class="w-9 h-9 rounded-xl bg-white border border-gray-100 flex items-center justify-center text-gray-400 hover:text-green-600 hover:border-green-200 transition-all shadow-sm group"
                                            title="Descargar adjunto">
                                            <i
                                                class="ph ph-paperclip text-xl group-hover:rotate-12 transition-transform"></i>
                                        </a>
                                    @endif
                                    @if (!$event->link && !$event->attachment)
                                        <span class="text-[10px] font-bold text-gray-300 uppercase italic">Sin
                                            recursos</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center gap-1">
                                    <a href="{{ route('dashboard.eventos.editar', $event->id) }}"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"
                                        title="Editar">
                                        <i class="ph ph-pencil-simple text-xl"></i>
                                    </a>
                                    <button wire:click="delete({{ $event->id }})"
                                        onclick="confirm('¿Estás seguro de eliminar este evento?') || event.stopImmediatePropagation()"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all"
                                        title="Eliminar">
                                        <i class="ph ph-trash text-xl"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-16 text-center text-gray-300 italic">
                                <i class="ph ph-calendar-x text-5xl mb-3 opacity-20 block mx-auto"></i>
                                <span class="uppercase font-bold tracking-widest text-xs">No se encontraron eventos
                                    registrados</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($events->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $events->links() }}
            </div>
        @endif
    </div>
</div>

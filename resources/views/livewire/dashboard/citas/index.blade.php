<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 text-dashboard-header">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-calendar-check text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Gestión de Citas</h1>
                <p class="text-sm text-gray-500 font-medium">Seguimiento de entrevistas y reuniones</p>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="exportarExcel" wire:loading.attr="disabled"
                class="inline-flex items-center px-4 py-2.5 bg-green-600 text-white rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-green-700 transition-all shadow-md shadow-green-100 disabled:opacity-50">
                <i class="ph ph-file-xls mr-2 text-base font-bold"></i> Exportar Excel
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-6 gap-6">
            {{-- Search --}}
            <div class="xl:col-span-2">
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mb-1.5">Buscar
                    Alumno / Padre</label>
                <div class="relative">
                    <input type="text" wire:model.defer="search" wire:keydown.enter="buscar"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 pl-10 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-inner"
                        placeholder="Nombres o apellidos...">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="ph ph-magnifying-glass font-bold"></i>
                    </div>
                </div>
            </div>

            {{-- Nivel --}}
            <div>
                <label
                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mb-1.5">Nivel</label>
                <div class="relative">
                    <select wire:model="nivel"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-inner appearance-none">
                        <option value="">Todos</option>
                        <option value="P">Primaria</option>
                        <option value="S">Secundaria</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <i class="ph ph-caret-down font-bold text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Grado --}}
            <div>
                <label
                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mb-1.5">Grado</label>
                <div class="relative">
                    <select wire:model="grado"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-inner appearance-none">
                        <option value="">Todos</option>
                        @foreach ($grados as $g)
                            <option value="{{ $g->numero }}">{{ $g->nombre }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <i class="ph ph-caret-down font-bold text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Profesor --}}
            <div>
                <label
                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mb-1.5">Profesor</label>
                <div class="relative">
                    <select wire:model="teacher_id"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-inner appearance-none">
                        <option value="">Todos</option>
                        @foreach ($teachers as $tu)
                            <option value="{{ $tu->teacher_id }}">{{ $tu->teacher->nombre_completo ?? 'N/A' }}</option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <i class="ph ph-caret-down font-bold text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Estado --}}
            <div>
                <label
                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mb-1.5">Estado</label>
                <div class="relative">
                    <select wire:model="status"
                        class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2.5 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-inner appearance-none">
                        <option value="">Todos</option>
                        <option value="pending">Pendiente</option>
                        <option value="confirmed">Confirmada</option>
                        <option value="rejected">Rechazada</option>
                        <option value="completed">Completada</option>
                        <option value="cancelled">Cancelada</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-gray-400">
                        <i class="ph ph-caret-down font-bold text-xs"></i>
                    </div>
                </div>
            </div>

            {{-- Desde --}}
            <div>
                <label
                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mb-1.5">Desde</label>
                <input type="date" wire:model="desde"
                    class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-inner">
            </div>

            {{-- Hasta --}}
            <div>
                <label
                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1 mb-1.5">Hasta</label>
                <input type="date" wire:model="hasta"
                    class="w-full bg-gray-50 border border-gray-100 rounded-xl px-4 py-2 text-sm focus:ring-colegio-500 focus:border-colegio-500 transition-all font-bold text-gray-600 shadow-inner">
            </div>

            {{-- Actions --}}
            <div class="flex items-end gap-2 xl:col-span-4 xl:justify-end">
                <button wire:click="buscar" title="Buscar"
                    class="w-11 h-11 bg-colegio-600 text-white rounded-xl flex items-center justify-center hover:bg-colegio-700 transition-all shadow-md shadow-colegio-100">
                    <i class="ph ph-magnifying-glass text-xl font-bold"></i>
                </button>
                <button wire:click="limpiar" title="Limpiar filtros"
                    class="w-11 h-11 bg-white border border-gray-200 text-gray-400 rounded-xl flex items-center justify-center hover:bg-gray-50 hover:text-gray-600 transition-all shadow-sm">
                    <i class="ph ph-eraser text-xl font-bold"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Appointments Content --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-0">
        <div wire:loading
            wire:target="buscar, limpiar, nivel, grado, teacher_id, status, desde, hasta, exportarExcel, gotoPage, previousPage, nextPage"
            style="display: none;"
            class="absolute inset-0 bg-white/80 backdrop-blur-sm z-50 flex flex-col items-center justify-center transition-all">
            <div class="w-16 h-16 bg-white rounded-2xl shadow-xl flex items-center justify-center mb-4">
                <i class="ph ph-spinner-gap animate-spin text-3xl text-colegio-600 font-bold"></i>
            </div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-gray-600">
                <span wire:loading wire:target="exportarExcel">Generando reporte Excel...</span>
                <span wire:loading.remove wire:target="exportarExcel">Cargando información...</span>
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead
                    class="text-[10px] text-gray-500 uppercase font-bold tracking-widest bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Fecha / Hora</th>
                        <th class="px-6 py-4">Padre / Madre</th>
                        <th class="px-6 py-4">Alumno</th>
                        <th class="px-6 py-4 text-center">Ubicación</th>
                        <th class="px-6 py-4">Profesor</th>
                        <th class="px-6 py-4 text-center text-center">Estado</th>
                        <th class="px-6 py-4 text-center">Detalle</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 font-medium">
                    @forelse($appointments as $appointment)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <p class="font-bold text-gray-800 tracking-tight">
                                    {{ $appointment->date ? $appointment->date->format('d/m/Y') : '-' }}</p>
                                <p class="text-[10px] text-colegio-500 font-bold uppercase">
                                    {{ $appointment->time ? $appointment->time->format('h:i A') : '' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-bold text-gray-700 leading-tight uppercase tracking-tight text-xs">
                                    {{ $appointment->parent->nombre_completo ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-5">
                                <p class="font-bold text-gray-800 leading-tight uppercase tracking-tight text-xs">
                                    {{ $appointment->student->nombre_completo ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-5 text-center whitespace-nowrap">
                                @if ($appointment->student && $appointment->student->matricula)
                                    <p
                                        class="text-[10px] font-bold text-gray-700 uppercase tracking-widest bg-gray-100 px-2 py-1 rounded-lg inline-block shadow-sm grayscale opacity-70 group-hover:grayscale-0 group-hover:opacity-100 transition-all">
                                        {{ $appointment->student->matricula->nivel == 'P' ? 'PRI' : 'SEC' }} •
                                        {{ $appointment->student->matricula->grado }}°
                                    </p>
                                @else
                                    <span class="text-gray-300 font-bold text-[10px] uppercase">N/A</span>
                                @endif
                            </td>
                            <td class="px-6 py-5">
                                <p class="text-xs font-bold text-gray-600 uppercase tracking-tight leading-tight">
                                    {{ $appointment->teacher->nombre_completo ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-700',
                                        'confirmed' => 'bg-emerald-100 text-emerald-700',
                                        'rejected' => 'bg-rose-100 text-rose-700',
                                        'completed' => 'bg-indigo-100 text-indigo-700',
                                        'cancelled' => 'bg-slate-100 text-slate-500',
                                    ];
                                    $statusNames = [
                                        'pending' => 'Pendiente',
                                        'confirmed' => 'Confirmada',
                                        'rejected' => 'Rechazada',
                                        'completed' => 'Completada',
                                        'cancelled' => 'Cancelada',
                                    ];
                                @endphp
                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $statusClasses[$appointment->status] ?? 'bg-gray-100 text-gray-400' }}">
                                    {{ $statusNames[$appointment->status] ?? $appointment->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                <button wire:click="verDetalle({{ $appointment->id }})"
                                    class="p-2 text-gray-400 hover:text-colegio-600 hover:bg-colegio-50 rounded-xl transition-all"
                                    title="Ver detalle">
                                    <i class="ph ph-eye text-xl font-bold"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-20 text-center text-gray-300 italic">
                                <i class="ph ph-calendar-blank text-6xl mb-4 opacity-20 block mx-auto font-bold"></i>
                                <span class="uppercase font-bold tracking-widest text-[10px]">No se encontraron citas
                                    con los filtros seleccionados</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($appointments->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $appointments->links() }}
            </div>
        @endif
    </div>

    {{-- Detail Modal --}}
    @if ($showModal && $selected_appointment)
        <div class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-gray-900/60 backdrop-blur-sm" aria-hidden="true"
                    wire:click="cerrarModal"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full border border-gray-100">
                    {{-- Modal Header --}}
                    <div
                        class="bg-gradient-to-r from-colegio-600 to-colegio-500 px-8 py-5 flex items-center justify-between shadow-lg shadow-colegio-100/50 relative z-10">
                        <h3 class="text-sm font-bold uppercase tracking-widest text-white flex items-center gap-3">
                            <i class="ph ph-calendar-check text-2xl font-bold"></i>
                            Detalle de la Cita
                        </h3>
                        <button wire:click="cerrarModal"
                            class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-all">
                            <i class="ph ph-x text-lg font-bold"></i>
                        </button>
                    </div>

                    {{-- Modal Body --}}
                    <div class="px-8 py-10 space-y-8 max-h-[75vh] overflow-y-auto custom-scrollbar bg-white">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-10">
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Fecha</label>
                                <div
                                    class="flex items-center gap-3 bg-gray-50 px-4 py-3 rounded-2xl border border-gray-100 shadow-inner">
                                    <i class="ph ph-calendar text-colegio-500 text-lg font-bold"></i>
                                    <span
                                        class="text-sm font-bold text-gray-800 tracking-tight">{{ $selected_appointment->date->format('d/m/Y') }}</span>
                                </div>
                            </div>
                            <div>
                                <label
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Hora</label>
                                <div
                                    class="flex items-center gap-3 bg-gray-50 px-4 py-3 rounded-2xl border border-gray-100 shadow-inner">
                                    <i class="ph ph-clock text-colegio-500 text-lg font-bold"></i>
                                    <span
                                        class="text-sm font-bold text-gray-800 tracking-tight">{{ $selected_appointment->time ? $selected_appointment->time->format('h:i A') : 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1 border-b border-gray-50 pb-1 w-full">Padre
                                    / Madre</label>
                                <div class="flex flex-col">
                                    <p
                                        class="text-base font-bold text-gray-800 uppercase tracking-tight leading-tight pt-1">
                                        {{ $selected_appointment->parent->nombre_completo ?? 'N/A' }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">
                                        Responsable legal</p>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1 border-b border-gray-50 pb-1 w-full">Alumno
                                    / Estudiante</label>
                                <div class="flex items-center gap-4">
                                    <div class="flex flex-col flex-1">
                                        <p
                                            class="text-base font-bold text-gray-800 uppercase tracking-tight leading-tight">
                                            {{ $selected_appointment->student->nombre_completo ?? 'N/A' }}</p>
                                        <p
                                            class="text-[10px] text-colegio-500 font-bold uppercase tracking-widest mt-1">
                                            @if ($selected_appointment->student && $selected_appointment->student->matricula)
                                                {{ $selected_appointment->student->matricula->nivel == 'P' ? 'Primaria' : 'Secundaria' }}
                                                • {{ $selected_appointment->student->matricula->grado }}° Grado
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-2 space-y-2 pt-2">
                                <label
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1 border-b border-gray-50 pb-1 w-full">Profesor
                                    Asignado</label>
                                <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-colegio-100 flex items-center justify-center text-colegio-600">
                                        <i class="ph-fill ph-user-gear text-xl"></i>
                                    </div>
                                    <p class="text-sm font-bold text-gray-800 uppercase tracking-tight leading-tight">
                                        {{ $selected_appointment->teacher->nombre_completo ?? 'N/A' }}</p>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Asunto
                                    de la reunión</label>
                                <div
                                    class="text-xs font-bold text-gray-600 bg-gray-50 px-5 py-4 rounded-2xl border border-gray-100 shadow-inner italic leading-relaxed">
                                    "{{ $selected_appointment->subject ?? 'Sin asunto especificado' }}"
                                </div>
                            </div>
                            <div class="col-span-2">
                                <label
                                    class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Notas
                                    y Observaciones</label>
                                <div
                                    class="text-xs font-bold text-gray-500 bg-white px-5 py-5 rounded-2xl border border-gray-100 shadow-sm min-h-[100px] leading-relaxed">
                                    {{ $selected_appointment->notes ?? 'No se registraron notas adicionales para esta cita.' }}
                                </div>
                            </div>
                            <div class="col-span-2 flex items-center gap-4">
                                <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Estado
                                    Actual:</label>
                                <span
                                    class="inline-flex px-5 py-2 rounded-xl text-[10px] font-bold uppercase tracking-widest shadow-sm {{ $statusClasses[$selected_appointment->status] ?? 'bg-gray-100 text-gray-400' }}">
                                    {{ $statusNames[$selected_appointment->status] ?? $selected_appointment->status }}
                                </span>
                            </div>
                            @if ($selected_appointment->status == 'cancelled')
                                <div
                                    class="col-span-2 p-6 bg-rose-50 border border-rose-100 rounded-3xl relative overflow-hidden group">
                                    <div
                                        class="absolute -top-4 -right-4 text-rose-100 opacity-50 group-hover:scale-110 transition-transform">
                                        <i class="ph ph-warning-octagon text-8xl font-bold"></i>
                                    </div>
                                    <label
                                        class="block text-[10px] font-bold text-rose-400 uppercase tracking-widest mb-2 relative z-10">Motivo
                                        de Cancelación</label>
                                    <p class="text-sm font-bold text-rose-800 leading-relaxed relative z-10">
                                        {{ $selected_appointment->cancellation_reason ?? 'No especificado por el usuario.' }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Modal Footer --}}
                    <div class="px-8 py-6 bg-gray-50 border-t border-gray-100 flex justify-end">
                        <button wire:click="cerrarModal"
                            class="px-12 py-3 bg-white border border-gray-200 text-[10px] font-bold uppercase tracking-widest text-gray-600 rounded-2xl hover:bg-gray-100 hover:text-gray-800 transition-all shadow-sm">
                            Cerrar Ventana
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-clock text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Gestión de Horarios</h1>
                <p class="text-sm text-gray-500 font-medium">Configuración de turnos para el personal</p>
            </div>
        </div>
        <div>
            <button wire:click="create"
                class="inline-flex items-center px-4 py-2 bg-colegio-600 text-white rounded-lg text-sm font-bold hover:bg-colegio-700 transition-all shadow-md shadow-colegio-100">
                <i class="ph ph-plus-circle mr-2"></i> Nuevo Horario
            </button>
        </div>
    </div>

    <livewire:commons.mod-profesor />

    @if (session()->has('success'))
        <div
            class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl flex items-center gap-3 animate-in fade-in duration-300">
            <i class="ph-fill ph-check-circle text-green-500 text-xl"></i>
            <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div
            class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl flex items-center gap-3 animate-in fade-in duration-300">
            <i class="ph-fill ph-warning-circle text-red-500 text-xl"></i>
            <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    {{-- Main Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden relative z-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead
                    class="text-[10px] text-gray-500 uppercase font-bold tracking-widest bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4">Nombre del Horario</th>
                        <th class="px-6 py-4">Días y Horas Laborales</th>
                        <th class="px-6 py-4 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($horarios as $horario)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                        <i class="ph-fill ph-calendar text-lg"></i>
                                    </div>
                                    <span
                                        class="font-bold text-gray-800 uppercase tracking-tight">{{ $horario->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex flex-wrap gap-2">
                                    @php
                                        $nombresDias = [
                                            1 => 'Lun',
                                            2 => 'Mar',
                                            3 => 'Mié',
                                            4 => 'Jue',
                                            5 => 'Vie',
                                            6 => 'Sáb',
                                            7 => 'Dom',
                                        ];
                                    @endphp
                                    @foreach ($horario->dias->where('active', true)->sortBy('day_number') as $dia)
                                        <div
                                            class="group relative px-2.5 py-1 bg-white border border-gray-200 rounded-lg shadow-sm flex items-center gap-2 hover:border-colegio-200 transition-all cursor-default">
                                            <span
                                                class="text-[10px] font-bold text-colegio-600 uppercase">{{ $nombresDias[$dia->day_number] ?? 'N/A' }}</span>
                                            <div class="h-3 w-px bg-gray-200"></div>
                                            <span class="text-[10px] font-mono font-bold text-gray-600">
                                                {{ substr($dia->start_time, 0, 5) }} -
                                                {{ substr($dia->end_time, 0, 5) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex justify-end gap-2 text-gray-400">
                                    <button wire:click="edit({{ $horario->id }})"
                                        class="p-2 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all"
                                        title="Editar Horario">
                                        <i class="ph ph-pencil-simple text-xl"></i>
                                    </button>
                                    <button wire:click="delete({{ $horario->id }})"
                                        onclick="confirm('¿Estás seguro de eliminar este horario? No se podrá deshacer.') || event.stopImmediatePropagation()"
                                        class="p-2 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all"
                                        title="Eliminar Horario">
                                        <i class="ph ph-trash text-xl"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-400 italic">
                                <i class="ph ph-clock-countdown text-4xl mb-2 opacity-20 block mx-auto"></i>
                                No hay horarios configurados en el sistema.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal: Create/Edit --}}
    @if ($showModal)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm animate-in fade-in duration-300"
                wire:click="$set('showModal', false)"></div>

            {{-- Modal Content --}}
            <div
                class="relative bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200 flex flex-col max-h-[90vh]">
                {{-- Modal Header --}}
                <div class="p-6 border-b border-gray-100 flex items-center justify-between bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-colegio-600 text-white flex items-center justify-center shadow-lg shadow-colegio-100">
                            <i class="ph ph-clock-afternoon text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 tracking-tight">
                                {{ $isEditing ? 'Editar Horario' : 'Nuevo Horario' }}</h3>
                            <p class="text-[10px] uppercase font-bold text-colegio-500 tracking-widest">Configuración de
                                Jornada</p>
                        </div>
                    </div>
                    <button wire:click="$set('showModal', false)"
                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                        <i class="ph ph-x text-xl"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-8 overflow-y-auto space-y-8">
                    <div class="space-y-1.5">
                        <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-widest ml-1">Nombre
                            del Horario</label>
                        <input type="text" wire:model="name"
                            class="block w-full px-4 py-3 bg-gray-50 border {{ $errors->has('name') ? 'border-red-300 ring-red-50' : 'border-gray-100' }} rounded-xl text-sm font-bold text-gray-700 focus:ring-colegio-500 focus:border-colegio-500 transition-all shadow-inner"
                            placeholder="Ej: Horario Primaria Mañana">
                        @error('name')
                            <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                            <i class="ph ph-calendar-plus text-colegio-500"></i>
                            <h4 class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Distribución
                                Semanal</h4>
                        </div>

                        <div class="space-y-3">
                            @foreach ($dias as $index => $dia)
                                <div
                                    class="flex items-center gap-4 p-3 rounded-2xl transition-all {{ $dia['active'] ? 'bg-white border border-colegio-100 shadow-sm shadow-colegio-50' : 'bg-gray-50/50 border border-gray-100 opacity-60' }}">
                                    <div class="flex items-center gap-3 flex-1">
                                        <div class="relative inline-flex items-center group">
                                            <input type="checkbox" wire:model="dias.{{ $index }}.active"
                                                class="w-5 h-5 rounded border-gray-300 text-colegio-600 focus:ring-colegio-500 transition-all cursor-pointer">
                                        </div>
                                        <span
                                            class="text-sm font-bold {{ $dia['active'] ? 'text-gray-800' : 'text-gray-400 font-medium' }}">{{ $dia['name'] }}</span>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <div class="relative">
                                            <input type="time" wire:model="dias.{{ $index }}.start_time"
                                                {{ !$dia['active'] ? 'disabled' : '' }}
                                                class="w-32 h-9 px-2 bg-white border border-gray-200 rounded-lg text-xs font-mono font-bold focus:ring-colegio-500 focus:border-colegio-500 disabled:bg-gray-100 disabled:border-gray-100 transition-all">
                                        </div>
                                        <span class="text-gray-300">
                                            <i class="ph ph-arrow-right"></i>
                                        </span>
                                        <div class="relative">
                                            <input type="time" wire:model="dias.{{ $index }}.end_time"
                                                {{ !$dia['active'] ? 'disabled' : '' }}
                                                class="w-32 h-9 px-2 bg-white border border-gray-200 rounded-lg text-xs font-mono font-bold focus:ring-colegio-500 focus:border-colegio-500 disabled:bg-gray-100 disabled:border-gray-100 transition-all">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="p-6 bg-gray-50/50 border-t border-gray-100 flex justify-end gap-3">
                    <button wire:click="$set('showModal', false)"
                        class="px-6 py-2.5 bg-white border border-gray-200 rounded-xl text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:bg-gray-100 transition-all shadow-sm">
                        Cancelar
                    </button>
                    <button wire:click="save"
                        class="px-8 py-2.5 bg-colegio-600 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-colegio-700 transition-all shadow-lg shadow-colegio-100">
                        Guardar Horario
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

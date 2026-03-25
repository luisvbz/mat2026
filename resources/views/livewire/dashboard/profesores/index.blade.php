<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Loading Overlay --}}
    <div wire:loading.flex wire:target="getCarnet"
        class="fixed inset-0 bg-gray-900 bg-opacity-50 z-50 items-center justify-center hidden">
        <div class="bg-white p-6 rounded-2xl shadow-xl flex flex-col items-center">
            <svg class="animate-spin h-10 w-10 text-colegio-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <span class="text-gray-700 font-medium">Generando fotochecks...</span>
        </div>
    </div>

    <div class="flex items-center gap-3 mb-6">
        <div
            class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-100 flex items-center justify-center text-colegio-600">
            <i class="ph-fill ph-student text-2xl"></i>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Profesores</h1>
            <p class="text-sm text-gray-500">Gestión del personal docente y administrativo</p>
        </div>
    </div>

    <livewire:commons.mod-profesor />

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-6 space-y-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                        <i class="ph ph-magnifying-glass"></i>
                    </div>
                    <input type="text" wire:model.defer="search" placeholder="Nombre, apellido o DNI..."
                        class="block w-full pl-10 pr-3 py-2 border border-gray-200 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm transition-all bg-gray-50/50">
                </div>
            </div>

            <div class="md:col-span-3 space-y-1">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider">Estado</label>
                <select wire:model.defer="estado"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-200 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm transition-all bg-gray-50/50">
                    <option value="">Todos</option>
                    <option value="1">Activos</option>
                    <option value="0">Inactivos</option>
                </select>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button wire:click="buscar"
                    class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-colegio-600 hover:bg-colegio-700 focus:outline-none transition-colors">
                    <i class="ph ph-magnifying-glass mr-2"></i> Buscar
                </button>
                <button wire:click="limpiar"
                    class="inline-flex items-center px-3 py-2 border border-gray-200 rounded-lg text-gray-500 bg-white hover:bg-gray-50 transition-colors shadow-sm">
                    <i class="ph ph-eraser"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden relative z-0">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-5 py-4 font-semibold text-center w-20">Estado</th>
                        <th class="px-5 py-4 font-semibold">Profesor</th>
                        <th class="px-5 py-4 font-semibold">Documento</th>
                        <th class="px-5 py-4 font-semibold">Horario</th>
                        <th class="px-5 py-4 font-semibold">Contacto</th>
                        <th class="px-5 py-4 font-semibold text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($teachers as $teacher)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-4 text-center">
                                @if ($teacher->estado == 1)
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-700">
                                        <i class="ph-fill ph-circle mr-1 text-[8px]"></i> Activo
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold bg-red-50 text-red-700">
                                        <i class="ph-fill ph-circle mr-1 text-[8px]"></i> Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-bold text-gray-800">
                                <div class="flex items-center">
                                    <div
                                        class="w-10 h-10 rounded-full bg-colegio-50 flex items-center justify-center text-colegio-600 font-bold text-xs ring-2 ring-white shadow-sm mr-3">
                                        {{ substr($teacher->apellidos, 0, 1) }}{{ substr($teacher->nombres, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-gray-800 leading-tight uppercase">
                                            {{ $teacher->apellidos }}</p>
                                        <p class="text-xs text-gray-500 font-normal">{{ $teacher->nombres }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 font-medium text-gray-700 font-mono tracking-tighter">
                                {{ $teacher->documento }}</td>
                            <td class="px-5 py-4">
                                <span
                                    class="inline-block px-2 py-1 bg-blue-50 text-blue-700 rounded-md text-[11px] font-bold">
                                    {{ $teacher->horario->name }}
                                </span>
                            </td>
                            <td class="px-5 py-4 space-y-1">
                                <div class="flex items-center text-xs text-gray-500 leading-none">
                                    <i class="ph ph-envelope-simple mr-1.5 text-gray-400"></i>
                                    {{ strtolower($teacher->email) }}
                                </div>
                                <div class="flex items-center text-xs leading-none">
                                    <i class="ph ph-phone mr-1.5 text-gray-400"></i>
                                    <span class="text-gray-700 font-semibold">{{ $teacher->telefono }}</span>
                                    @if ($teacher->telefono)
                                        <a href="https://wa.me/51{{ $teacher->telefono }}" target="_blank"
                                            class="ml-2 text-green-500 hover:text-green-600 transition-colors">
                                            <i class="ph-fill ph-whatsapp-logo text-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <div class="flex justify-end gap-2" x-data="{ open: false }">
                                    <a href="{{ route('dashboard.profesores.detalle', $teacher->id) }}"
                                        class="p-2 text-gray-400 hover:text-colegio-600 hover:bg-colegio-50 rounded-lg transition-all"
                                        title="Ver Detalle">
                                        <i class="ph ph-eye text-xl"></i>
                                    </a>
                                    <a href="{{ route('dashboard.profesores.editar', $teacher->id) }}"
                                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                        title="Editar">
                                        <i class="ph ph-pencil-simple text-xl"></i>
                                    </a>

                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false"
                                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-all">
                                            <i class="ph ph-dots-three-vertical text-xl"></i>
                                        </button>
                                        <template x-if="open">
                                            <div x-show="open"
                                                class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-100 z-50 py-2 origin-top-right transition-all">
                                                @if ($teacher->estado == 0)
                                                    <button wire:click="activar({{ $teacher->id }})"
                                                        class="w-full flex items-center px-4 py-2 text-sm text-green-600 hover:bg-green-50 transition-colors">
                                                        <i class="ph ph-check-circle mr-3 text-lg"></i> Activar
                                                    </button>
                                                @else
                                                    <button wire:click="desactivar({{ $teacher->id }})"
                                                        class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                                        <i class="ph ph-prohibit mr-3 text-lg"></i> Desactivar
                                                    </button>
                                                @endif

                                                <div class="h-px bg-gray-100 my-1"></div>

                                                <button wire:click="showDialogEliminar({{ $teacher->id }})"
                                                    class="w-full flex items-center px-4 py-2 text-sm text-red-700 font-semibold hover:bg-red-50 transition-colors">
                                                    <i class="ph ph-trash mr-3 text-lg"></i> Eliminar
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                                <i class="ph ph-users-three text-4xl mb-3 opacity-20 block mx-auto"></i>
                                No se encontraron profesores registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Floating Action Button --}}
    <div class="fixed bottom-8 right-8 z-30">
        <button wire:click="getCarnet"
            class="flex items-center gap-2 px-6 py-3 bg-gray-800 text-white rounded-full shadow-2xl hover:bg-gray-900 transition-all hover:-translate-y-1 active:scale-95 group">
            <i class="ph ph-identification-card text-xl transition-transform group-hover:rotate-12"></i>
            <span class="font-bold text-sm tracking-wide uppercase">Fotochecks</span>
        </button>
    </div>
</div>

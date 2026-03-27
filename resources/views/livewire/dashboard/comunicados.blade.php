<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    {{-- Loading overlay --}}
    <div wire:loading.flex wire:target="save,delete,togglePublish"
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
            <span class="text-gray-700 font-medium">Procesando...</span>
        </div>
    </div>

    {{-- Header --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <i class="ph ph-megaphone text-colegio-600 mr-3 text-3xl"></i> Comunicados
            </h1>
        </div>

        <div class="flex items-center space-x-3">
            <button wire:click="create"
                class="inline-flex items-center px-4 py-2 bg-colegio-600 border border-transparent rounded-lg font-semibold text-white shadow-sm hover:bg-colegio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-colors">
                <i class="ph ph-plus mr-2 font-bold"></i> Nuevo Comunicado
            </button>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 p-5 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
            <div class="md:col-span-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="ph ph-magnifying-glass text-gray-800"></i>
                    </div>
                    <input wire:model.debounce.500ms="search" type="text"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm"
                        placeholder="Buscar por título o contenido...">
                </div>
            </div>

            <div class="md:col-span-3">
                <select wire:model="filterCategory"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="">Todas las categorías</option>
                    <option value="general">General</option>
                    <option value="academico">Académico</option>
                    <option value="administrativo">Administrativo</option>
                    <option value="evento">Evento</option>
                    <option value="urgente">Urgente</option>
                    <option value="cobro">Cobro</option>
                    <option value="actividad">Actividad</option>
                    <option value="otro">Otro</option>
                </select>
            </div>

            <div class="md:col-span-3">
                <select wire:model="filterPublished"
                    class="block w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm">
                    <option value="">Todos los estados</option>
                    <option value="1">Publicados</option>
                    <option value="0">Borradores</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Communications List --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-300 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Estado</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Título</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Categoría</th>
                        <th scope="col"
                            class="px-2 py-2 text-center text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Adjuntos</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Fecha
                            Publicación</th>
                        <th scope="col"
                            class="px-2 py-2 text-left text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Autor
                        </th>
                        <th scope="col"
                            class="px-2 py-2 text-center text-[11px] font-medium text-gray-800 uppercase tracking-wider">
                            Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($communications as $communication)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-2 py-2 whitespace-nowrap">
                                @if ($communication->is_published)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class="ph ph-check-circle mr-1 text-base"></i> Publicado
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="ph ph-clock mr-1 text-base"></i> Borrador
                                    </span>
                                @endif
                            </td>
                            <td class="px-2 py-2">
                                <div class="text-sm font-semibold text-gray-900">{{ $communication->title }}</div>
                                <div class="text-sm text-gray-800 truncate max-w-xs">
                                    {{ Str::limit(strip_tags($communication->content), 80) }}
                                </div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                @php
                                    $categoryColors = [
                                        'urgente' => 'bg-red-100 text-red-800',
                                        'academico' => 'bg-blue-100 text-blue-800',
                                        'evento' => 'bg-purple-100 text-purple-800',
                                    ];
                                    $catColor =
                                        $categoryColors[$communication->category] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $catColor }}">
                                    {{ ucfirst($communication->category) }}
                                </span>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center">
                                @if ($communication->attachments->count() > 0)
                                    <span
                                        class="inline-flex items-center justify-center bg-blue-50 text-blue-600 rounded-md px-2 py-1 text-xs font-semibold">
                                        <i class="ph ph-paperclip mr-1 text-base"></i>
                                        {{ $communication->attachments->count() }}
                                    </span>
                                @else
                                    <span class="text-gray-800">-</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-800">
                                {{ $communication->published_at ? $communication->published_at->format('d/m/Y H:i') : '-' }}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">
                                {{ $communication->author_name }}
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center text-xs font-medium">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false"
                                        class="text-gray-800 hover:text-gray-600 focus:outline-none p-2 rounded-full hover:bg-gray-100 transition-colors">
                                        <i class="ph ph-dots-three-vertical text-xl"></i>
                                    </button>

                                    <div x-show="open" x-transition.opacity
                                        class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10">
                                        <div class="py-1" role="menu">
                                            <button wire:click="edit({{ $communication->id }})"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex items-center">
                                                <i class="ph ph-pencil-simple w-5 text-blue-500 text-lg mr-2"></i>
                                                Editar
                                            </button>
                                            <a href="{{ route('dashboard.comunicados.stats', $communication->id) }}"
                                                class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex items-center">
                                                <i class="ph ph-chart-bar w-5 text-green-500 text-lg mr-2"></i>
                                                Estadísticas
                                            </a>
                                            <button wire:click="togglePublish({{ $communication->id }})"
                                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex items-center">
                                                @if ($communication->is_published)
                                                    <i class="ph ph-eye-slash w-5 text-yellow-500 text-lg mr-2"></i>
                                                    Despublicar
                                                @else
                                                    <i class="ph ph-eye w-5 text-colegio-500 text-lg mr-2"></i>
                                                    Publicar
                                                @endif
                                            </button>
                                            <div class="border-t border-gray-300 my-1"></div>
                                            <button wire:click="confirmDelete({{ $communication->id }})"
                                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                <i class="ph ph-trash w-5 text-red-500 text-lg mr-2"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-2 py-12 text-center">
                                <div
                                    class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                    <i class="ph ph-tray text-3xl text-gray-800"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">No hay comunicados</h3>
                                <p class="mt-1 text-sm text-gray-800">Aún no se ha creado ningún comunicado o ninguno
                                    coincide con tu búsqueda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    @if ($deleteConfirmId)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    wire:click="$set('deleteConfirmId', null)"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="ph ph-warning text-red-600 text-2xl"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Confirmar Eliminación
                                </h3>
                                <div class="mt-2 text-sm text-gray-800">
                                    <p>¿Estás seguro de que deseas eliminar este comunicado?</p>
                                    <p class="text-red-600 mt-2 font-medium">Esta acción no se puede deshacer. Se
                                        eliminarán también todos los archivos adjuntos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="delete" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Eliminar
                        </button>
                        <button wire:click="$set('deleteConfirmId', null)" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

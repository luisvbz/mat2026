<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    <livewire:commons.mod-asistencia />

    {{-- Header Content --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="w-12 h-12 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center mr-4">
                    <i class="ph-fill ph-file-text text-2xl"></i>
                </span>
                Permisos de Alumnos
            </h1>
            <p class="text-gray-500 text-sm mt-1 ml-16">Gestión de inasistencias justificadas, llegadas tarde o salidas tempranas.</p>
        </div>
        <div>
            <a href="{{ route('permisos-alumnos.nuevo') }}"
                class="inline-flex flex-row items-center justify-center px-4 py-2 bg-colegio-600 border border-transparent rounded-lg font-medium text-white hover:bg-colegio-700 focus:outline-none transition-colors shadow-sm">
                <i class="ph-bold ph-plus mr-2 text-lg"></i> Nuevo Permiso
            </a>
        </div>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-visible relative z-20">
        <div class="overflow-x-auto pb-32">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nivel / Grado</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Alumno</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Entrada (Desde)</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Salida (Hasta)</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Motivo</th>
                        <th scope="col" class="px-6 py-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($permisos as $permiso)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($permiso->tipo == 'E')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <i class="ph-fill ph-clock-user mr-1"></i> Entrada Tarde
                                    </span>
                                @elseif($permiso->tipo == 'S')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        <i class="ph-fill ph-sign-out mr-1"></i> Salida Temprana
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <i class="ph-fill ph-calendar-plus mr-1"></i> Falta Justificada
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                <div class="font-medium text-gray-900">{{ $permiso->alumno->nivel == 'P' ? 'Primaria' : 'Secundaria' }}</div>
                                <div class="text-xs text-gray-500">{{ $permiso->alumno->grado | grado }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-semibold text-gray-900">
                                    {{ $permiso->alumno->alumno->nombres }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-700">
                                @if($permiso->tipo == 'E')
                                    <span class="bg-gray-100 px-2 py-1 rounded text-gray-700">{{ $permiso->hasta | date:'d/m/Y h:i A' }}</span>
                                @elseif($permiso->tipo == 'S')
                                    <span class="text-gray-400">--</span>
                                @else
                                    <span class="bg-gray-100 px-2 py-1 rounded text-gray-700">{{ $permiso->desde | date:'d/m/Y' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-gray-700">
                                @if($permiso->tipo == 'E')
                                    <span class="text-gray-400">--</span>
                                @elseif($permiso->tipo == 'S')
                                    <span class="bg-gray-100 px-2 py-1 rounded text-gray-700">{{ $permiso->desde | date:'d/m/Y h:i A' }}</span>
                                @else
                                    <span class="bg-gray-100 px-2 py-1 rounded text-gray-700">{{ $permiso->hasta | date:'d/m/Y' }}</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 italic truncate max-w-xs" title="{{ $permiso->comentario }}">
                                {{ $permiso->comentario }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="relative inline-block text-left" x-data="{ open: false }">
                                    <button @click="open = !open" @click.away="open = false" class="text-gray-400 hover:text-gray-600 focus:outline-none p-2 rounded-full hover:bg-gray-100 transition-colors">
                                        <i class="ph ph-dots-three-outline-vertical text-xl"></i>
                                    </button>

                                    <div x-show="open" x-transition.opacity class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-20">
                                        <div class="py-1">
                                            <a href="{{ route('permisos-alumnos.editar', [$permiso->id]) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 flex items-center">
                                                <i class="ph-bold ph-pencil-simple text-blue-500 text-lg mr-2"></i> Editar
                                            </a>
                                            <div class="border-t border-gray-100 my-1"></div>
                                            <button wire:click="showDialogEliminarPermiso({{ $permiso->id }})" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                                <i class="ph-bold ph-trash text-red-500 text-lg mr-2"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 mb-4">
                                    <i class="ph-fill ph-file-text text-3xl text-gray-400"></i>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900">No hay permisos registrados</h3>
                                <p class="text-sm text-gray-500 mt-1">Aparecerán aquí tras registrar al menos un permiso.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">

    {{-- Header Content --}}
    <div class="sm:flex sm:justify-between sm:items-center">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center">
                <span class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mr-4">
                    <i class="ph-fill ph-calendar-x text-2xl"></i>
                </span>
                Gestión de Feriados
            </h1>
            <p class="text-gray-500 text-sm mt-1 ml-16">Administra los días feriados o sin asistencia obligatoria del año
                escolar.</p>
        </div>
        <div>
            <a href="{{ route('asistencias.index') }}"
                class="inline-flex flex-row items-center text-sm font-semibold text-gray-700 hover:text-gray-900 bg-white px-4 py-2 rounded-lg border border-gray-300 shadow-sm transition-colors">
                <i class="ph-bold ph-arrow-left mr-2"></i> Regresar a Asistencias
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Nuevo Feriado Form --}}
        <div class="lg:col-span-1 border border-gray-100 bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold text-gray-800 flex items-center mb-6 border-b border-gray-100 pb-4">
                <i class="ph-fill ph-plus-circle text-colegio-500 mr-2 text-xl"></i> Nuevo Feriado
            </h3>

            <form wire:submit.prevent="guardat" class="space-y-5">
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Fecha del Feriado</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-calendar"></i>
                        </div>
                        <input type="date" wire:model.defer="fecha_feriado"
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('fecha_feriado') border-red-500 ring-1 ring-red-500 @enderror">
                    </div>
                    @error('fecha_feriado')
                        <p class="text-xs text-red-500 mt-1"><i
                                class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-gray-700">Descripción</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <i class="ph ph-text-aa"></i>
                        </div>
                        <input type="text" wire:model.defer="descripcion"
                            placeholder="Ej: Navidad, Día del Maestro..." autofocus
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-colegio-500 focus:border-colegio-500 sm:text-sm @error('descripcion') border-red-500 ring-1 ring-red-500 @enderror">
                    </div>
                    @error('descripcion')
                        <p class="text-xs text-red-500 mt-1"><i
                                class="ph-fill ph-warning-circle mr-1"></i>{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex justify-center items-center px-4 py-2 bg-colegio-600 border border-transparent rounded-lg font-medium text-white hover:bg-colegio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-colors shadow-sm">
                        <i class="ph-bold ph-floppy-disk mr-2"></i> Guardar Feriado
                    </button>
                </div>
            </form>
        </div>

        {{-- Lista de Feriados --}}
        <div class="lg:col-span-2 border border-gray-100 bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <i class="ph-fill ph-list-dashes text-colegio-500 mr-2 text-xl"></i> Listado de Feriados
                </h3>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Fecha</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Descripción</th>
                            <th scope="col"
                                class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($feriados as $feriado)
                            @php
                                $fechaRaw = \Carbon\Carbon::parse($feriado->getRawOriginal('fecha_feriado'));
                                $esPasado = $fechaRaw->isPast() && !$fechaRaw->isToday();
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium {{ $esPasado ? 'bg-gray-100 text-gray-600' : 'bg-blue-100 text-blue-800' }}">
                                        <i class="ph-fill ph-calendar-blank mr-2"></i> {{ $feriado->fecha_feriado }}
                                    </span>
                                </td>
                                <td
                                    class="px-6 py-4 text-sm {{ $esPasado ? 'text-gray-500 italic' : 'text-gray-900 font-medium' }}">
                                    {{ $feriado->descripcion }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    @if (!$esPasado)
                                        <button wire:click="showDialogEliminar({{ $feriado->id }})"
                                            class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors focus:outline-none"
                                            title="Eliminar feriado pendiente">
                                            <i class="ph-bold ph-trash text-lg"></i>
                                        </button>
                                    @else
                                        <button disabled
                                            class="text-gray-400 bg-gray-50 p-2 rounded-lg cursor-not-allowed"
                                            title="No se puede eliminar un feriado que ya ha pasado">
                                            <i class="ph-bold ph-trash text-lg opacity-50"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-sm text-gray-500">
                                    <div
                                        class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-gray-50 mb-3">
                                        <i class="ph-fill ph-calendar-slash text-2xl text-gray-400"></i>
                                    </div>
                                    <p class="font-medium text-gray-900">No hay feriados registrados</p>
                                    <p class="mt-1">Aparecerán aquí tras registrar al menos uno.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

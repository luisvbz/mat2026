<div class="p-6 max-w-7xl mx-auto space-y-6" x-data="{
    activeTab: 'estudiante',
    copiar(text) {
        Copy(text);
        Livewire.emit('swal:alert', { icon: 'success', title: 'Copiado!', timeout: 1000 });
    }
}">

    {{-- Header --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex justify-between items-center">
        <div class="text-xl font-bold text-gray-800 flex items-center gap-2">
            <i class="ph ph-graduation-cap text-colegio-600 text-2xl"></i>
            Detalle Matrícula: {{ $matricula->codigo }}
            @if ($matricula->numero_matricula != null)
                <span class="text-gray-400 font-normal text-lg">#{{ $matricula->numero_matricula }}</span>
            @endif
        </div>
        <div>{!! $matricula->status !!}</div>
    </div>

    {{-- Quick Info Card --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="flex-shrink-0">
                <img src="{{ $matricula->alumno->foto }}"
                    class="w-24 h-24 rounded-full object-cover border-4 border-gray-50 shadow-sm">
            </div>
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">{{ $matricula->alumno->nombre_completo }}</h2>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3">
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-50 text-blue-700">
                        <i class="ph ph-identification-card mr-1.5"></i>
                        {{ $matricula->alumno->tipo_documento }}: {{ $matricula->alumno->numero_documento }}
                    </span>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-50 text-purple-700">
                        <i class="ph ph-cake mr-1.5"></i>
                        {{ $matricula->alumno->edad }} años
                    </span>
                    <span
                        class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-colegio-50 text-colegio-700">
                        <i class="ph ph-student mr-1.5"></i>
                        {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }} - {{ $matricula->grado }}°
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="flex gap-2 overflow-x-auto border-b border-gray-200 sticky top-0 z-10 bg-gray-50">
        @php
            $tabs = [
                ['id' => 'estudiante', 'icon' => 'ph-student', 'label' => 'Estudiante'],
                ['id' => 'padres', 'icon' => 'ph-users-three', 'label' => 'Padres'],
                ['id' => 'apoderados', 'icon' => 'ph-user-focus', 'label' => 'Apoderados'],
                ['id' => 'responsable_economico', 'icon' => 'ph-wallet', 'label' => 'Resp. Económico'],
                ['id' => 'pagos', 'icon' => 'ph-money', 'label' => 'Pagos'],
                ['id' => 'horario', 'icon' => 'ph-clock', 'label' => 'Horario'],
                ['id' => 'usuarios', 'icon' => 'ph-shield-check', 'label' => 'Usuarios'],
            ];
        @endphp
        @foreach ($tabs as $tab)
            <button @click="activeTab = '{{ $tab['id'] }}'"
                class="px-5 py-3 text-sm font-medium rounded-t-lg transition-colors flex items-center gap-2 border-b-2 whitespace-nowrap"
                :class="activeTab === '{{ $tab['id'] }}' ? 'border-colegio-500 text-colegio-600 bg-white' :
                    'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-50 hover:border-gray-300'">
                <i class="ph {{ $tab['icon'] }} text-lg"></i>
                <span>{{ $tab['label'] }}</span>
            </button>
        @endforeach
    </div>

    {{-- Tab Content Container --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 min-h-[400px]">

        {{-- Tab: Estudiante --}}
        <div x-show="activeTab === 'estudiante'" x-cloak>
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                <div class="flex items-center gap-2 text-lg font-bold text-gray-800">
                    <i class="ph ph-student text-colegio-500"></i>
                    <span>Información del Estudiante</span>
                </div>
                @if (!$editMode)
                    <button wire:click="toggleEditMode"
                        class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-100 transition-colors">
                        <i class="ph ph-pencil-simple mr-2"></i> Editar
                    </button>
                @else
                    <button wire:click="cancelEdit"
                        class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 rounded-lg text-sm font-medium text-red-700 hover:bg-red-100 transition-colors">
                        <i class="ph ph-x mr-2"></i> Cancelar
                    </button>
                @endif
            </div>

            @if (!$editMode)
                {{-- Read Only View --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    {{-- Datos Personales --}}
                    <div>
                        <h3 class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                            <i class="ph ph-identification-card text-gray-500"></i> Datos Personales
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Tipo de Documento</span>
                                <span class="font-medium text-gray-800">{{ $matricula->alumno->tipo_documento }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Número de Documento</span>
                                <span class="font-medium text-gray-800 flex items-center gap-2">
                                    {{ $matricula->alumno->numero_documento }}
                                    <button @click="copiar('{{ $matricula->alumno->numero_documento }}')"
                                        class="text-gray-400 hover:text-colegio-600"><i class="ph ph-copy"></i></button>
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Nombres Completos</span>
                                <span class="font-medium text-gray-800 flex items-center gap-2">
                                    {{ $matricula->alumno->nombre_completo }}
                                    <button @click="copiar('{{ $matricula->alumno->nombre_completo }}')"
                                        class="text-gray-400 hover:text-colegio-600"><i class="ph ph-copy"></i></button>
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Fecha de Nacimiento</span>
                                <span
                                    class="font-medium text-gray-800">{{ $matricula->alumno->fecha_nacimiento | dateFormat }}
                                    ({{ $matricula->alumno->edad }} años)</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Género</span>
                                <span
                                    class="font-medium text-gray-800">{{ $matricula->alumno->genero == 'M' ? 'Masculino' : 'Femenino' }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Datos de Contacto --}}
                    <div>
                        <h3 class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                            <i class="ph ph-phone text-gray-500"></i> Datos de Contacto
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Celular</span>
                                <span class="font-medium text-gray-800 flex items-center gap-2">
                                    {{ $matricula->alumno->celular }}
                                    <button @click="copiar('{{ $matricula->alumno->celular }}')"
                                        class="text-gray-400 hover:text-colegio-600"><i class="ph ph-copy"></i></button>
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Teléfono de Emergencia</span>
                                <span class="font-medium text-gray-800 flex items-center gap-2">
                                    {{ $matricula->alumno->telefono_emergencia }}
                                    <button @click="copiar('{{ $matricula->alumno->telefono_emergencia }}')"
                                        class="text-gray-400 hover:text-colegio-600"><i class="ph ph-copy"></i></button>
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Correo Electrónico</span>
                                <span class="font-medium text-gray-800 flex items-center gap-2">
                                    {{ strtolower($matricula->alumno->correo) }}
                                    <button @click="copiar('{{ strtolower($matricula->alumno->correo) }}')"
                                        class="text-gray-400 hover:text-colegio-600"><i class="ph ph-copy"></i></button>
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Datos de Ubicación --}}
                    <div>
                        <h3 class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                            <i class="ph ph-map-pin text-gray-500"></i> Datos de Ubicación
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Dirección</span>
                                <span class="font-medium text-gray-800">{{ $matricula->alumno->domicilio }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Lugar</span>
                                <span class="font-medium text-gray-800">
                                    {{ $matricula->alumno->departamento->nombre ?? '' }},
                                    {{ $matricula->alumno->provincia->nombre ?? '' }},
                                    {{ $matricula->alumno->distrito->nombre ?? '' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Datos Académicos --}}
                    <div>
                        <h3 class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                            <i class="ph ph-books text-gray-500"></i> Datos Académicos y Religiosos
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Colegio de Procedencia</span>
                                <span
                                    class="font-medium text-gray-800">{{ $matricula->alumno->colegio_procedencia }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Religión</span>
                                <span
                                    class="font-medium text-gray-800">{{ $matricula->alumno->religion ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Exonerado de Religión</span>
                                <span class="font-medium">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $matricula->alumno->exonerado_religion ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $matricula->alumno->exonerado_religion ? 'Sí' : 'No' }}
                                    </span>
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Bautizado</span>
                                <span class="font-medium">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $matricula->alumno->bautizado ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $matricula->alumno->bautizado ? 'Sí' : 'No' }}
                                    </span>
                                </span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-gray-50">
                                <span class="text-gray-500">Primera Comunión</span>
                                <span class="font-medium">
                                    <span
                                        class="px-2 py-1 rounded text-xs {{ $matricula->alumno->comunion ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $matricula->alumno->comunion ? 'Sí' : 'No' }}
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                {{-- Formulario Edición Estudiante --}}
                <form wire:submit.prevent="actualizarAlumno" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo de Documento</label>
                            <select wire:model="tipo_documento"
                                class="w-full rounded-lg border-gray-300 focus:border-colegio-500 focus:ring-colegio-500 shadow-sm">
                                <option value="DNI">DNI</option>
                                <option value="CE">CE</option>
                                <option value="PTP">PTP</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Número de Documento</label>
                            <input type="text" wire:model="numero_documento"
                                class="w-full rounded-lg border-gray-300 focus:border-colegio-500 focus:ring-colegio-500 shadow-sm">
                            @error('numero_documento')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Nacimiento</label>
                            <input type="date" wire:model="fecha_nacimiento"
                                class="w-full rounded-lg border-gray-300 focus:border-colegio-500 focus:ring-colegio-500 shadow-sm">
                            @error('fecha_nacimiento')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Género</label>
                            <select wire:model="genero"
                                class="w-full rounded-lg border-gray-300 focus:border-colegio-500 focus:ring-colegio-500 shadow-sm">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellido Paterno</label>
                            <input type="text" wire:model="apellido_paterno"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                            @error('apellido_paterno')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apellido Materno</label>
                            <input type="text" wire:model="apellido_materno"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                            @error('apellido_materno')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                            <input type="text" wire:model="nombres"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                            @error('nombres')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                            <input type="text" wire:model="celular"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono Emergencia</label>
                            <input type="text" wire:model="telefono_emergencia"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Correo Electrónico</label>
                            <input type="email" wire:model="correo"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                            @error('correo')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                        <input type="text" wire:model="domicilio"
                            class="w-full rounded-lg border-gray-300 shadow-sm">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Colegio de Procedencia</label>
                            <input type="text" wire:model="colegio_procedencia"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Religión</label>
                            <input type="text" wire:model="religion"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50 p-4 rounded-lg">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="exonerado_religion"
                                class="form-checkbox h-5 w-5 text-colegio-600 rounded">
                            <span class="text-sm font-medium text-gray-700">Exonerado de Religión</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="bautizado"
                                class="form-checkbox h-5 w-5 text-colegio-600 rounded">
                            <span class="text-sm font-medium text-gray-700">Bautizado</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" wire:model="comunion"
                                class="form-checkbox h-5 w-5 text-colegio-600 rounded">
                            <span class="text-sm font-medium text-gray-700">Comunión</span>
                        </label>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-colegio-600 text-white rounded-lg font-medium hover:bg-colegio-700 transition-colors">
                            <i class="ph ph-floppy-disk mr-2"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            @endif
        </div>

        {{-- Tab: Padres --}}
        <div x-show="activeTab === 'padres'" x-cloak class="space-y-6">
            @forelse($matricula->alumno->padres as $padre)
                <div
                    class="border {{ $editMode && $padre_edit_id == $padre->id ? 'border-colegio-500 bg-blue-50/10 shadow-md' : 'border-gray-200' }} rounded-xl p-6">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                        <div class="flex items-center gap-2 text-lg font-bold text-gray-800">
                            <i class="ph ph-user text-colegio-500"></i>
                            <span>
                                {{ $padre->parentesco == 'P' ? 'Padre' : 'Madre' }}
                                @if (!$padre->vive)
                                    <span
                                        class="ml-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded font-medium">Fallecido(a)</span>
                                @endif
                            </span>
                        </div>
                        @if (!$editMode || $padre_edit_id != $padre->id)
                            <button wire:click="editarPadre({{ $padre->id }})"
                                class="inline-flex items-center px-3 py-1.5 bg-gray-50 border border-gray-300 rounded text-sm font-medium text-gray-700 hover:bg-gray-100">
                                <i class="ph ph-pencil-simple mr-2"></i> Editar
                            </button>
                        @else
                            <button wire:click="cancelEdit"
                                class="inline-flex items-center px-3 py-1.5 bg-red-50 border border-red-200 rounded text-sm font-medium text-red-700 hover:bg-red-100">
                                <i class="ph ph-x mr-2"></i> Cancelar
                            </button>
                        @endif
                    </div>

                    @if (!$editMode || $padre_edit_id != $padre->id)
                        {{-- Lectura Padre --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <div>
                                <h3
                                    class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                                    <i class="ph ph-identification-card text-gray-500"></i> Datos Personales
                                </h3>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Documento</span>
                                        <span class="font-medium text-gray-800 flex items-center gap-2">
                                            {{ $padre->tipo_documento }}: {{ $padre->numero_documento }}
                                            <button @click="copiar('{{ $padre->numero_documento }}')"
                                                class="text-gray-400 hover:text-colegio-600"><i
                                                    class="ph ph-copy"></i></button>
                                        </span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Nombre Completo</span>
                                        <span class="font-medium text-gray-800 flex items-center gap-2">
                                            {{ $padre->nombre_completo }}
                                            <button @click="copiar('{{ $padre->nombre_completo }}')"
                                                class="text-gray-400 hover:text-colegio-600"><i
                                                    class="ph ph-copy"></i></button>
                                        </span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Estado Civil</span>
                                        <span
                                            class="font-medium text-gray-800">{{ $padre->estado_civil | edoCivil }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Nivel Escolaridad</span>
                                        <span class="font-medium text-gray-800">{{ $padre->nivel_escolaridad }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <h3
                                    class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                                    <i class="ph ph-phone text-gray-500"></i> Datos de Contacto
                                </h3>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Celular</span>
                                        <span class="font-medium text-gray-800 flex items-center gap-2">
                                            {{ $padre->telefono_celular }}
                                            <button @click="copiar('{{ $padre->telefono_celular }}')"
                                                class="text-gray-400 hover:text-colegio-600"><i
                                                    class="ph ph-copy"></i></button>
                                        </span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Correo</span>
                                        <span class="font-medium text-gray-800 flex items-center gap-2">
                                            {{ strtolower($padre->correo_electronico) }}
                                            <button @click="copiar('{{ strtolower($padre->correo_electronico) }}')"
                                                class="text-gray-400 hover:text-colegio-600"><i
                                                    class="ph ph-copy"></i></button>
                                        </span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Dirección</span>
                                        <span class="font-medium text-gray-800">{{ $padre->domicilio }}</span>
                                    </div>
                                </div>

                                <h3
                                    class="flex items-center gap-2 font-semibold text-gray-700 mt-6 mb-4 bg-gray-50 p-2 rounded-lg">
                                    <i class="ph ph-briefcase text-gray-500"></i> Laboral
                                </h3>
                                <div class="space-y-3 text-sm">
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Centro Trabajo</span>
                                        <span class="font-medium text-gray-800">{{ $padre->centro_trabajo }}</span>
                                    </div>
                                    <div class="flex justify-between py-2 border-b border-gray-50">
                                        <span class="text-gray-500">Cargo</span>
                                        <span class="font-medium text-gray-800">{{ $padre->cargo_ocupacion }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap gap-3">
                            <span
                                class="px-3 py-1 rounded-full text-xs font-medium {{ $padre->vive_estudiante ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                <i class="ph ph-house mr-1"></i> Vive Estudiante:
                                {{ $padre->vive_estudiante ? 'Sí' : 'No' }}
                            </span>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-medium {{ $padre->responsable_economico ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                <i class="ph ph-wallet mr-1"></i> Resp. Económico:
                                {{ $padre->responsable_economico ? 'Sí' : 'No' }}
                            </span>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-medium {{ $padre->apoderado ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">
                                <i class="ph ph-shield-check mr-1"></i> Apoderado:
                                {{ $padre->apoderado ? 'Sí' : 'No' }}
                            </span>
                            <span
                                class="px-3 py-1 rounded-full text-xs font-medium {{ $padre->vive ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                <i class="ph ph-heart mr-1"></i> Estado: {{ $padre->vive ? 'Vive' : 'Fallecido' }}
                            </span>
                        </div>
                    @else
                        {{-- Formulario Edición Padre --}}
                        <form wire:submit.prevent="actualizarPadre" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Doc.</label>
                                    <select wire:model="padre_tipo_documento"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                        <option value="DNI">DNI</option>
                                        <option value="CE">CE</option>
                                        <option value="PTP">PTP</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                                    <input type="text" wire:model="padre_numero_documento"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Apellidos</label>
                                    <input type="text" wire:model="padre_apellidos"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nombres</label>
                                    <input type="text" wire:model="padre_nombres"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado Civil</label>
                                    <select wire:model="padre_estado_civil"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                        <option value="S">Soltero(a)</option>
                                        <option value="C">Casado(a)</option>
                                        <option value="V">Viudo(a)</option>
                                        <option value="D">Divorciado(a)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Escolaridad</label>
                                    <input type="text" wire:model="padre_nivel_escolaridad"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Celular</label>
                                    <input type="text" wire:model="padre_telefono_celular"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Correo
                                        Electrónico</label>
                                    <input type="email" wire:model="padre_correo_electronico"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                                    <input type="text" wire:model="padre_domicilio"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Centro Trabajo</label>
                                    <input type="text" wire:model="padre_centro_trabajo"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Cargo/Ocupación</label>
                                    <input type="text" wire:model="padre_cargo_ocupacion"
                                        class="w-full rounded-lg border-gray-300 shadow-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gray-50 p-4 rounded-lg">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="padre_vive_estudiante"
                                        class="form-checkbox text-colegio-600 rounded">
                                    <span class="text-sm">Vive c/ estudiante</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="padre_responsable_economico"
                                        class="form-checkbox text-colegio-600 rounded">
                                    <span class="text-sm">Resp. Económico</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="padre_apoderado"
                                        class="form-checkbox text-colegio-600 rounded">
                                    <span class="text-sm">Apoderado</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="checkbox" wire:model="padre_vive"
                                        class="form-checkbox text-colegio-600 rounded">
                                    <span class="text-sm">Vive</span>
                                </label>
                            </div>

                            <div class="flex justify-end pt-4 border-t border-gray-100">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-colegio-600 text-white rounded-lg font-medium hover:bg-colegio-700">
                                    <i class="ph ph-floppy-disk mr-2"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @empty
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-gray-100 border-dashed mb-4">
                    <i class="ph ph-users-three text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500 font-medium">No hay información de padres registrada</p>
                </div>
            @endforelse
        </div>

        {{-- Tab: Apoderados --}}
        <div x-show="activeTab === 'apoderados'" x-cloak class="space-y-6">
            @forelse($matricula->alumno->apoderados as $apoderado)
                <div class="border border-gray-200 rounded-xl p-6">
                    <div
                        class="flex items-center gap-2 text-lg font-bold text-gray-800 border-b border-gray-100 pb-4 mb-6">
                        <i class="ph ph-user-focus text-colegio-500"></i>
                        <span>Tutor / Apoderado</span>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <div>
                            <h3
                                class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                                <i class="ph ph-identification-card text-gray-500"></i> Datos Personales
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between py-2 border-b border-gray-50">
                                    <span class="text-gray-500">Documento</span>
                                    <span class="font-medium text-gray-800">{{ $apoderado->tipo_documento }}:
                                        {{ $apoderado->numero_documento }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-50">
                                    <span class="text-gray-500">Nombre Completo</span>
                                    <span class="font-medium text-gray-800">{{ $apoderado->apellidos }},
                                        {{ ucfirst(strtolower($apoderado->nombres)) }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-50">
                                    <span class="text-gray-500">Parentesco</span>
                                    <span class="font-medium text-gray-800">{{ $apoderado->parentesco }}</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="flex items-center gap-2 font-semibold text-gray-700 mb-4 bg-gray-50 p-2 rounded-lg">
                                <i class="ph ph-phone text-gray-500"></i> Contacto
                            </h3>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between py-2 border-b border-gray-50">
                                    <span class="text-gray-500">Celular</span>
                                    <span class="font-medium text-gray-800">{{ $apoderado->telefono_celular }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b border-gray-50">
                                    <span class="text-gray-500">Correo</span>
                                    <span
                                        class="font-medium text-gray-800">{{ strtolower($apoderado->correo_electronico) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-gray-100 border-dashed mb-4">
                    <i class="ph ph-user-focus text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500 font-medium">No hay apoderados registrados extra.</p>
                </div>
            @endforelse
        </div>

        {{-- Tab: Responsable Económico --}}
        <div x-show="activeTab === 'responsable_economico'" x-cloak>
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                <div class="flex items-center gap-2 text-lg font-bold text-gray-800">
                    <i class="ph ph-wallet text-colegio-500"></i>
                    <span>Responsable Económico</span>
                </div>
                @if (!$editMode)
                    <button wire:click="toggleEditMode"
                        class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-300 rounded text-sm font-medium hover:bg-gray-100">
                        <i class="ph ph-pencil-simple mr-2"></i> Editar
                    </button>
                @else
                    <button wire:click="cancelEdit"
                        class="inline-flex items-center px-4 py-2 bg-red-50 border border-red-200 rounded text-sm font-medium text-red-700 hover:bg-red-100">
                        <i class="ph ph-x mr-2"></i> Cancelar
                    </button>
                @endif
            </div>

            @if (!$editMode)
                <div class="w-full max-w-lg space-y-3 text-sm">
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-gray-500">Tipo de Documento</span>
                        <span class="font-medium text-gray-800">{{ $matricula->tipo_documento_dj ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-gray-500">Número de Documento</span>
                        <span class="font-medium text-gray-800 flex items-center gap-2">
                            {{ $matricula->numero_documento_dj ?? 'N/A' }}
                            @if ($matricula->numero_documento_dj)
                                <button @click="copiar('{{ $matricula->numero_documento_dj }}')"
                                    class="text-gray-400 hover:text-colegio-600"><i class="ph ph-copy"></i></button>
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between py-3 border-b border-gray-100">
                        <span class="text-gray-500">Nombres Completos</span>
                        <span class="font-medium text-gray-800 flex items-center gap-2">
                            {{ $matricula->nombres_dj ?? 'N/A' }}
                            @if ($matricula->nombres_dj)
                                <button @click="copiar('{{ $matricula->nombres_dj }}')"
                                    class="text-gray-400 hover:text-colegio-600"><i class="ph ph-copy"></i></button>
                            @endif
                        </span>
                    </div>
                </div>
            @else
                <form wire:submit.prevent="actualizarResponsableEconomico" class="space-y-6 max-w-3xl">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tipo Doc.</label>
                            <select wire:model="tipo_documento_dj"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                                <option value="DNI">DNI</option>
                                <option value="CE">CE</option>
                                <option value="PTP">PTP</option>
                                <option value="PN">PN</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Número Documento</label>
                            <input type="text" wire:model="numero_documento_dj"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                            @error('numero_documento_dj')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nombres Completos</label>
                            <input type="text" wire:model="nombres_dj"
                                class="w-full rounded-lg border-gray-300 shadow-sm">
                            @error('nombres_dj')
                                <span class="text-red-500 text-xs">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex justify-end pt-4" style="border-top:1px solid #f3f4f6;">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-colegio-600 text-white rounded-lg font-medium hover:bg-colegio-700">
                            <i class="ph ph-floppy-disk mr-2"></i> Guardar
                        </button>
                    </div>
                </form>
            @endif
        </div>

        {{-- Tab: Pagos --}}
        <div x-show="activeTab === 'pagos'" x-cloak>
            <div class="flex items-center gap-2 text-lg font-bold text-gray-800 border-b border-gray-100 pb-4 mb-6">
                <i class="ph ph-money text-colegio-500"></i>
                <span>Historial de Pagos</span>
            </div>

            @if (count($matricula->pagos) > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Concepto
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Método</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Operación
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Monto</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($matricula->pagos as $pago)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm">{!! $pago->status !!}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 font-medium">
                                        {{ $pago->concepto == 'M' ? 'Matrícula' : 'Pensión' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $pago->tipo_pago | mp }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pago->numero_operacion }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-bold text-gray-900">
                                        S./ {{ number_format($pago->monto_pagado, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $pago->fecha_deposito | dateFormat }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-10 bg-gray-50 rounded-xl border border-gray-100 border-dashed">
                    <i class="ph ph-money text-4xl text-gray-400 mb-2"></i>
                    <p class="text-gray-500 font-medium">No hay pagos registrados en esta matrícula</p>
                </div>
            @endif
        </div>

        {{-- Tab: Horario --}}
        <div x-show="activeTab === 'horario'" x-cloak>
            <div class="flex items-center gap-2 text-lg font-bold text-gray-800 border-b border-gray-100 pb-4 mb-6">
                <i class="ph ph-clock text-colegio-500"></i>
                <span>Horario del Estudiante</span>
            </div>
            <form wire:submit.prevent='actualizarHoras'
                class="max-w-xl mx-auto bg-gray-50 p-6 rounded-xl border border-gray-100">
                <div class="flex flex-col md:flex-row gap-6 items-end">
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora de Entrada</label>
                        <input type="time" wire:model="hora_entrada"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-colegio-500">
                    </div>
                    <div class="flex-1 w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Hora de Salida</label>
                        <input type="time" wire:model="hora_salida"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-colegio-500">
                    </div>
                    <div>
                        <button type="submit"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-colegio-600 text-white rounded-lg font-medium hover:bg-colegio-700">
                            <i class="ph ph-save mr-2"></i> Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tab: Usuarios --}}
        <div x-show="activeTab === 'usuarios'" x-cloak>
            <div class="flex items-center gap-2 text-lg font-bold text-gray-800 border-b border-gray-100 pb-4 mb-6">
                <i class="ph ph-shield-check text-colegio-500"></i>
                <span>Acceso de Padres al Portal</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($matricula->alumno->padres as $padre)
                    <div
                        class="border border-gray-200 rounded-xl p-5 bg-white shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h5 class="text-base font-bold text-gray-800">{{ $padre->nombre_completo }}</h5>
                                <span
                                    class="px-2 py-0.5 mt-1 inline-block bg-gray-100 text-gray-600 text-xs rounded font-medium">
                                    {{ $padre->parentesco == 'P' ? 'PADRE' : 'MADRE' }}
                                </span>
                            </div>
                            @if ($padre->user)
                                <span
                                    class="px-2 py-1 rounded text-xs font-bold {{ $padre->user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $padre->user->is_active ? 'ACTIVO' : 'INACTIVO' }}
                                </span>
                            @else
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs font-bold">SIN
                                    CUENTA</span>
                            @endif
                        </div>

                        @if ($padre->user)
                            <div class="bg-gray-50 rounded-lg p-3 text-sm space-y-2 mb-4">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Usuario (DNI)</span>
                                    <span class="font-bold text-gray-800">{{ $padre->user->document_number }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Último Acceso</span>
                                    <span
                                        class="text-gray-800">{{ $padre->user->last_login_at ? $padre->user->last_login_at->diffForHumans() : 'Nunca' }}</span>
                                </div>
                            </div>

                            <div class="flex gap-2 mt-4 pt-4 border-t border-gray-100">
                                <button wire:click="resetearPasswordPadre({{ $padre->user->id }})"
                                    class="flex-1 inline-flex justify-center items-center px-3 py-1.5 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded text-sm hover:bg-yellow-100 transition-colors"
                                    onclick="confirm('¿Estás seguro de restablecer la contraseña al número de documento?') || event.stopImmediatePropagation()">
                                    <i class="ph ph-key mr-2"></i> Reset Clave
                                </button>

                                <button wire:click="toggleUsuarioPadre({{ $padre->user->id }})"
                                    class="flex-1 inline-flex justify-center items-center px-3 py-1.5 border rounded text-sm transition-colors {{ $padre->user->is_active ? 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' : 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100' }}">
                                    <i
                                        class="ph {{ $padre->user->is_active ? 'ph-user-minus' : 'ph-user-check' }} mr-2"></i>
                                    {{ $padre->user->is_active ? 'Desactivar' : 'Activar' }}
                                </button>
                            </div>
                        @else
                            <div class="text-center py-4 bg-gray-50 rounded-lg">
                                <p class="text-sm text-gray-500 mb-3 px-4">Este padre no tiene un usuario para acceder
                                    a la aplicación móvil.</p>
                                <button wire:click="crearUsuarioPadre({{ $padre->id }})"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-full text-sm font-medium hover:bg-green-700 shadow-sm transition-colors">
                                    <i class="ph ph-user-plus mr-2"></i> Crear Usuario
                                </button>
                            </div>
                        @endif
                    </div>
                @empty
                    <div
                        class="col-span-full text-center py-10 bg-gray-50 rounded-xl border border-gray-100 border-dashed">
                        <i class="ph ph-users-three text-4xl text-gray-400 mb-2"></i>
                        <p class="text-gray-500 font-medium">No hay información de padres registrada para este
                            estudiante.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    {{-- Loading Overlay Tailwind --}}
    <div wire:loading.flex
        wire:target="actualizarAlumno,actualizarPadre,actualizarHoras,actualizarResponsableEconomico"
        class="fixed inset-0 z-50 bg-white/70 backdrop-blur-sm flex-col items-center justify-center hidden">
        <div class="animate-spin text-colegio-500 mb-4">
            <i class="ph ph-circle-notch text-5xl"></i>
        </div>
        <div class="text-lg font-semibold text-gray-700 animate-pulse">
            Procesando...
        </div>
    </div>
</div>

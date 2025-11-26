@section('title', 'Matrícula Online')

<main class="container mx-auto px-4 py-10 space-y-8">

    <!-- Loading -->
    <div class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center" wire:loading
        wire:target="guardarPaso1, guardarPaso2, guardarPaso3, guardarPaso4, generarFicha, buscarEstudiante" style="display: none;">
        <div class="bg-white rounded-xl p-6 text-center shadow-lg">
            <div class="w-10 h-10 mx-auto mb-3 border-4 border-primary/30 border-t-primary rounded-full animate-spin">
            </div>
            <p class="text-gray-700 text-sm font-medium" wire:loading wire:target="generarFicha">Generando ficha...</p>
            <p class="text-gray-700 text-sm font-medium" wire:loading wire:target="buscarEstudiante">Buscando alumno...</p>
            <p class="text-gray-700 text-sm font-medium" wire:loading wire:target="guardarPaso1, guardarPaso2, guardarPaso3, guardarPaso4">Procesando...</p>
        </div>
    </div>

    @if($isMatriculaActive)
        <!-- Steps -->
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-center space-x-2">
                <!-- Paso 1 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                        @if ($step == 1) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                        @else bg-green-500 text-white @endif">
                        @if ($step > 1)
                            <i class="fas fa-check"></i>
                        @else
                            1
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold">Estudiante</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200">
                    <div
                        class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 2) w-full @else w-0 @endif">
                    </div>
                </div>
                <!-- Paso 2 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                        @if ($step == 2) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                        @elseif($step > 2) bg-green-500 text-white
                        @else bg-gray-300 text-gray-500 @endif">
                        @if ($step > 2)
                            <i class="fas fa-check"></i>
                        @else
                            2
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold">Padres</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200">
                    <div
                        class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 3) w-full @else w-0 @endif">
                    </div>
                </div>
                <!-- Paso 3 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                        @if ($step == 3) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                        @elseif($step > 3) bg-green-500 text-white
                        @else bg-gray-300 text-gray-500 @endif">
                        @if ($step > 3)
                            <i class="fas fa-check"></i>
                        @else
                            3
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold">Salud</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200">
                    <div
                        class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 4) w-full @else w-0 @endif">
                    </div>
                </div>
                <!-- Paso 4 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                        @if ($step == 4) bg-gradient-to-r from-primary to-red-700 text-white shadow-md
                        @elseif($step > 4) bg-green-500 text-white
                        @else bg-gray-300 text-gray-500 @endif">
                        @if ($step > 4)
                            <i class="fas fa-check"></i>
                        @else
                            4
                        @endif
                    </div>
                    <span class="mt-2 text-xs font-semibold">Verificación</span>
                </div>
                <div class="flex-1 h-0.5 bg-gray-200">
                    <div
                        class="h-full bg-gradient-to-r from-primary to-red-700 transition-all duration-500 @if ($step >= 5) w-full @else w-0 @endif">
                    </div>
                </div>
                <!-- Paso 5 -->
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm
                        @if ($step == 5) bg-green-500 text-white
                        @else bg-gray-300 text-gray-500 @endif">
                        <i class="fas fa-check-double"></i>
                    </div>
                    <span class="mt-2 text-xs font-semibold">Finalizado</span>
                </div>
            </div>
        </div>

        <!-- Contenido -->
        <div class="max-w-4xl mx-auto">
            @if($step == 1)
                <div class="bg-white rounded-xl p-8 shadow-md space-y-6 animate-fade-in">
                    <h2 class="text-xl font-bold text-gray-800">Datos personales del estudiante</h2>
                    <form wire:submit.prevent="guardarPaso1" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de documento</label>
                                <select wire:model.debounce.500ms="estudiante.tipo_documento" @if($estudiante['finded']) disabled @endif class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('estudiante.tipo_documento') border-red-500 @enderror">
                                    <option value="DNI">DNI</option>
                                    <option value="CE">CE</option>
                                    <option value="PTP">PTP</option>
                                    <option value="PN">Partida de Nac.</option>
                                </select>
                                @error('estudiante.tipo_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Numero de Documento</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.numero_documento" class="flex-1 block w-full rounded-none rounded-l-md sm:text-sm border-gray-300 @error('estudiante.numero_documento') border-red-500 @enderror" />
                                    <button wire:click="buscarEstudiante" type="button" class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                                @error('estudiante.numero_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Genero</label>
                                <select wire:model.debounce.500ms="estudiante.genero" @if($estudiante['finded']) disabled @endif class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-primary focus:border-primary sm:text-sm @error('estudiante.genero') border-red-500 @enderror">
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="F">Femenino</option>
                                    <option value="M">Masculino</option>
                                </select>
                                @error('estudiante.genero') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellido Paterno</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.apellido_paterno" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.apellido_paterno') border-red-500 @enderror" />
                                @error('estudiante.apellido_paterno') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellido Materno</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.apellido_materno" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.apellido_materno') border-red-500 @enderror" />
                                @error('estudiante.apellido_materno') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.nombres" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.nombres') border-red-500 @enderror" />
                                @error('estudiante.nombres') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nacionalidad</label>
                                <select @if($estudiante['finded']) disabled @endif wire:model.debounce.500ms="estudiante.nacionalidad" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('estudiante.nacionalidad') border-red-500 @enderror">
                                    <option value="" disabled selected>Seleccione</option>
                                    @foreach($paises as $pais)
                                        <option value="{{ $pais->gentilicio }}">{{ $pais->gentilicio }}</option>
                                    @endforeach
                                </select>
                                @error('estudiante.nacionalidad') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Departamento</label>
                                <select wire:model.debounce.500ms="estudiante.departamento" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('estudiante.departamento') border-red-500 @enderror">
                                    <option value="">Seleccione</option>
                                    @foreach($departamentos as $departamento)
                                        <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('estudiante.departamento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Provincia</label>
                                <select wire:model.debounce.500ms="estudiante.provincia" @if(sizeof($provincias) == 0) disabled @endif class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('estudiante.provincia') border-red-500 @enderror">
                                    <option value="">Seleccione</option>
                                    @foreach($provincias as $provincia)
                                        <option value="{{ $provincia->id }}">{{ $provincia->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('estudiante.provincia') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Distrito</label>
                                <select wire:model.debounce.500ms="estudiante.distrito" @if(sizeof($distritos) == 0) disabled @endif class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('estudiante.distrito') border-red-500 @enderror">
                                    <option value="">Seleccione</option>
                                    @foreach($distritos as $distrito)
                                        <option value="{{ $distrito->id }}">{{ $distrito->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('estudiante.distrito') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha Nacimiento</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.lazy="estudiante.fecha_nac" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.fecha_nac') border-red-500 @enderror" id="fecha-nacimiento"/>
                                @error('estudiante.fecha_nac') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Domicilio</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.domicilio" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.domicilio') border-red-500 @enderror" />
                                @error('estudiante.domicilio') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefono Fijo</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.telefono_fijo" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.telefono_fijo') border-red-500 @enderror" />
                                @error('estudiante.telefono_fijo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefono Celular</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.telefono_celular" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.telefono_celular') border-red-500 @enderror" />
                                @error('estudiante.telefono_celular') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefono Emergencia</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.telefono_emergencia" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.telefono_emergencia') border-red-500 @enderror" />
                                @error('estudiante.telefono_emergencia') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                            <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.correo_electronico" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.correo_electronico') border-red-500 @enderror" />
                            @error('estudiante.correo_electronico') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Colegio de procedencia</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.colegio_procedencia" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.colegio_procedencia') border-red-500 @enderror" />
                                @error('estudiante.colegio_procedencia') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Situación final</label>
                                <select @if($estudiante['finded']) disabled @endif wire:model.debounce.500ms="estudiante.situacion_final" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('estudiante.situacion_final') border-red-500 @enderror">
                                    <option value="" selected disabled>Seleccione</option>
                                    <option value="APROBADO">APROBADO</option>
                                    <option value="REPITIENTE">REPITIENTE</option>
                                </select>
                                @error('estudiante.situacion_final') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Religión</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.religion" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.religion') border-red-500 @enderror" />
                                @error('estudiante.religion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Parroquia</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.parroquia" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.parroquia') border-red-500 @enderror" />
                                @error('estudiante.parroquia') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="flex items-center">
                                <input type="checkbox"  wire:model.debounce.500ms="estudiante.exonerado_religion" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Exonerado(a) de religión?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"  @if($estudiante['exonerado_religion']) disabled @endif wire:model.debounce.500ms="estudiante.bautizado" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Bautizado?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"  @if($estudiante['exonerado_religion']) disabled @endif  wire:model.debounce.500ms="estudiante.comunion" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">1era Comunión?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"  @if($estudiante['exonerado_religion']) disabled @endif  wire:model.debounce.500ms="estudiante.confirmacion" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Confirmación?</label>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input type="checkbox"  wire:model.debounce.500ms="estudiante.nee" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Necesidades Educativas Especiales (NEE) Asociadas a discapacidad?</label>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($necesidades as $necesidad)
                                <div class="flex items-center">
                                    <input type="checkbox"  value="{{ $necesidad }}" wire:model="nees" @if(!$estudiante['nee']) disabled @endif class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded"/>
                                    <label class="ml-2 block text-sm text-gray-900">{{ $necesidad }}</label>
                                </div>
                            @endforeach
                        </div>

                        <div class="pt-4">
                            <h3 class="text-lg font-medium text-gray-900">Desarrollo psicomotor (Ej: 7 meses, 1 año, etc.)</h3>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Se sentó</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.se_sento" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.se_sento') border-red-500 @enderror" />
                                @error('estudiante.se_sento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Controló sus esfinteres</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.control_esfinteres" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.control_esfinteres') border-red-500 @enderror" />
                                @error('estudiante.control_esfinteres') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Caminó</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.camino" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.camino') border-red-500 @enderror" />
                                @error('estudiante.camino') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Habló con fluidez</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.hablo_fluido" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.hablo_fluido') border-red-500 @enderror" />
                                @error('estudiante.hablo_fluido') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Se paró</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.se_paro" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.se_paro') border-red-500 @enderror" />
                                @error('estudiante.se_paro') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Habló las 1eras palabras</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.primeras_palabras" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.primeras_palabras') border-red-500 @enderror" />
                                @error('estudiante.primeras_palabras') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Levantó la cabeza</label>
                                <input @if($estudiante['finded']) disabled @endif  type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.levanto_cabeza" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.levanto_cabeza') border-red-500 @enderror" />
                                @error('estudiante.levanto_cabeza') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gateó</label>
                                <input @if($estudiante['finded']) disabled @endif type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="estudiante.gateo" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('estudiante.gateo') border-red-500 @enderror" />
                                @error('estudiante.gateo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="pt-4">
                            <h3 class="text-lg font-medium text-gray-900">Datos para la mátricula</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nivel</label>
                                <select wire:model.debounce.500ms="estudiante.nivel" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('estudiante.nivel') border-red-500 @enderror">
                                    <option value="" disabled selected>Seleccione</option>
                                    <option value="P">Primaria</option>
                                    <option value="S">Secundaria</option>
                                </select>
                                @error('estudiante.nivel') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Grado a matricular</label>
                                <select wire:model.debounce.500ms="estudiante.grado" @if(sizeof($grados) == 0) disabled @endif class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('estudiante.grado') border-red-500 @enderror">
                                    <option value="" disabled selected>Seleccione</option>
                                    @foreach($grados as $grado)
                                       <option value="{{ $grado->numero }}">{{ $grado->nombre }}</option>
                                    @endforeach
                                </select>
                                @error('estudiante.grado') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @elseif($step == 2)
                <div class="bg-white rounded-xl p-8 shadow-md space-y-6 animate-fade-in">
                    <form wire:submit.prevent="guardarPaso2" class="space-y-4">
                        <h3 class="text-lg font-medium text-gray-900">Datos del padre</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de documento</label>
                                <select wire:model.debounce.500ms="padre.tipo_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('padre.tipo_documento') border-red-500 @enderror">
                                    <option value="DNI">DNI</option>
                                    <option value="CE">CE</option>
                                    <option value="PTP">PTP</option>
                                </select>
                                @error('padre.tipo_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Numero de Documento</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="padre.numero_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.numero_documento') border-red-500 @enderror" />
                                @error('padre.numero_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha Nacimiento</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.lazy="padre.fecha_nac" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.fecha_nac') border-red-500 @enderror" id="fecha-nacimiento-padre"/>
                                @error('padre.fecha_nac') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vive?</label>
                                <select  wire:model.debounce.500ms="padre.vive" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('padre.vive') border-red-500 @enderror">
                                    <option value="true">Sí</option>
                                    <option value="false">No</option>
                                </select>
                                @error('padre.vive') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="padre.apellidos" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.apellidos') border-red-500 @enderror" />
                                @error('padre.apellidos') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="padre.nombres" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.nombres') border-red-500 @enderror" />
                                @error('padre.nombres') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado Civil</label>
                                <select wire:model.debounce.500ms="padre.estado_civil" @if(!$padre['vive']) disabled @endif class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('padre.estado_civil') border-red-500 @enderror">
                                    <option value="" selected disabled>Seleccione</option>
                                    <option value="S">Soltero(a)</option>
                                    <option value="C">Casado(a)</option>
                                    <option value="D">Divorciado(a)</option>
                                    <option value="V">Viudo(a)</option>
                                </select>
                                @error('padre.estado_civil') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Domicilio</label>
                            <input type="text" onkeyup="mayus(this);" @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.domicilio" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.domicilio') border-red-500 @enderror" />
                            @error('padre.domicilio') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.telefono_celular" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.telefono_celular') border-red-500 @enderror" />
                                @error('padre.telefono_celular') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.correo_electronico" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.correo_electronico') border-red-500 @enderror" />
                                @error('padre.correo_electronico') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nivel escolaridad</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.nivel_escolaridad" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.nivel_escolaridad') border-red-500 @enderror" />
                                @error('padre.nivel_escolaridad') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Centro del Trabajo</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.centro_trabajo" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.centro_trabajo') border-red-500 @enderror" />
                                @error('padre.centro_trabajo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cargo/Ocupación</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.cargo_ocupacion" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('padre.cargo_ocupacion') border-red-500 @enderror" />
                                @error('padre.cargo_ocupacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center">
                                <input type="checkbox"  @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.vive_estudiante" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Vive con el estudiante?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"  @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.apoderado" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Es apoderado?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"  @if(!$padre['vive']) disabled @endif wire:model.debounce.500ms="padre.responsable_economico" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Reponsable económico?</label>
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 pt-4">Datos de la madre</h3>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de documento</label>
                                <select wire:model.debounce.500ms="madre.tipo_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('madre.tipo_documento') border-red-500 @enderror">
                                    <option value="DNI">DNI</option>
                                    <option value="CE">CE</option>
                                    <option value="PTP">PTP</option>
                                </select>
                                @error('madre.tipo_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Numero de Documento</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="madre.numero_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.numero_documento') border-red-500 @enderror" />
                                @error('madre.numero_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Fecha Nacimiento</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.lazy="madre.fecha_nac" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.fecha_nac') border-red-500 @enderror" id="fecha-nacimiento-madre"/>
                                @error('madre.fecha_nac') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Vive?</label>
                                <select wire:model.debounce.500ms="madre.vive" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('madre.vive') border-red-500 @enderror">
                                    <option value="true">Sí</option>
                                    <option value="false">No</option>
                                </select>
                                @error('madre.vive') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="madre.apellidos" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.apellidos') border-red-500 @enderror" />
                                @error('madre.apellidos') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="madre.nombres" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.nombres') border-red-500 @enderror" />
                                @error('madre.nombres') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Estado Civil</label>
                                <select wire:model.debounce.500ms="madre.estado_civil" @if(!$madre['vive']) disabled @endif class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('madre.estado_civil') border-red-500 @enderror">
                                    <option value="" selected disabled>Seleccione</option>
                                    <option value="S">Soltero(a)</option>
                                    <option value="C">Casado(a)</option>
                                    <option value="D">Divorciado(a)</option>
                                    <option value="V">Viudo(a)</option>
                                </select>
                                @error('madre.estado_civil') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Domicilio</label>
                            <input type="text" onkeyup="mayus(this);" @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.domicilio" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.domicilio') border-red-500 @enderror" />
                            @error('madre.domicilio') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.telefono_celular" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.telefono_celular') border-red-500 @enderror" />
                                @error('madre.telefono_celular') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.correo_electronico" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.correo_electronico') border-red-500 @enderror" />
                                @error('madre.correo_electronico') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nivel escolaridad</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.nivel_escolaridad" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.nivel_escolaridad') border-red-500 @enderror" />
                                @error('madre.nivel_escolaridad') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Centro del Trabajo</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.centro_trabajo" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.centro_trabajo') border-red-500 @enderror" />
                                @error('madre.centro_trabajo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cargo/Ocupación</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.cargo_ocupacion" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('madre.cargo_ocupacion') border-red-500 @enderror" />
                                @error('madre.cargo_ocupacion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center">
                                <input type="checkbox"  @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.vive_estudiante" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Vive con el estudiante?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"  @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.apoderado" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Es apoderado?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"  @if(!$madre['vive']) disabled @endif wire:model.debounce.500ms="madre.responsable_economico" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Reponsable económico?</label>
                            </div>
                        </div>

                        <h3 class="text-lg font-medium text-gray-900 pt-4">Datos del apoderado distinto a padre o  madre</h3>
                        <div class="flex items-center">
                            <input type="checkbox" wire:model.debounce.500ms="apoderado.rellenar" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label class="ml-2 block text-sm text-gray-900">Desea llenar los campos del apoderado?</label>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de documento</label>
                                <select @if(!$apoderado['rellenar']) disabled @endif wire:model.debounce.500ms="apoderado.tipo_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('apoderado.tipo_documento') border-red-500 @enderror">
                                    <option value="DNI">DNI</option>
                                    <option value="CE">CE</option>
                                    <option value="PTP">PTP</option>
                                </select>
                                @error('apoderado.tipo_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Numero de Documento</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$apoderado['rellenar']) disabled @endif wire:model.debounce.500ms="apoderado.numero_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.numero_documento') border-red-500 @enderror" />
                                @error('apoderado.numero_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Parentesco</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$apoderado['rellenar']) disabled @endif wire:model.debounce.500ms="apoderado.parentesco" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.parentesco') border-red-500 @enderror" />
                                @error('apoderado.parentesco') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Apellidos</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$apoderado['rellenar']) disabled @endif wire:model.debounce.500ms="apoderado.apellidos" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.apellidos') border-red-500 @enderror" />
                                @error('apoderado.apellidos') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$apoderado['rellenar']) disabled @endif wire:model.debounce.500ms="apoderado.nombres" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.nombres') border-red-500 @enderror" />
                                @error('apoderado.nombres') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" onkeyup="mayus(this);"  @if(!$apoderado['rellenar']) disabled @endif wire:model.debounce.500ms="apoderado.telefono_celular" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.telefono_celular') border-red-500 @enderror" />
                                @error('apoderado.telefono_celular') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                                <input type="text" onkeyup="mayus(this);"  @if(!$apoderado['rellenar']) disabled @endif wire:model.debounce.500ms="apoderado.correo_electronico" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.correo_electronico') border-red-500 @enderror" />
                                @error('apoderado.correo_electronico') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nivel escolaridad</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$apoderado['rellenar']) disabled @endif  wire:model.debounce.500ms="apoderado.grado_escolaridad" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.grado_escolaridad') border-red-500 @enderror" />
                                @error('apoderado.grado_escolaridad') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Grado Obtenido</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$apoderado['rellenar']) disabled @endif  wire:model.debounce.500ms="apoderado.grado_obtenido" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.grado_obtenido') border-red-500 @enderror" />
                                @error('apoderado.grado_obtenido') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Centro del Trabajo</label>
                                <input type="text" onkeyup="mayus(this);" @if(!$apoderado['rellenar']) disabled @endif  wire:model.debounce.500ms="apoderado.centro_trabajo" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('apoderado.centro_trabajo') border-red-500 @enderror" />
                                @error('apoderado.centro_trabajo') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="flex items-center">
                                <input type="checkbox"   @if(!$apoderado['rellenar']) disabled @endif  wire:model.debounce.500ms="apoderado.vive_estudiante" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Vive con el estudiante?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"   @if(!$apoderado['rellenar']) disabled @endif  wire:model.debounce.500ms="apoderado.apoderado" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Es apoderado?</label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox"   @if(!$apoderado['rellenar']) disabled @endif  wire:model.debounce.500ms="apoderado.responsable_economico" class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                                <label class="ml-2 block text-sm text-gray-900">Reponsable económico?</label>
                            </div>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="button" wire:click="$emit('goToStep', 1)" class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @elseif($step == 3)
                <div class="bg-white rounded-xl p-8 shadow-md space-y-6 animate-fade-in">
                    <form wire:submit.prevent="guardarPaso3" class="space-y-4">
                        <p class="text-gray-600">Llené los datos del formulario y en la parte inferior podrá observar la declaración jurada.</p>
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de documento</label>
                                <select  wire:model.debounce.500ms="salud.tipo_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('salud.tipo_documento') border-red-500 @enderror">
                                    <option value="DNI">DNI</option>
                                    <option value="CE">CE</option>
                                    <option value="PTP">PTP</option>
                                </select>
                                @error('salud.tipo_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Numero de Documento</label>
                                <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="salud.numero_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('salud.numero_documento') border-red-500 @enderror" />
                                @error('salud.numero_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                <input type="text" onkeyup="mayus(this);" @if($salud['block'])  disabled @endif   wire:model.debounce.500ms="salud.nombres" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('salud.nombres') border-red-500 @enderror" />
                                @error('salud.nombres') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Parentesco</label>
                                <input type="text" onkeyup="mayus(this);"   wire:model.debounce.500ms="salud.parentesco" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('salud.parentesco') border-red-500 @enderror" />
                                @error('salud.parentesco') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nombre establecimiento (Caso de Emergencia)</label>
                                <input type="text" onkeyup="mayus(this);"   wire:model.debounce.500ms="salud.nombre_establecimiento" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('salud.nombre_establecimiento') border-red-500 @enderror" />
                                @error('salud.nombre_establecimiento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Dirección del Establecimiento</label>
                                <input type="text" onkeyup="mayus(this);"   wire:model.debounce.500ms="salud.direccion" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('salud.direccion') border-red-500 @enderror" />
                                @error('salud.direccion') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Referencia</label>
                                <input type="text" onkeyup="mayus(this);"   wire:model.debounce.500ms="salud.referencia" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('salud.referencia') border-red-500 @enderror" />
                                @error('salud.referencia') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tipo de seguro</label>
                                <select  wire:model.debounce.500ms="salud.tipo_seguro" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('salud.tipo_seguro') border-red-500 @enderror">
                                    <option value="" selected disabled>Seleccione</option>
                                    <option value="SIS">SIS</option>
                                    <option value="ESSALUD">ESSALUD</option>
                                    <option value="EPS">EPS</option>
                                    <option value="OTRO">OTRO</option>
                                </select>
                                @error('salud.tipo_seguro') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Especificar otro</label>
                                <input type="text" onkeyup="mayus(this);"  @if($salud['tipo_seguro'] != 'OTRO') disabled @endif wire:model.debounce.500ms="salud.otro_seguro" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('salud.otro_seguro') border-red-500 @enderror" />
                                @error('salud.otro_seguro') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <h3 class="text-center font-bold text-gray-800">DECLARACIÓN JURADA DEL SEGURO DE SALUD DEL ESTUDIANTE</h3>
                            <div class="prose max-w-none mt-4 text-sm text-gray-600">
                                <p>
                                    Yo, <b>{{ $salud['nombres'] }}</b>, con documento de identidad N° <b>{{ $salud['numero_documento'] }}</b>,
                                    en representación de mi hijo(a) con nombre <b>{{ $estudiante['apellido_paterno'].' '.$estudiante['apellido_materno'] }}, {{ $estudiante['nombres'] }}</b>
                                    con documento de identidad N° <b>{{ $estudiante['numero_documento'] }}</b>,
                                    declaro bajo juramento que, autorizo e informo a la Instituciòn Educativa Privada (En adelante el “COLEGIO”),
                                    con Ruc 10254934475 y domicilio en Jr. Cailloma Nº 574 Cercado de Lima, de lo siguiente:
                                </p>
                                <ol class="list-decimal list-inside space-y-2">
                                    <li>Conozco, que el COLEGIO no tiene convenio con ninguna clínica, hospital u otros análogos para la contratación de los seguros de salud de mi hijo(a), por lo que, no he sido informado de ningún programa de protección de salud.</li>
                                    <li>
                                        Informo, que soy el único responsable de la protección de salud de mi hijo(a), por lo que, pongo de conocimiento del COLEGIO, el seguro de protección de salud y el establecimiento donde deberá ser derivado mi hijo(a) en caso de emergencia:<br>
                                        <b>Nombre del establecimiento: </b> {{ $salud['nombre_establecimiento'] }}<br>
                                        <b>Dirección: </b> {{ $salud['direccion'] }}.<br>
                                        <b>Referencia: </b> {{ $salud['referencia'] }}.<br>
                                        <b>Tipo de Seguro: </b> {{ $salud['tipo_seguro'] != 'OTRO' ? $salud['tipo_seguro'] : $salud['otro_seguro'] }}.<br>
                                    </li>
                                    <li>Acepto, que soy el único responsable en mantener activo el seguro de protección de salud de mi hijo(a), por lo que, los gastos derivados en caso de desprotección ante una emergencia son de mi responsabilidad.</li>
                                    <li>Conozco, que en caso de emergencia el COLEGIO activará su protocolo de contingencias administrativas, referido al procedimiento de emergencia por accidentes.</li>
                                </ol>
                            </div>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="button" wire:click="$emit('goToStep', 2)" class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition">
                                Siguiente <i class="fas fa-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @elseif($step == 4)
                <div class="bg-white rounded-xl p-8 shadow-md space-y-6 animate-fade-in">
                    <form wire:submit.prevent="guardarPaso4" class="space-y-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Datos del estudiante</h3>
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div><span class="font-semibold">Tipo doc.:</span> <p>{{ $estudiante['tipo_documento'] }}</p></div>
                                <div><span class="font-semibold">Numero Doc.:</span> <p>{{ $estudiante['numero_documento'] }}</p></div>
                                <div><span class="font-semibold">Apellidos:</span> <p>{{ $estudiante['apellido_paterno'] }} {{ $estudiante['apellido_materno'] }}</p></div>
                                <div><span class="font-semibold">Nombres:</span> <p>{{ $estudiante['nombres'] }}</p></div>
                                <div><span class="font-semibold">Nivel:</span> <p>{{ $estudiante['nivel'] == 'P' ? 'Primaria' : 'Secundaria' }}</p></div>
                                <div><span class="font-semibold">Grado:</span> <p>{{ $estudiante['grado'] }}°</p></div>
                                <div><span class="font-semibold">Exonerado Religión:</span> <p>{{ $estudiante['exonerado_religion'] ? 'Si' : 'No' }}</p></div>
                                <div><span class="font-semibold">Fecha de Nacimiento:</span> <p>{{ $estudiante['fecha_nac']  }}</p></div>
                                <div><span class="font-semibold">Teléfono Celular:</span> <p>{{ $estudiante['telefono_celular']  }}</p></div>
                                <div><span class="font-semibold">Teléfono de Emergencia:</span> <p>{{ $estudiante['telefono_emergencia']  }}</p></div>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-medium text-gray-900">Datos del padre</h3>
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div><span class="font-semibold">Tipo doc.:</span> <p>{{ $padre['tipo_documento'] }}</p></div>
                                <div><span class="font-semibold">Numero Doc.:</span> <p>{{ $padre['numero_documento'] }}</p></div>
                                <div><span class="font-semibold">Apellidos:</span> <p>{{ $padre['apellidos'] }}</p></div>
                                <div><span class="font-semibold">Nombres:</span> <p>{{ $padre['nombres'] }}</p></div>
                                <div><span class="font-semibold">Teléfono Celular:</span> <p>{{ $padre['telefono_celular'] }}</p></div>
                                <div><span class="font-semibold">Correo Electrónico:</span> <p>{{ $padre['correo_electronico'] }}</p></div>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-medium text-gray-900">Datos de la madre</h3>
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                <div><span class="font-semibold">Tipo doc.:</span> <p>{{ $madre['tipo_documento'] }}</p></div>
                                <div><span class="font-semibold">Numero Doc.:</span> <p>{{ $madre['numero_documento'] }}</p></div>
                                <div><span class="font-semibold">Apellidos:</span> <p>{{ $madre['apellidos'] }}</p></div>
                                <div><span class="font-semibold">Nombres:</span> <p>{{ $madre['nombres'] }}</p></div>
                                <div><span class="font-semibold">Teléfono Celular:</span> <p>{{ $madre['telefono_celular'] }}</p></div>
                                <div><span class="font-semibold">Correo Electrónico:</span> <p>{{ $madre['correo_electronico'] }}</p></div>
                            </div>
                        </div>
                        @if($apoderado['rellenar'])
                            <div class="border-t pt-4">
                                <h3 class="text-lg font-medium text-gray-900">Datos del apoderado</h3>
                                <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div><span class="font-semibold">Tipo doc.:</span> <p>{{ $apoderado['tipo_documento'] }}</p></div>
                                    <div><span class="font-semibold">Numero Doc.:</span> <p>{{ $apoderado['numero_documento'] }}</p></div>
                                    <div><span class="font-semibold">Apellidos:</span> <p>{{ $apoderado['apellidos'] }}</p></div>
                                    <div><span class="font-semibold">Nombres:</span> <p>{{ $apoderado['nombres'] }}</p></div>
                                    <div><span class="font-semibold">Teléfono Celular:</span> <p>{{ $apoderado['telefono_celular'] }}</p></div>
                                    <div><span class="font-semibold">Correo Electrónico:</span> <p>{{ $apoderado['correo_electronico'] }}</p></div>
                                    <div><span class="font-semibold">Parentesco:</span> <p>{{ $apoderado['parentesco'] }}</p></div>
                                </div>
                            </div>
                        @endif
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-medium text-gray-900">Datos de seguro de salud</h3>
                            <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                                <div><span class="font-semibold">Establecimiento de Salud:</span> <p>{{ $salud['nombre_establecimiento'] }}</p></div>
                                <div><span class="font-semibold">Tipo de Seguro:</span> <p>{{ $salud['tipo_seguro'] != 'OTRO' ? $salud['tipo_seguro'] : $salud['otro_seguro'] }}</p></div>
                            </div>
                        </div>
                        <div class="border-t pt-4">
                            <h3 class="text-lg font-medium text-gray-900">Datos del responsable por el pago de matricula y pensiones</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipo de documento</label>
                                    <select  wire:model.debounce.500ms="dj.tipo_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm @error('dj.tipo_documento') border-red-500 @enderror">
                                        <option value="DNI">DNI</option>
                                        <option value="CE">CE</option>
                                        <option value="PTP">PTP</option>
                                    </select>
                                    @error('dj.tipo_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Numero de Documento</label>
                                    <input type="text" onkeyup="mayus(this);" wire:model.debounce.500ms="dj.numero_documento" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('dj.numero_documento') border-red-500 @enderror" />
                                    @error('dj.numero_documento') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nombres</label>
                                    <input type="text" onkeyup="mayus(this);" @if($dj['block'])  disabled @endif   wire:model.debounce.500ms="dj.nombres" class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm @error('dj.nombres') border-red-500 @enderror" />
                                    @error('dj.nombres') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="mt-4 text-sm text-gray-600">
                                Yo, <strong>{{ $dj['nombres'] }}</strong> con documento <strong>{{ $dj['tipo_documento'] }} {{ $dj['numero_documento'] }}</strong> declaro que soy el responsable del pago de la matricula y pensiones de enseñanza.
                            </div>
                        </div>

                        <div class="flex justify-between pt-4">
                            <button type="button" wire:click="$emit('goToStep', 3)" class="px-5 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">
                                <i class="fas fa-arrow-left mr-2"></i> Anterior
                            </button>
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition">
                                Matricular <i class="fas fa-check-circle ml-2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            @elseif($step == 5)
                <div class="bg-white rounded-xl p-8 shadow-md text-center space-y-6 animate-fade-in">
                    <div class="w-20 h-20 bg-green-100 text-green-600 flex items-center justify-center rounded-full mx-auto">
                        <i class="fas fa-check-double text-4xl"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">¡Matrícula Exitosa!</h2>
                    <p class="text-gray-600">Su matrícula ha sido recibida con éxito, recuerde descargar su ficha.</p>
                    <p class="text-lg font-semibold text-gray-800">
                        Código de Matrícula: <span class="font-bold text-primary">{{ $matricula->codigo }}</span>
                    </p>
                    <div class="flex justify-center space-x-4">
                        <button wire:click="generarFicha" class="px-6 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition">
                            <i class="fas fa-file-pdf mr-2"></i> Descargar Ficha
                        </button>
                        <a href="{{ route('registrar.pago') }}" class="px-6 py-3 bg-gray-200 text-gray-800 rounded-lg font-semibold hover:bg-gray-300 transition">
                            <i class="fas fa-money-bill mr-2"></i> Registrar pago
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="bg-white rounded-xl p-8 shadow-md text-center space-y-6">
            <img src="{{ asset('images/no-matricula.jpg') }}" class="mx-auto w-1/2"/>
            <h2 class="text-xl font-bold text-gray-800">Matrícula Cerrada</h2>
            <p class="text-gray-500">Lo sentimos, nuestro proceso de matrícula para el año en curso está cerrado.</p>
        </div>
    @endif
</main>

@push('js')
    <script>
        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
        document.addEventListener('livewire:load', function () {
            new Pikaday({
                field: document.getElementById('fecha-nacimiento'),
                format: 'DD/MM/YYYY',
                yearRange: [1990,2018],
                i18n: {
                    previousMonth : 'Mes Anterior',
                    nextMonth     : 'Siguiente Mes',
                    months        : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                    weekdays      : ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
                    weekdaysShort : ['Dom','Lun','Mar','Mi','Ju','Vi','Sa']
                },
                toString(date, format) {
                    var day = date.getDate();
                    day = day < 10 ?`0${day}` : day;

                    var month = date.getMonth() + 1;
                    month = month < 10 ?`0${month}` : month;

                    const year = date.getFullYear();
                    return `${day}/${month}/${year}`;
                },
            });

            Livewire.on('to:top', () => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });

            Livewire.on('paso:padres', () => {
                new Pikaday({
                    field: document.getElementById('fecha-nacimiento-padre'),
                    format: 'DD/MM/YYYY',
                    yearRange: [1920,2018],
                    i18n: {
                        previousMonth : 'Mes Anterior',
                        nextMonth     : 'Siguiente Mes',
                        months        : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                        weekdays      : ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
                        weekdaysShort : ['Dom','Lun','Mar','Mi','Ju','Vi','Sa']
                    },
                    toString(date, format) {
                        var day = date.getDate();
                        day = day < 10 ?`0${day}` : day;

                        var month = date.getMonth() + 1;
                        month = month < 10 ?`0${month}` : month;

                        const year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    },
                });

                new Pikaday({
                    field: document.getElementById('fecha-nacimiento-madre'),
                    format: 'DD/MM/YYYY',
                    yearRange: [1920,2015],
                    i18n: {
                        previousMonth : 'Mes Anterior',
                        nextMonth     : 'Siguiente Mes',
                        months        : ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                        weekdays      : ['Domingo','Lunes','Martes','Miercoles','Jueves','Viernes','Sabado'],
                        weekdaysShort : ['Dom','Lun','Mar','Mi','Ju','Vi','Sa']
                    },
                    toString(date, format) {
                        var day = date.getDate();
                        day = day < 10 ?`0${day}` : day;

                        var month = date.getMonth() + 1;
                        month = month < 10 ?`0${month}` : month;

                        const year = date.getFullYear();
                        return `${day}/${month}/${year}`;
                    },
                });
            });
        });
    </script>
@endpush

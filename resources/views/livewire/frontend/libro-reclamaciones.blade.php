<div>
    <!-- Hero Section -->
    <div class="text-center mb-12">
        <div class="max-w-4xl mx-auto">
            <div
                class="w-20 h-20 bg-gradient-to-r from-primary to-red-700 text-white flex items-center justify-center rounded-full mx-auto mb-6 shadow-lg">
                <i class="fas fa-book text-3xl"></i>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                Libro de Reclamaciones
            </h1>
            <p class="text-gray-600 text-lg leading-relaxed mb-6">
                Su opinión es importante para nosotros. Complete el siguiente formulario para registrar su queja o
                reclamo de manera segura y confidencial.
            </p>
            <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 px-6 py-4 rounded-r-lg inline-block">
                <div class="flex items-start">
                    <i class="fas fa-info-circle text-blue-500 mr-3 mt-1"></i>
                    <div>
                        <p class="font-semibold">Información Legal</p>
                        <p class="text-sm">Conforme al Decreto Supremo N° 011-2011-PCM, esta institución cuenta
                            con un Libro de Reclamaciones virtual a su disposición.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="max-w-4xl mx-auto mb-8">
        <div class="flex items-center justify-center space-x-4 mb-8">
            <!-- Step 1 -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm bg-gradient-to-r from-primary to-red-700 text-white shadow-md">
                    1
                </div>
                <span class="mt-2 text-xs font-semibold text-primary">Tipo</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200">
                <div class="h-full bg-gradient-to-r from-primary to-red-700 w-full"></div>
            </div>

            <!-- Step 2 -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm bg-gradient-to-r from-primary to-red-700 text-white shadow-md">
                    2
                </div>
                <span class="mt-2 text-xs font-semibold text-primary">Datos</span>
            </div>
            <div class="flex-1 h-0.5 bg-gray-200">
                <div class="h-full bg-gradient-to-r from-primary to-red-700 w-full"></div>
            </div>

            <!-- Step 3 -->
            <div class="flex flex-col items-center text-center">
                <div
                    class="w-10 h-10 flex items-center justify-center rounded-full font-bold text-sm bg-gradient-to-r from-primary to-red-700 text-white shadow-md">
                    3
                </div>
                <span class="mt-2 text-xs font-semibold text-primary">Detalle</span>
            </div>
        </div>
    </div>

    <!-- Información Institucional Card -->
    {{-- <div class="max-w-6xl mx-auto mb-8">
        <div class="bg-white rounded-xl p-6 shadow-md border border-gray-100">
            <div class="flex items-center mb-4">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-primary to-red-700 text-white flex items-center justify-center rounded-lg mr-3">
                    <i class="fas fa-building text-sm"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Información Institucional</h3>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm font-semibold text-gray-600 mb-1">Razón Social</p>
                    <p class="text-gray-800 font-medium">Institución Educativa Privada Divino Salvador</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm font-semibold text-gray-600 mb-1">RUC</p>
                    <p class="text-gray-800 font-medium">-</p>
                </div>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm font-semibold text-gray-600 mb-1">Fecha de Registro</p>
                    <p class="text-gray-800 font-medium">{{ date('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Main Form Container -->
    <div class="max-w-6xl mx-auto">
        <form wire:submit.prevent="submit" class="space-y-8">

            <!-- Identificación del Reclamo -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 animate-fade-in">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-700 text-white flex items-center justify-center rounded-lg mr-3">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Identificación del Reclamo</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Tipo de Solicitud <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" wire:model.defer="form.tipoReclamo" value="reclamo"
                                    class="sr-only peer">
                                <div
                                    class="p-6 border-2 border-gray-200 rounded-xl text-center peer-checked:border-red-500 peer-checked:bg-red-50 hover:border-red-300 transition-all duration-300">
                                    <i class="fas fa-exclamation-triangle text-2xl text-red-500 mb-3"></i>
                                    <p class="font-semibold text-gray-800">Reclamo</p>
                                    <p class="text-xs text-gray-600 mt-1">Disconformidad con servicios</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" wire:model.defer="form.tipoReclamo" value="queja"
                                    class="sr-only peer">
                                <div
                                    class="p-6 border-2 border-gray-200 rounded-xl text-center peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300 transition-all duration-300">
                                    <i class="fas fa-comment-alt text-2xl text-orange-500 mb-3"></i>
                                    <p class="font-semibold text-gray-800">Queja</p>
                                    <p class="text-xs text-gray-600 mt-1">Malestar o descontento</p>
                                </div>
                            </label>
                        </div>
                        @error('form.tipoReclamo')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            Fecha del Incidente <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="date" wire:model.defer="form.fechaIncidente"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.fechaIncidente') border-red-500 @enderror">
                            <i
                                class="fas fa-calendar-alt absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        @error('form.fechaIncidente')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Identificación del Consumidor -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 animate-fade-in">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-blue-500 to-blue-700 text-white flex items-center justify-center rounded-lg mr-3">
                        <i class="fas fa-user"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Identificación del Consumidor</h2>
                </div>

                <div class="bg-amber-50 border-l-4 border-amber-400 text-amber-800 px-6 py-4 rounded-r-lg mb-8">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        <p class="text-sm">Todos los campos marcados con <span class="text-red-500 font-bold">*</span>
                            son obligatorios.</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-1"></i>Nombre <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="form.nombre"
                                placeholder="Ingrese su nombre completo"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.nombre') border-red-500 @enderror">
                            @error('form.nombre')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-user mr-1"></i>Apellido <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="form.apellido"
                                placeholder="Ingrese su apellido completo"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.apellido') border-red-500 @enderror">
                            @error('form.apellido')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-id-card mr-1"></i>Tipo de Documento <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.defer="form.tipoDocumento"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.tipoDocumento') border-red-500 @enderror">
                                <option value="">Seleccionar tipo...</option>
                                <option value="dni">DNI - Documento Nacional de Identidad</option>
                                <option value="ce">CE - Carnet de Extranjería</option>
                                <option value="pasaporte">Pasaporte</option>
                                <option value="ruc">RUC - Registro Único de Contribuyente</option>
                            </select>
                            @error('form.tipoDocumento')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-hashtag mr-1"></i>Número de Documento <span
                                    class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="form.numeroDocumento"
                                placeholder="Número de documento"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.numeroDocumento') border-red-500 @enderror">
                            @error('form.numeroDocumento')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i>Dirección <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model.defer="form.direccion" placeholder="Dirección completa"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.direccion') border-red-500 @enderror">
                        @error('form.direccion')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-map mr-1"></i>Departamento <span class="text-red-500">*</span>
                            </label>
                            <select wire:model.defer="form.departamento"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.departamento') border-red-500 @enderror">
                                <option value="">Seleccionar...</option>
                                <option value="lima">Lima</option>
                            </select>
                            @error('form.departamento')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-city mr-1"></i>Provincia <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="form.provincia" placeholder="Provincia"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.provincia') border-red-500 @enderror">
                            @error('form.provincia')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-building mr-1"></i>Distrito <span class="text-red-500">*</span>
                            </label>
                            <input type="text" wire:model.defer="form.distrito" placeholder="Distrito"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.distrito') border-red-500 @enderror">
                            @error('form.distrito')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-phone mr-1"></i>Teléfono
                            </label>
                            <input type="tel" wire:model.defer="form.telefono" placeholder="Número de teléfono"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.telefono') border-red-500 @enderror">
                            @error('form.telefono')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-envelope mr-1"></i>Correo Electrónico <span
                                    class="text-red-500">*</span>
                            </label>
                            <input type="email" wire:model.defer="form.email" placeholder="correo@ejemplo.com"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.email') border-red-500 @enderror">
                            @error('form.email')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Identificación del Padre o Apoderado -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 animate-fade-in">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-green-500 to-green-700 text-white flex items-center justify-center rounded-lg mr-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Identificación del Padre o Apoderado</h2>
                </div>

                <div class="mb-6">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" wire:model.defer="form.esMenorEdad"
                            class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                        <span class="ml-3 text-sm font-medium text-gray-700">
                            <i class="fas fa-child mr-1"></i>El reclamante es menor de edad
                        </span>
                    </label>
                </div>

                @if ($form['esMenorEdad'] ?? false)
                    <div class="space-y-6 border-t pt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user-tie mr-1"></i>Nombre del Apoderado
                                </label>
                                <input type="text" wire:model.defer="form.nombreApoderado"
                                    placeholder="Nombre completo del apoderado"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.nombreApoderado') border-red-500 @enderror">
                                @error('form.nombreApoderado')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-user-tie mr-1"></i>Apellido del Apoderado
                                </label>
                                <input type="text" wire:model.defer="form.apellidoApoderado"
                                    placeholder="Apellido completo del apoderado"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.apellidoApoderado') border-red-500 @enderror">
                                @error('form.apellidoApoderado')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-id-card mr-1"></i>DNI del Apoderado
                                </label>
                                <input type="text" wire:model.defer="form.dniApoderado"
                                    placeholder="DNI del apoderado"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.dniApoderado') border-red-500 @enderror">
                                @error('form.dniApoderado')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-phone mr-1"></i>Teléfono del Apoderado
                                </label>
                                <input type="tel" wire:model.defer="form.telefonoApoderado"
                                    placeholder="Teléfono del apoderado"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.telefonoApoderado') border-red-500 @enderror">
                                @error('form.telefonoApoderado')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Identificación del Bien Contratado -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 animate-fade-in">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-purple-500 to-purple-700 text-white flex items-center justify-center rounded-lg mr-3">
                        <i class="fas fa-tag"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Identificación del Bien Contratado</h2>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-list mr-1"></i>Tipo de Bien o Servicio <span
                                class="text-red-500">*</span>
                        </label>
                        <select wire:model.defer="form.tipoBien"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.tipoBien') border-red-500 @enderror">
                            <option value="">Seleccionar tipo...</option>
                            <option value="servicio-educativo">🎓 Servicio Educativo</option>
                            <option value="matricula">📋 Matrícula</option>
                            <option value="pension">💰 Pensión Escolar</option>
                            <option value="material-educativo">📚 Material Educativo</option>
                            <option value="otro">📝 Otro</option>
                        </select>
                        @error('form.tipoBien')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-1"></i>Descripción <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model.defer="form.descripcionBien"
                            placeholder="Describa detalladamente el producto o servicio objeto del reclamo" rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.descripcionBien') border-red-500 @enderror resize-none"></textarea>
                        @error('form.descripcionBien')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-dollar-sign mr-1"></i>Monto Reclamado
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">S/.</span>
                                <input type="number" wire:model.defer="form.montoReclamado" placeholder="0.00"
                                    step="0.01" min="0"
                                    class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.montoReclamado') border-red-500 @enderror">
                            </div>
                            @error('form.montoReclamado')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class="fas fa-coins mr-1"></i>Moneda
                            </label>
                            <select wire:model.defer="form.moneda"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.moneda') border-red-500 @enderror">
                                <option value="soles">🇵🇪 Soles (S/)</option>
                                <option value="dolares">🇺🇸 Dólares (US$)</option>
                            </select>
                            @error('form.moneda')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detalle de la Reclamación -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 animate-fade-in">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-red-500 to-red-700 text-white flex items-center justify-center rounded-lg mr-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Detalle de la Reclamación y Pedido</h2>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-align-left mr-1"></i>Detalle del Reclamo <span
                                class="text-red-500">*</span>
                        </label>
                        <textarea wire:model.defer="form.detalleReclamo"
                            placeholder="Describa de manera clara y detallada los hechos que motivan su reclamo. Incluya fechas, personas involucradas y cualquier información relevante."
                            rows="6"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.detalleReclamo') border-red-500 @enderror resize-none"></textarea>
                        @error('form.detalleReclamo')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-bullhorn mr-1"></i>Pedido o Solicitud <span class="text-red-500">*</span>
                        </label>
                        <textarea wire:model.defer="form.pedido"
                            placeholder="Indique específicamente qué solicita que se haga para resolver su reclamo. Sea claro y concreto en su petición."
                            rows="4"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.pedido') border-red-500 @enderror resize-none"></textarea>
                        @error('form.pedido')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Observaciones y Acciones Adoptadas -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 animate-fade-in">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-yellow-500 to-yellow-700 text-white flex items-center justify-center rounded-lg mr-3">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Información Adicional</h2>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-sticky-note mr-1"></i>Observaciones
                        </label>
                        <textarea wire:model.defer="form.observaciones"
                            placeholder="Información adicional que considere relevante para su reclamo (opcional)" rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary/40 focus:border-primary @error('form.observaciones') border-red-500 @enderror resize-none"></textarea>
                        @error('form.observaciones')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-cogs mr-1"></i>Acciones Adoptadas por el Proveedor
                        </label>
                        <textarea wire:model.defer="form.acciones"
                            placeholder="Este campo será completado por la institución una vez procesado el reclamo" readonly rows="3"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 cursor-not-allowed text-gray-600"></textarea>
                    </div>
                </div>
            </div>

            <!-- Términos y Condiciones -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100 animate-fade-in">
                <div class="flex items-center mb-6">
                    <div
                        class="w-10 h-10 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white flex items-center justify-center rounded-lg mr-3">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Términos y Condiciones</h2>
                </div>

                <div class="space-y-6">
                    <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-800 px-6 py-4 rounded-r-lg">
                        <div class="flex items-start">
                            <i class="fas fa-shield-alt text-blue-500 mr-3 mt-1 flex-shrink-0"></i>
                            <div>
                                <h4 class="font-semibold mb-2">Política de Privacidad y Protección de Datos</h4>
                                <p class="text-sm leading-relaxed">
                                    Los datos proporcionados serán tratados conforme a la Ley N° 29733 - Ley de
                                    Protección de Datos Personales
                                    y su Reglamento. La información será utilizada únicamente para dar trámite a su
                                    reclamo y contactarlo
                                    para brindarle una respuesta. Sus datos no serán compartidos con terceros sin su
                                    consentimiento expreso.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-green-50 border-l-4 border-green-400 text-green-800 px-6 py-4 rounded-r-lg">
                        <div class="flex items-start">
                            <i class="fas fa-clock text-green-500 mr-3 mt-1 flex-shrink-0"></i>
                            <div>
                                <h4 class="font-semibold mb-2">Tiempo de Respuesta</h4>
                                <p class="text-sm leading-relaxed">
                                    De acuerdo a la normativa vigente, su reclamo será atendido en un plazo no mayor a
                                    30 días calendario
                                    desde su recepción. Recibirá una respuesta por escrito a través del correo
                                    electrónico proporcionado.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <label class="flex items-start cursor-pointer">
                            <input type="checkbox" wire:model.defer="form.aceptoTerminos"
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded mt-1 flex-shrink-0">
                            <span class="ml-3 text-sm text-gray-700 leading-relaxed">
                                <strong>Declaro que:</strong> Acepto la política de privacidad y tratamiento de datos
                                personales.
                                Confirmo que la información proporcionada es veraz y completa, y autorizo a la
                                institución
                                a contactarme para dar seguimiento a mi reclamo. <span class="text-red-500">*</span>
                            </span>
                        </label>
                        @error('form.aceptoTerminos')
                            <p class="text-red-600 text-sm ml-7">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="bg-white rounded-xl p-8 shadow-md border border-gray-100">
                <div class="flex flex-col sm:flex-row gap-4 justify-end">
                    <!-- Botón limpiar, no depende del envío -->
                    <button type="button" wire:loading.remove wire:target="submit" wire:click="limpiarFormulario"
                        class="flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 bg-white rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300">
                        <i class="fas fa-refresh mr-2"></i>
                        Limpiar Formulario
                    </button>

                    <!-- Botón enviar: se oculta mientras se procesa -->
                    <button type="submit" wire:loading.remove wire:target="submit"
                        class="flex items-center justify-center px-8 py-3 bg-gradient-to-r from-primary to-red-700 text-white rounded-lg font-semibold hover:scale-105 transition-all duration-300 shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Enviar Reclamación
                    </button>

                    <!-- Loader: solo se muestra mientras se procesa -->
                    <div wire:loading.flex wire:target='submit' class="flex items-center justify-center px-8 py-3"
                        style="display: none;">
                        <div
                            class="w-6 h-6 border-2 border-primary border-t-transparent rounded-full animate-spin mr-3">
                        </div>
                        <span class="text-primary font-semibold">Enviando...</span>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>


@push('css')
    <style>
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Smooth focus transitions */
        input:focus,
        select:focus,
        textarea:focus {
            transition: all 0.2s ease-in-out;
        }

        /* Custom scrollbar for textareas */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #a0aec0;
        }

        /* Hover effects for form sections */
        .bg-white.rounded-xl:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
        }
    </style>
@endpush

<div class="content-dashboard" x-data="{
    activeTab: 'estudiante',
    copiar(text) {
        Copy(text);
        Livewire.emit('swal:alert', { icon: 'success', title: 'Copiado!', timeout: 1000 });
    }
}">

    {{-- Header --}}
    <div class="content-dashboard-header">
        <div>
            <i class="fas fa-graduation-cap"></i> Detalle Matrícula: {{ $matricula->codigo }}
            @if ($matricula->numero_matricula != null)
                <span class="has-text-lighter">#{{ $matricula->numero_matricula }}</span>
            @endif
        </div>
        <div>{!! $matricula->status !!}</div>
    </div>

    {{-- Quick Info Card --}}
    <div class="mb-4 quick-info-card">
        <div class="columns is-vcentered">
            <div class="column is-narrow has-text-centered">
                <img src="{{ $matricula->alumno->foto }}" class="student-avatar">
            </div>
            <div class="column">
                <div class="student-name">{{ $matricula->alumno->nombre_completo }}</div>
                <div class="info-badges">
                    <span class="mr-2 tag">
                        <i class="mr-1 fas fa-id-card"></i>
                        {{ $matricula->alumno->tipo_documento }}: {{ $matricula->alumno->numero_documento }}
                    </span>
                    <span class="mr-2 tag">
                        <i class="mr-1 fas fa-birthday-cake"></i>
                        {{ $matricula->alumno->edad }} años
                    </span>
                    <span class="tag">
                        <i class="mr-1 fas fa-school"></i>
                        {{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA' }} - {{ $matricula->grado }}°
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs Navigation --}}
    <div class="tabs-nav-improved">
        <button @click="activeTab = 'estudiante'" class="tab-btn" :class="{ 'active': activeTab === 'estudiante' }">
            <i class="fas fa-user-graduate"></i>
            <span>Estudiante</span>
        </button>
        <button @click="activeTab = 'padres'" class="tab-btn" :class="{ 'active': activeTab === 'padres' }">
            <i class="fas fa-users"></i>
            <span>Padres</span>
        </button>
        <button @click="activeTab = 'apoderados'" class="tab-btn" :class="{ 'active': activeTab === 'apoderados' }">
            <i class="fas fa-user-tie"></i>
            <span>Apoderados</span>
        </button>
        <button @click="activeTab = 'responsable_economico'" class="tab-btn"
            :class="{ 'active': activeTab === 'responsable_economico' }">
            <i class="fas fa-wallet"></i>
            <span>Resp. Económico</span>
        </button>
        <button @click="activeTab = 'pagos'" class="tab-btn" :class="{ 'active': activeTab === 'pagos' }">
            <i class="fas fa-money-bill-wave"></i>
            <span>Pagos</span>
        </button>
        <button @click="activeTab = 'horario'" class="tab-btn" :class="{ 'active': activeTab === 'horario' }">
            <i class="fas fa-clock"></i>
            <span>Horario</span>
        </button>
        <button @click="activeTab = 'usuarios'" class="tab-btn" :class="{ 'active': activeTab === 'usuarios' }">
            <i class="fas fa-user-shield"></i>
            <span>Usuarios</span>
        </button>
    </div>

    {{-- Tab Content --}}
    <div class="tab-content-wrapper">
        {{-- Tab: Estudiante --}}
        <div x-show="activeTab === 'estudiante'">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-user-graduate"></i>
                    <span>Información del Estudiante</span>
                </div>
                @if (!$editMode)
                    <button wire:click="toggleEditMode" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                @else
                    <button wire:click="cancelEdit" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                @endif
            </div>

            @if (!$editMode)
                {{-- Vista de solo lectura --}}
                <div class="info-section">
                    <div class="info-section-title">
                        <i class="fas fa-id-card"></i>
                        <span>Datos Personales</span>
                    </div>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>Tipo de Documento</td>
                                <td>{{ $matricula->alumno->tipo_documento }}</td>
                            </tr>
                            <tr>
                                <td>Número de Documento</td>
                                <td>
                                    {{ $matricula->alumno->numero_documento }}
                                    <a class="copy-btn" @click="copiar('{{ $matricula->alumno->numero_documento }}')">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Nombres Completos</td>
                                <td>
                                    {{ $matricula->alumno->nombre_completo }}
                                    <a class="copy-btn" @click="copiar('{{ $matricula->alumno->nombre_completo }}')">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Fecha de Nacimiento</td>
                                <td>{{ $matricula->alumno->fecha_nacimiento | dateFormat }}
                                    ({{ $matricula->alumno->edad }} años)</td>
                            </tr>
                            <tr>
                                <td>Género</td>
                                <td>{{ $matricula->alumno->genero == 'M' ? 'Masculino' : 'Femenino' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="info-section">
                    <div class="info-section-title">
                        <i class="fas fa-phone"></i>
                        <span>Datos de Contacto</span>
                    </div>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>Celular</td>
                                <td>
                                    {{ $matricula->alumno->celular }}
                                    <a class="copy-btn" @click="copiar('{{ $matricula->alumno->celular }}')">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Teléfono de Emergencia</td>
                                <td>
                                    {{ $matricula->alumno->telefono_emergencia }}
                                    <a class="copy-btn"
                                        @click="copiar('{{ $matricula->alumno->telefono_emergencia }}')">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td>Correo Electrónico</td>
                                <td>
                                    {{ strtolower($matricula->alumno->correo) }}
                                    <a class="copy-btn"
                                        @click="copiar('{{ strtolower($matricula->alumno->correo) }}')">
                                        <i class="fa fa-copy"></i>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="info-section">
                    <div class="info-section-title">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Datos de Ubicación</span>
                    </div>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>Dirección</td>
                                <td>{{ $matricula->alumno->domicilio }}</td>
                            </tr>
                            <tr>
                                <td>Ubicación</td>
                                <td>
                                    {{ $matricula->alumno->departamento->nombre }},
                                    {{ $matricula->alumno->provincia->nombre }},
                                    {{ $matricula->alumno->distrito->nombre }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="info-section">
                    <div class="info-section-title">
                        <i class="fas fa-graduation-cap"></i>
                        <span>Datos Académicos y Religiosos</span>
                    </div>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>Colegio de Procedencia</td>
                                <td>{{ $matricula->alumno->colegio_procedencia }}</td>
                            </tr>
                            <tr>
                                <td>Religión</td>
                                <td>{{ $matricula->alumno->religion ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Exonerado de Religión</td>
                                <td>
                                    <span
                                        class="tag-improved {{ $matricula->alumno->exonerado_religion ? 'success' : 'light' }}">
                                        {{ $matricula->alumno->exonerado_religion ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Bautizado</td>
                                <td>
                                    <span
                                        class="tag-improved {{ $matricula->alumno->bautizado ? 'success' : 'light' }}">
                                        {{ $matricula->alumno->bautizado ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Primera Comunión</td>
                                <td>
                                    <span
                                        class="tag-improved {{ $matricula->alumno->comunion ? 'success' : 'light' }}">
                                        {{ $matricula->alumno->comunion ? 'Sí' : 'No' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Formulario de edición --}}
                <form wire:submit.prevent="actualizarAlumno" class="form-improved">
                    <div class="info-grid-4">
                        <div class="field">
                            <label class="label">Tipo de Documento</label>
                            <div class="select is-fullwidth">
                                <select wire:model="tipo_documento">
                                    <option value="DNI">DNI</option>
                                    <option value="CE">CE</option>
                                    <option value="PTP">PTP</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Número de Documento</label>
                            <input class="input" type="text" wire:model="numero_documento">
                            @error('numero_documento')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="label">Fecha de Nacimiento</label>
                            <input class="input" type="date" wire:model="fecha_nacimiento">
                            @error('fecha_nacimiento')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="label">Género</label>
                            <div class="select is-fullwidth">
                                <select wire:model="genero">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="info-grid-3">
                        <div class="field">
                            <label class="label">Apellido Paterno</label>
                            <input class="input" type="text" wire:model="apellido_paterno">
                            @error('apellido_paterno')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="label">Apellido Materno</label>
                            <input class="input" type="text" wire:model="apellido_materno">
                            @error('apellido_materno')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="label">Nombres</label>
                            <input class="input" type="text" wire:model="nombres">
                            @error('nombres')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="info-grid-3">
                        <div class="field">
                            <label class="label">Celular</label>
                            <input class="input" type="text" wire:model="celular">
                        </div>
                        <div class="field">
                            <label class="label">Teléfono de Emergencia</label>
                            <input class="input" type="text" wire:model="telefono_emergencia">
                        </div>
                        <div class="field">
                            <label class="label">Correo Electrónico</label>
                            <input class="input" type="email" wire:model="correo">
                            @error('correo')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">Dirección</label>
                        <input class="input" type="text" wire:model="domicilio">
                    </div>

                    <div class="info-grid-2">
                        <div class="field">
                            <label class="label">Colegio de Procedencia</label>
                            <input class="input" type="text" wire:model="colegio_procedencia">
                        </div>
                        <div class="field">
                            <label class="label">Religión</label>
                            <input class="input" type="text" wire:model="religion">
                        </div>
                    </div>

                    <div class="info-grid-3">
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" wire:model="exonerado_religion">
                                Exonerado de Religión
                            </label>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" wire:model="bautizado">
                                Bautizado
                            </label>
                        </div>
                        <div class="field">
                            <label class="checkbox">
                                <input type="checkbox" wire:model="comunion">
                                Comunión
                            </label>
                        </div>
                    </div>

                    <div class="mt-4 has-text-right">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            @endif
        </div>

        {{-- Tab: Padres --}}
        <div x-show="activeTab === 'padres'">
            @forelse($matricula->alumno->padres as $padre)
                <div class="parent-card"
                    :class="{ 'editing': {{ $editMode && $padre_edit_id == $padre->id ? 'true' : 'false' }} }">
                    <div class="section-header">
                        <div class="section-title">
                            <i class="fas fa-user-alt"></i>
                            <span>
                                @if ($padre->parentesco == 'P')
                                    Padre
                                @else
                                    Madre
                                @endif
                                @if (!$padre->vive)
                                    <span class="ml-2 tag-improved danger">Fallecido(a)</span>
                                @endif
                            </span>
                        </div>
                        @if (!$editMode || $padre_edit_id != $padre->id)
                            <button wire:click="editarPadre({{ $padre->id }})" class="btn-edit">
                                <i class="fas fa-edit"></i> Editar
                            </button>
                        @else
                            <button wire:click="cancelEdit" class="btn-cancel">
                                <i class="fas fa-times"></i> Cancelar
                            </button>
                        @endif
                    </div>

                    @if (!$editMode || $padre_edit_id != $padre->id)
                        {{-- Vista de solo lectura --}}
                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="fas fa-id-card"></i>
                                <span>Datos Personales</span>
                            </div>
                            <table class="info-table">
                                <tbody>
                                    <tr>
                                        <td>Tipo y Número de Documento</td>
                                        <td>
                                            {{ $padre->tipo_documento }}: {{ $padre->numero_documento }}
                                            <a class="copy-btn" @click="copiar('{{ $padre->numero_documento }}')">
                                                <i class="fa fa-copy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nombre Completo</td>
                                        <td>
                                            {{ $padre->nombre_completo }}
                                            <a class="copy-btn" @click="copiar('{{ $padre->nombre_completo }}')">
                                                <i class="fa fa-copy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estado Civil</td>
                                        <td>{{ $padre->estado_civil | edoCivil }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nivel de Escolaridad</td>
                                        <td>{{ $padre->nivel_escolaridad }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="fas fa-phone"></i>
                                <span>Datos de Contacto</span>
                            </div>
                            <table class="info-table">
                                <tbody>
                                    <tr>
                                        <td>Celular</td>
                                        <td>
                                            {{ $padre->telefono_celular }}
                                            <a class="copy-btn" @click="copiar('{{ $padre->telefono_celular }}')">
                                                <i class="fa fa-copy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Correo Electrónico</td>
                                        <td>
                                            {{ strtolower($padre->correo_electronico) }}
                                            <a class="copy-btn"
                                                @click="copiar('{{ strtolower($padre->correo_electronico) }}')">
                                                <i class="fa fa-copy"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Dirección</td>
                                        <td>{{ $padre->domicilio }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="fas fa-briefcase"></i>
                                <span>Datos Laborales</span>
                            </div>
                            <table class="info-table">
                                <tbody>
                                    <tr>
                                        <td>Centro de Trabajo</td>
                                        <td>{{ $padre->centro_trabajo }}</td>
                                    </tr>
                                    <tr>
                                        <td>Cargo/Ocupación</td>
                                        <td>{{ $padre->cargo_ocupacion }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="info-section">
                            <div class="info-section-title">
                                <i class="fas fa-info-circle"></i>
                                <span>Información Adicional</span>
                            </div>
                            <table class="info-table">
                                <tbody>
                                    <tr>
                                        <td>Vive con el Estudiante</td>
                                        <td>
                                            <span
                                                class="tag-improved {{ $padre->vive_estudiante ? 'success' : 'light' }}">
                                                {{ $padre->vive_estudiante ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Responsable Económico</td>
                                        <td>
                                            <span
                                                class="tag-improved {{ $padre->responsable_economico ? 'success' : 'light' }}">
                                                {{ $padre->responsable_economico ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apoderado</td>
                                        <td>
                                            <span class="tag-improved {{ $padre->apoderado ? 'success' : 'light' }}">
                                                {{ $padre->apoderado ? 'Sí' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estado</td>
                                        <td>
                                            <span class="tag-improved {{ $padre->vive ? 'success' : 'danger' }}">
                                                {{ $padre->vive ? 'Vive' : 'Fallecido(a)' }}
                                            </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        {{-- Formulario de edición --}}
                        <form wire:submit.prevent="actualizarPadre" class="form-improved">
                            <div class="info-grid-4">
                                <div class="field">
                                    <label class="label">Tipo Doc.</label>
                                    <div class="select is-fullwidth">
                                        <select wire:model="padre_tipo_documento">
                                            <option value="DNI">DNI</option>
                                            <option value="CE">CE</option>
                                            <option value="PTP">PTP</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Número</label>
                                    <input class="input" type="text" wire:model="padre_numero_documento">
                                </div>
                                <div class="field">
                                    <label class="label">Apellidos</label>
                                    <input class="input" type="text" wire:model="padre_apellidos">
                                </div>
                                <div class="field">
                                    <label class="label">Nombres</label>
                                    <input class="input" type="text" wire:model="padre_nombres">
                                </div>
                            </div>

                            <div class="info-grid-3">
                                <div class="field">
                                    <label class="label">Estado Civil</label>
                                    <div class="select is-fullwidth">
                                        <select wire:model="padre_estado_civil">
                                            <option value="S">Soltero(a)</option>
                                            <option value="C">Casado(a)</option>
                                            <option value="V">Viudo(a)</option>
                                            <option value="D">Divorciado(a)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="field">
                                    <label class="label">Escolaridad</label>
                                    <input class="input" type="text" wire:model="padre_nivel_escolaridad">
                                </div>
                                <div class="field">
                                    <label class="label">Celular</label>
                                    <input class="input" type="text" wire:model="padre_telefono_celular">
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Correo Electrónico</label>
                                <input class="input" type="email" wire:model="padre_correo_electronico">
                            </div>

                            <div class="field">
                                <label class="label">Dirección</label>
                                <input class="input" type="text" wire:model="padre_domicilio">
                            </div>

                            <div class="info-grid-2">
                                <div class="field">
                                    <label class="label">Centro de Trabajo</label>
                                    <input class="input" type="text" wire:model="padre_centro_trabajo">
                                </div>
                                <div class="field">
                                    <label class="label">Cargo/Ocupación</label>
                                    <input class="input" type="text" wire:model="padre_cargo_ocupacion">
                                </div>
                            </div>

                            <div class="info-grid-4">
                                <div class="field">
                                    <label class="checkbox">
                                        <input type="checkbox" wire:model="padre_vive_estudiante">
                                        Vive con estudiante
                                    </label>
                                </div>
                                <div class="field">
                                    <label class="checkbox">
                                        <input type="checkbox" wire:model="padre_responsable_economico">
                                        Resp. Económico
                                    </label>
                                </div>
                                <div class="field">
                                    <label class="checkbox">
                                        <input type="checkbox" wire:model="padre_apoderado">
                                        Apoderado
                                    </label>
                                </div>
                                <div class="field">
                                    <label class="checkbox">
                                        <input type="checkbox" wire:model="padre_vive">
                                        Vive
                                    </label>
                                </div>
                            </div>

                            <div class="mt-4 has-text-right">
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save"></i> Guardar Cambios
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-users"></i>
                    <p>No hay información de padres registrada</p>
                </div>
            @endforelse
        </div>

        {{-- Tab: Apoderados --}}
        <div x-show="activeTab === 'apoderados'">
            @forelse($matricula->alumno->apoderados as $apoderado)
                <div class="parent-card">
                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="fas fa-id-card"></i>
                            <span>Datos Personales</span>
                        </div>
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <td>Tipo y Número de Documento</td>
                                    <td>
                                        {{ $apoderado->tipo_documento }}: {{ $apoderado->numero_documento }}
                                        <a class="copy-btn" @click="copiar('{{ $apoderado->numero_documento }}')">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Nombre Completo</td>
                                    <td>{{ $apoderado->apellidos }}, {{ ucfirst(strtolower($apoderado->nombres)) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td>Parentesco</td>
                                    <td>{{ $apoderado->parentesco }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="fas fa-phone"></i>
                            <span>Datos de Contacto</span>
                        </div>
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <td>Celular</td>
                                    <td>
                                        {{ $apoderado->telefono_celular }}
                                        <a class="copy-btn" @click="copiar('{{ $apoderado->telefono_celular }}')">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Correo Electrónico</td>
                                    <td>
                                        {{ strtolower($apoderado->correo_electronico) }}
                                        <a class="copy-btn"
                                            @click="copiar('{{ strtolower($apoderado->correo_electronico) }}')">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="fas fa-briefcase"></i>
                            <span>Datos Académicos y Laborales</span>
                        </div>
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <td>Centro de Trabajo</td>
                                    <td>{{ $apoderado->centro_trabajo }}</td>
                                </tr>
                                <tr>
                                    <td>Nivel de Escolaridad</td>
                                    <td>{{ $apoderado->nivel_escolaridad }}</td>
                                </tr>
                                <tr>
                                    <td>Grado Obtenido</td>
                                    <td>{{ $apoderado->grado_obtenido ?? 'N/T' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">
                            <i class="fas fa-info-circle"></i>
                            <span>Información Adicional</span>
                        </div>
                        <table class="info-table">
                            <tbody>
                                <tr>
                                    <td>Vive con el Estudiante</td>
                                    <td>
                                        <span
                                            class="tag-improved {{ $apoderado->vive_estudiante ? 'success' : 'light' }}">
                                            {{ $apoderado->vive_estudiante ? 'Sí' : 'No' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Responsable Económico</td>
                                    <td>
                                        <span
                                            class="tag-improved {{ $apoderado->responsable_economico ? 'success' : 'light' }}">
                                            {{ $apoderado->responsable_economico ? 'Sí' : 'No' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Apoderado</td>
                                    <td>
                                        <span class="tag-improved {{ $apoderado->apoderado ? 'success' : 'light' }}">
                                            {{ $apoderado->apoderado ? 'Sí' : 'No' }}
                                        </span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <i class="fas fa-user-tie"></i>
                    <p>No hay apoderados registrados</p>
                </div>
            @endforelse
        </div>

        {{-- Tab: Responsable Económico --}}
        <div x-show="activeTab === 'responsable_economico'">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-wallet"></i>
                    <span>Responsable Económico</span>
                </div>
                @if (!$editMode)
                    <button wire:click="toggleEditMode" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </button>
                @else
                    <button wire:click="cancelEdit" class="btn-cancel">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                @endif
            </div>

            @if (!$editMode)
                {{-- Vista de solo lectura --}}
                <div class="info-section">
                    <div class="info-section-title">
                        <i class="fas fa-id-card"></i>
                        <span>Datos del Responsable Económico</span>
                    </div>
                    <table class="info-table">
                        <tbody>
                            <tr>
                                <td>Tipo de Documento</td>
                                <td>{{ $matricula->tipo_documento_dj ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <td>Número de Documento</td>
                                <td>
                                    {{ $matricula->numero_documento_dj ?? 'N/A' }}
                                    @if ($matricula->numero_documento_dj)
                                        <a class="copy-btn" @click="copiar('{{ $matricula->numero_documento_dj }}')">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Nombres Completos</td>
                                <td>
                                    {{ $matricula->nombres_dj ?? 'N/A' }}
                                    @if ($matricula->nombres_dj)
                                        <a class="copy-btn" @click="copiar('{{ $matricula->nombres_dj }}')">
                                            <i class="fa fa-copy"></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Formulario de edición --}}
                <form wire:submit.prevent="actualizarResponsableEconomico" class="form-improved">
                    <div class="info-grid-3">
                        <div class="field">
                            <label class="label">Tipo de Documento</label>
                            <div class="select is-fullwidth">
                                <select wire:model="tipo_documento_dj">
                                    <option value="DNI">DNI</option>
                                    <option value="CE">CE</option>
                                    <option value="PTP">PTP</option>
                                    <option value="PN">PN</option>
                                </select>
                            </div>
                        </div>
                        <div class="field">
                            <label class="label">Número de Documento</label>
                            <input class="input" type="text" wire:model="numero_documento_dj">
                            @error('numero_documento_dj')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="field">
                            <label class="label">Nombres Completos</label>
                            <input class="input" type="text" wire:model="nombres_dj">
                            @error('nombres_dj')
                                <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 has-text-right">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            @endif
        </div>

        {{-- Tab: Pagos --}}
        <div x-show="activeTab === 'pagos'">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-money-bill-wave"></i>
                    <span>Historial de Pagos</span>
                </div>
            </div>

            @if (count($matricula->pagos) > 0)
                <table class="payments-table">
                    <thead>
                        <tr>
                            <th class="has-text-centered">Estado</th>
                            <th>Concepto</th>
                            <th>Método</th>
                            <th>Operación</th>
                            <th class="has-text-right">Monto</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($matricula->pagos as $pago)
                            <tr>
                                <td class="has-text-centered">{!! $pago->status !!}</td>
                                <td>{{ $pago->concepto == 'M' ? 'Matrícula' : 'Pensión' }}</td>
                                <td>{{ $pago->tipo_pago | mp }}</td>
                                <td>{{ $pago->numero_operacion }}</td>
                                <td class="has-text-right"><strong>S./ {{ $pago->monto_pagado }}</strong></td>
                                <td>{{ $pago->fecha_deposito | dateFormat }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-money-bill-wave"></i>
                    <p>No hay pagos registrados en esta matrícula</p>
                </div>
            @endif
        </div>

        {{-- Tab: Horario --}}
        <div x-show="activeTab === 'horario'">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-clock"></i>
                    <span>Horario del Estudiante</span>
                </div>
            </div>

            <form wire:submit.prevent='actualizarHoras' class="form-improved">
                <div class="schedule-form">
                    <div class="field">
                        <label class="label">Hora de Entrada</label>
                        <div class="control">
                            <input class="input" type="time" wire:model="hora_entrada" />
                        </div>
                        @error('hora_entrada')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">Hora de Salida</label>
                        <div class="control">
                            <input class="input" type="time" wire:model="hora_salida" />
                        </div>
                        @error('hora_salida')
                            <p class="help is-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="field">
                        <label class="label">&nbsp;</label>
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Guardar Horario
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Tab: Usuarios --}}
        <div x-show="activeTab === 'usuarios'">
            <div class="section-header">
                <div class="section-title">
                    <i class="fas fa-user-shield"></i>
                    <span>Acceso de Padres al Portal</span>
                </div>
            </div>

            <div class="columns is-multiline">
                @forelse($matricula->alumno->padres as $padre)
                    <div class="column is-6">
                        <div class="info-section">
                            <div class="is-flex is-justify-content-between is-align-items-start mb-3">
                                <div>
                                    <h5 class="title is-6 mb-1">{{ $padre->nombre_completo }}</h5>
                                    <span class="tag is-light is-small">
                                        {{ $padre->parentesco == 'P' ? 'PADRE' : 'MADRE' }}
                                    </span>
                                </div>
                                @if ($padre->user)
                                    <span class="tag-improved {{ $padre->user->is_active ? 'success' : 'danger' }}">
                                        {{ $padre->user->is_active ? 'ACTIVO' : 'INACTIVO' }}
                                    </span>
                                @else
                                    <span class="tag-improved warning">SIN CUENTA</span>
                                @endif
                            </div>

                            @if ($padre->user)
                                <table class="info-table mb-4">
                                    <tbody>
                                        <tr>
                                            <td>Usuario (DNI)</td>
                                            <td><strong>{{ $padre->user->document_number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <td>Último Acceso</td>
                                            <td>{{ $padre->user->last_login_at ? $padre->user->last_login_at->diffForHumans() : 'Nunca' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="buttons">
                                    <button wire:click="resetearPasswordPadre({{ $padre->user->id }})"
                                        class="button is-small is-warning is-light"
                                        onclick="confirm('¿Estás seguro de restablecer la contraseña al número de documento?') || event.stopImmediatePropagation()">
                                        <i class="fas fa-key mr-2"></i> Reset Clave
                                    </button>

                                    <button wire:click="toggleUsuarioPadre({{ $padre->user->id }})"
                                        class="button is-small {{ $padre->user->is_active ? 'is-danger' : 'is-success' }} is-light">
                                        <i
                                            class="fas {{ $padre->user->is_active ? 'fa-user-slash' : 'fa-user-check' }} mr-2"></i>
                                        {{ $padre->user->is_active ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </div>
                            @else
                                <div class="empty-state py-4">
                                    <p class="mb-3 is-size-7">Este padre no tiene un usuario para acceder a la
                                        aplicación móvil.</p>
                                    <button wire:click="crearUsuarioPadre({{ $padre->id }})"
                                        class="button is-small is-success has-text-white is-rounded px-4">
                                        <i class="fas fa-user-plus mr-2"></i> Crear Usuario de Acceso
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="column is-12">
                        <div class="empty-state">
                            <i class="fas fa-user-friends"></i>
                            <p>No hay información de padres registrada para este estudiante.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Loading Overlay --}}
    <div class="loading-matricula" wire:loading
        wire:target="actualizarAlumno,actualizarPadre,actualizarHoras,actualizarResponsableEconomico"
        style="display: none;">
        <div class="loading-matricula-body" style="margin: 100px auto;">
            <div class="spinner" style="text-align: center;">
                <img src="{{ asset('images/loader.svg') }}" />
            </div>
            <div class="mensaje">
                Procesando.....
            </div>
        </div>
    </div>
</div>

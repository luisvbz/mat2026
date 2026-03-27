<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div
                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-gray-300 flex items-center justify-center text-colegio-600">
                <i class="ph-fill ph-user-focus text-2xl"></i>
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Detalle del Profesor</h1>
                <p class="text-sm text-gray-800 font-medium">Perfil y actividad del personal</p>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('dashboard.profesores') }}"
                class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-800 hover:bg-gray-50 transition-all shadow-sm">
                <i class="ph ph-arrow-left mr-2"></i> Volver
            </a>
            <a href="{{ route('dashboard.profesores.editar', $teacher->id) }}"
                class="inline-flex items-center px-4 py-2 bg-colegio-600 text-white rounded-lg text-sm font-bold hover:bg-colegio-700 transition-all shadow-md shadow-colegio-100">
                <i class="ph ph-pencil-simple mr-2"></i> Editar Perfil
            </a>
        </div>
    </div>

    <livewire:commons.mod-profesor />

    @if (session()->has('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl flex items-center gap-3">
            <i class="ph-fill ph-check-circle text-green-500 text-xl"></i>
            <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl flex items-center gap-3">
            <i class="ph-fill ph-warning-circle text-red-500 text-xl"></i>
            <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        {{-- Sidebar: Perfil Rápido --}}
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-300 p-8 text-center relative overflow-hidden">
                {{-- Fondo decorativo --}}
                <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-br from-colegio-50 to-blue-50/50 -z-0">
                </div>

                <div class="relative z-10">
                    <div class="inline-block relative">
                        <img class="w-32 h-32 rounded-2xl object-cover ring-4 ring-white shadow-xl mx-auto"
                            src="{{ $teacher->foto }}"
                            onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($teacher->nombres . ' ' . $teacher->apellidos) }}&color=7F9CF5&background=EBF4FF&bold=true&size=128'">
                        <div
                            class="absolute -bottom-2 -right-2 w-8 h-8 rounded-lg {{ $teacher->estado == 1 ? 'bg-green-500' : 'bg-red-500' }} border-4 border-white flex items-center justify-center shadow-lg">
                            <i class="ph-fill ph-circle text-[8px] text-white"></i>
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-800 mt-6">{{ $teacher->nombres }}</h3>
                    <p class="text-lg font-bold text-gray-800 uppercase tracking-tight">{{ $teacher->apellidos }}</p>
                    <p class="text-sm font-mono text-gray-800 mt-1 tracking-widest">{{ $teacher->documento }}</p>

                    <div class="flex flex-wrap justify-center gap-2 mt-6">
                        <span
                            class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wider {{ $teacher->estado == 1 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $teacher->estado == 1 ? 'Activo' : 'Inactivo' }}
                        </span>
                        <span
                            class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-[11px] font-bold uppercase tracking-wider">
                            {{ $teacher->horario->name ?? 'Sin horario' }}
                        </span>
                    </div>

                    @if (!$teacher->user)
                        <div class="mt-8">
                            <button wire:click="crearUsuario"
                                class="w-full inline-flex justify-center items-center px-4 py-2.5 bg-yellow-500 text-white rounded-xl text-sm font-bold hover:bg-yellow-600 transition-all shadow-lg shadow-yellow-100">
                                <i class="ph ph-user-plus mr-2"></i> Crear Usuario
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-300 p-6">
                <div class="flex items-center gap-2 mb-6 pb-2 border-b border-gray-50">
                    <i class="ph ph-shield-check text-colegio-500 text-lg"></i>
                    <h4 class="font-bold text-gray-800 text-xs uppercase tracking-widest">Seguridad de Cuenta</h4>
                </div>

                @if ($teacher->user)
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-800 font-medium">Usuario</span>
                            <span
                                class="text-sm font-mono font-bold text-gray-800 bg-gray-50 px-2 py-0.5 rounded">{{ $teacher->user->document_number }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-800 font-medium">Estado</span>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $teacher->user->is_active ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $teacher->user->is_active ? 'Activo' : 'Suspendido' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between pt-2">
                            <span class="text-sm text-gray-800 font-medium">Último acceso</span>
                            <span class="text-xs font-semibold text-gray-800 italic">
                                {{ $teacher->user->last_login_at ? $teacher->user->last_login_at->diffForHumans() : 'Sin actividad' }}
                            </span>
                        </div>
                    </div>
                @else
                    <div class="py-4 text-center">
                        <i class="ph ph-user-circle-minus text-3xl text-gray-300 mb-2 block mx-auto"></i>
                        <p class="text-sm text-gray-800 italic">No tiene un usuario configurado.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Contenido Principal: Tabs --}}
        <div class="lg:col-span-8 flex flex-col space-y-6">
            {{-- Navigation Tabs --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-300 p-1.5 flex gap-1">
                <button wire:click="setTab('info')"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold transition-all {{ $activeTab === 'info' ? 'bg-colegio-600 text-white shadow-lg shadow-colegio-100' : 'text-gray-800 hover:bg-gray-50' }}">
                    <i class="ph ph-info text-lg"></i> Información
                </button>
                <button wire:click="setTab('appointments')"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold transition-all {{ $activeTab === 'appointments' ? 'bg-colegio-600 text-white shadow-lg shadow-colegio-100' : 'text-gray-800 hover:bg-gray-50' }}">
                    <i class="ph ph-calendar-check text-lg"></i> Citas
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] {{ $activeTab === 'appointments' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-800' }}">
                        {{ \App\Models\Appointment::where('teacher_id', $teacher->id)->count() }}
                    </span>
                </button>
                <button wire:click="setTab('messages')"
                    class="flex-1 flex items-center justify-center gap-2 py-2.5 rounded-xl text-sm font-bold transition-all {{ $activeTab === 'messages' ? 'bg-colegio-600 text-white shadow-lg shadow-colegio-100' : 'text-gray-800 hover:bg-gray-50' }}">
                    <i class="ph ph-envelope-simple text-lg"></i> Mensajes
                    <span
                        class="ml-1 px-1.5 py-0.5 rounded-full text-[10px] {{ $activeTab === 'messages' ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-800' }}">
                        {{ $teacher->user ? \App\Models\AgendaMessage::where('teacher_user_id', $teacher->user->id)->count() : 0 }}
                    </span>
                </button>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-300 p-8 flex-1 min-h-[500px]">
                @if ($activeTab === 'info')
                    <div class="space-y-8 animate-in fade-in slide-in-from-bottom-2 duration-300">
                        <div class="flex items-center gap-2 pb-4 border-b border-gray-50">
                            <i class="ph ph-list-bullets text-colegio-500 text-xl"></i>
                            <h4 class="text-lg font-bold text-gray-800">Datos del Perfil</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-widest">Nombres y
                                    Apellidos</p>
                                <p class="text-gray-800 font-bold uppercase">{{ $teacher->nombres }}
                                    {{ $teacher->apellidos }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-widest">DNI / Documento
                                </p>
                                <p class="text-gray-800 font-mono font-bold tracking-tighter text-lg">
                                    {{ $teacher->documento }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-widest">Correo
                                    Electrónico</p>
                                <p class="text-gray-800 font-semibold">
                                    {{ strtolower($teacher->email ?? 'no registrado') }}</p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-widest">Teléfono /
                                    Celular</p>
                                <div class="flex items-center gap-2">
                                    <p class="text-gray-800 font-semibold">{{ $teacher->telefono ?? 'no registrado' }}
                                    </p>
                                    @if ($teacher->telefono)
                                        <a href="https://wa.me/51{{ $teacher->telefono }}" target="_blank"
                                            class="text-green-500 hover:text-green-600 transition-colors">
                                            <i class="ph-fill ph-whatsapp-logo text-lg"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-gray-800 uppercase tracking-widest">Horario Laboral
                                </p>
                                <span
                                    class="inline-block px-3 py-1 bg-blue-50 text-blue-700 rounded-lg text-xs font-bold uppercase tracking-tight">
                                    {{ $teacher->horario->name ?? 'No asignado' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($activeTab === 'appointments')
                    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-2 duration-300">
                        <div class="flex items-center gap-2 pb-4 border-b border-gray-50">
                            <i class="ph ph-calendar-check text-colegio-500 text-xl"></i>
                            <h4 class="text-lg font-bold text-gray-800">Historial de Citas</h4>
                        </div>

                        {{-- Filtros de Citas --}}
                        <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-300">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-gray-800 uppercase tracking-widest ml-1">Nivel</label>
                                    <select wire:model="filterNivel"
                                        class="w-full h-10 pl-3 pr-8 py-1 bg-white border border-gray-200 rounded-xl text-xs font-semibold focus:ring-colegio-500 focus:border-colegio-500 transition-all appearance-none">
                                        <option value="">Cualquier nivel</option>
                                        <option value="P">Primaria</option>
                                        <option value="S">Secundaria</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-gray-800 uppercase tracking-widest ml-1">Grado</label>
                                    <select wire:model="filterGrado"
                                        class="w-full h-10 pl-3 pr-8 py-1 bg-white border border-gray-200 rounded-xl text-xs font-semibold focus:ring-colegio-500 focus:border-colegio-500 transition-all appearance-none">
                                        <option value="">Cualquier grado</option>
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}">{{ $i }}° Grado</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-gray-800 uppercase tracking-widest ml-1">Fecha</label>
                                    <input type="date" wire:model="filterFecha"
                                        class="w-full h-10 px-3 py-1 bg-white border border-gray-200 rounded-xl text-xs font-semibold focus:ring-colegio-500 focus:border-colegio-500 transition-all">
                                </div>
                                <div class="flex items-end text-gray-800">
                                    <button
                                        class="w-full h-10 flex items-center justify-center gap-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-800 hover:bg-gray-100 transition-all shadow-sm"
                                        wire:click="$set('filterNivel', ''); $set('filterGrado', ''); $set('filterFecha', '');">
                                        <i class="ph ph-arrow-counter-clockwise"></i> Resetear
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="overflow-hidden rounded-2xl border border-gray-300">
                            <table class="w-full text-sm text-left">
                                <thead
                                    class="bg-gray-50 text-gray-800 uppercase text-[10px] font-bold tracking-widest border-b border-gray-300">
                                    <tr>
                                        <th class="px-2 py-2">Fecha y Hora</th>
                                        <th class="px-2 py-2">Alumno</th>
                                        <th class="px-2 py-2">Padre/Madre</th>
                                        <th class="px-2 py-2 text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($appointments as $appointment)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-2 py-2">
                                                <p class="font-bold text-gray-800">
                                                    {{ $appointment->date->format('d/m/Y') }}</p>
                                                <p class="text-xs text-colegio-500 font-semibold uppercase">
                                                    {{ $appointment->time->format('h:i A') }}</p>
                                            </td>
                                            <td class="px-2 py-2">
                                                <p class="font-bold text-gray-700 uppercase">
                                                    {{ $appointment->student->nombre_completo ?? 'N/A' }}</p>
                                            </td>
                                            <td class="px-2 py-2">
                                                <p class="text-xs font-semibold text-gray-800">
                                                    {{ $appointment->parent->nombre_completo ?? 'N/A' }}</p>
                                            </td>
                                            <td class="px-2 py-2 text-center">
                                                <span
                                                    class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                                    {{ $appointment->status === 'confirmed' ? 'bg-green-100 text-green-700' : ($appointment->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700') }}">
                                                    {{ $appointment->status }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4"
                                                class="px-2 py-12 text-center text-gray-300 italic text-xs">No hay
                                                citas registradas.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if ($activeTab === 'messages')
                    <div class="space-y-6 animate-in fade-in slide-in-from-bottom-2 duration-300">
                        <div class="flex items-center gap-2 pb-4 border-b border-gray-50">
                            <i class="ph ph-envelope-simple text-colegio-500 text-xl"></i>
                            <h4 class="text-lg font-bold text-gray-800">Mensajes de Agenda</h4>
                        </div>

                        {{-- Filtros de Mensajes --}}
                        <div class="bg-gray-50/50 rounded-2xl p-4 border border-gray-300">
                            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-gray-800 uppercase tracking-widest ml-1">Nivel</label>
                                    <select wire:model="filterNivel"
                                        class="w-full h-10 pl-3 pr-8 py-1 bg-white border border-gray-200 rounded-xl text-xs font-semibold focus:ring-colegio-500 focus:border-colegio-500 transition-all appearance-none">
                                        <option value="">Cualquier nivel</option>
                                        <option value="P">Primaria</option>
                                        <option value="S">Secundaria</option>
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-gray-800 uppercase tracking-widest ml-1">Grado</label>
                                    <select wire:model="filterGrado"
                                        class="w-full h-10 pl-3 pr-8 py-1 bg-white border border-gray-200 rounded-xl text-xs font-semibold focus:ring-colegio-500 focus:border-colegio-500 transition-all appearance-none">
                                        <option value="">Cualquier grado</option>
                                        @for ($i = 1; $i <= 6; $i++)
                                            <option value="{{ $i }}">{{ $i }}° Grado</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="space-y-1">
                                    <label
                                        class="text-[10px] font-bold text-gray-800 uppercase tracking-widest ml-1">Fecha</label>
                                    <input type="date" wire:model="filterFecha"
                                        class="w-full h-10 px-3 py-1 bg-white border border-gray-200 rounded-xl text-xs font-semibold focus:ring-colegio-500 focus:border-colegio-500 transition-all">
                                </div>
                                <div class="flex items-end text-gray-800">
                                    <button
                                        class="w-full h-10 flex items-center justify-center gap-2 bg-white border border-gray-200 rounded-xl text-xs font-bold text-gray-800 hover:bg-gray-100 transition-all shadow-sm"
                                        wire:click="$set('filterNivel', ''); $set('filterGrado', ''); $set('filterFecha', '');">
                                        <i class="ph ph-arrow-counter-clockwise"></i> Resetear
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @forelse($messages as $msg)
                                <div wire:click="openAgendaModal({{ $msg->id }})"
                                    class="p-5 bg-white border border-gray-300 rounded-2xl hover:border-colegio-200 hover:shadow-md transition-all cursor-pointer flex items-center justify-between group">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 rounded-xl bg-gray-50 flex items-center justify-center text-gray-800 group-hover:bg-colegio-50 group-hover:text-colegio-600 transition-colors shadow-sm">
                                            <i class="ph-fill ph-chat-circle-text text-xl"></i>
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-bold text-gray-800 tracking-tight group-hover:text-colegio-600 transition-colors">
                                                {{ $msg->subject }}</p>
                                            <p
                                                class="text-[10px] text-gray-800 uppercase font-bold tracking-wider mt-0.5">
                                                {{ $msg->matricula->alumno->nombre_completo }} •
                                                {{ $msg->date->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4">
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-[9px] font-bold uppercase tracking-widest {{ $msg->is_read ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                            {{ $msg->is_read ? 'Leído' : 'Pendiente' }}
                                        </span>
                                        <i
                                            class="ph ph-caret-right text-gray-300 group-hover:text-colegio-500 transition-colors text-lg"></i>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center text-gray-300 italic text-sm">No hay mensajes registrados
                                    con estos filtros.</div>
                            @endforelse
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal: Detalle de Agenda --}}
    @if ($showAgendaModal && $selectedAgenda)
        <div class="fixed inset-0 z-[60] flex items-center justify-center p-4">
            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm animate-in fade-in duration-300"
                wire:click="closeAgendaModal"></div>

            {{-- Modal Content --}}
            <div
                class="relative bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in-95 duration-200 flex flex-col max-h-[90vh]">
                {{-- Modal Header --}}
                <div class="p-6 border-b border-gray-300 flex items-center justify-between bg-gray-50/50">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-colegio-600 text-white flex items-center justify-center shadow-lg shadow-colegio-100">
                            <i class="ph ph-chat-centered-text text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 tracking-tight">Detalle de Agenda</h3>
                            <p class="text-[10px] uppercase font-bold text-colegio-500 tracking-widest">
                                {{ $selectedAgenda->date->format('d/m/Y') }}</p>
                        </div>
                    </div>
                    <button wire:click="closeAgendaModal"
                        class="p-2 text-gray-800 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
                        <i class="ph ph-x text-xl"></i>
                    </button>
                </div>

                {{-- Modal Body --}}
                <div class="p-8 overflow-y-auto space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-800 uppercase tracking-widest">Alumno</p>
                            <p class="text-sm font-bold text-gray-800">
                                {{ $selectedAgenda->matricula->alumno->nombre_completo }}</p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[10px] font-bold text-gray-800 uppercase tracking-widest">Asunto</p>
                            <p class="text-sm font-bold text-gray-800">{{ $selectedAgenda->subject }}</p>
                        </div>
                    </div>

                    <div class="bg-blue-50/50 rounded-2xl p-5 border border-blue-50">
                        <p class="text-[10px] font-bold text-blue-400 uppercase tracking-widest mb-3">Mensaje Original
                        </p>
                        <p class="text-sm text-gray-700 leading-relaxed font-semibold">{{ $selectedAgenda->message }}
                        </p>
                    </div>

                    <div class="space-y-4 pt-4">
                        <div class="flex items-center gap-2">
                            <i class="ph ph-arrow-u-up-left text-gray-800"></i>
                            <h4 class="text-[10px] font-bold text-gray-800 uppercase tracking-widest text-colegio-600">
                                Hilo de Respuestas</h4>
                        </div>

                        <div class="space-y-4">
                            @forelse($selectedAgenda->replies as $reply)
                                <div
                                    class="flex gap-4 {{ $reply->author_type === 'parent' ? '' : 'flex-row-reverse' }}">
                                    <div
                                        class="w-9 h-9 rounded-xl flex-shrink-0 flex items-center justify-center text-xs font-bold shadow-sm {{ $reply->author_type === 'parent' ? 'bg-colegio-50 text-colegio-600' : 'bg-blue-50 text-blue-600' }}">
                                        {{ $reply->author_type === 'parent' ? 'P' : 'D' }}
                                    </div>
                                    <div
                                        class="max-w-[85%] {{ $reply->author_type === 'parent' ? '' : 'text-right' }}">
                                        <div
                                            class="p-4 rounded-3xl text-sm leading-relaxed shadow-sm {{ $reply->author_type === 'parent' ? 'bg-gray-50 text-gray-700 rounded-tl-none border border-gray-300' : 'bg-colegio-600 text-white rounded-tr-none' }}">
                                            {{ $reply->message }}
                                        </div>
                                        <p class="text-[9px] font-bold text-gray-800 mt-2 uppercase tracking-widest">
                                            {{ $reply->author_type === 'parent' ? 'Padre/Apoderado' : 'Docente' }} •
                                            {{ $reply->created_at->format('d/m/Y H:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <div
                                    class="py-12 bg-gray-50/30 rounded-2xl border border-dashed border-gray-200 text-center text-gray-300 italic text-xs uppercase tracking-widest">
                                    <i
                                        class="ph ph-chats-circle text-4xl mb-2 opacity-20 block mx-auto text-gray-200"></i>
                                    Sin respuestas en este mensaje
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="p-6 bg-gray-50/50 border-t border-gray-300 flex justify-end">
                    <button wire:click="closeAgendaModal"
                        class="px-8 py-3 bg-gray-800 text-white rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-gray-900 transition-all shadow-lg shadow-gray-200">
                        Cerrar Detalles
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

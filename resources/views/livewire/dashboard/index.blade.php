<div class="p-6 max-w-7xl mx-auto space-y-8 animate-fade-in">
    {{-- Header / Welcome Section --}}
    <div
        class="relative overflow-hidden bg-gradient-to-r from-colegio-700 to-colegio-500 rounded-2xl p-8 text-white shadow-xl animate-slide-up">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <div
                    class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center border border-white/30 shadow-inner">
                    <i class="ph-fill ph-hands-clapping text-4xl text-white"></i>
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold tracking-tight">¡Bienvenido de vuelta!</h1>
                    <p class="text-white/80 mt-1 font-medium italic">"La educación es el arma más poderosa que puedes
                        usar para cambiar el mundo."</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div
                    class="px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl flex items-center gap-2">
                    <i class="ph ph-calendar text-xl"></i>
                    <span class="font-bold">{{ now()->format('d M, Y') }}</span>
                </div>
                <div
                    class="px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl flex items-center gap-2">
                    <i class="ph ph-clock text-xl"></i>
                    <span class="font-bold">{{ now()->format('H:i') }}</span>
                </div>
            </div>
        </div>
        {{-- Background Pattern Decoration --}}
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-48 h-48 bg-black/10 rounded-full blur-2xl"></div>
    </div>

    @php
        $totalPrimaria = $primaria->sum('alumnos');
        $totalSecundaria = $secundaria->sum('alumnos');
        $totalGeneral = $totalPrimaria + $totalSecundaria;
    @endphp

    {{-- Stats Cards Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 animate-slide-up" style="animation-delay: 0.1s">
        {{-- Total Alumnos Card --}}
        <div
            class="bg-white rounded-2xl p-6 flex items-center gap-5 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group card-hover">
            <div
                class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                <i class="ph-fill ph-users text-3xl"></i>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Alumnos</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-4xl font-black text-gray-800 tracking-tight">{{ $totalGeneral }}</h3>
                    <span
                        class="text-xs font-bold text-green-500 bg-green-50 px-2 py-0.5 rounded-full">+{{ now()->year }}</span>
                </div>
            </div>
        </div>

        {{-- Primaria Card --}}
        <div
            class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group card-hover">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                    <i class="ph-fill ph-backpack text-2xl"></i>
                </div>
                <span class="text-2xl font-black text-gray-800">{{ $totalPrimaria }}</span>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Población Primaria</p>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r from-green-400 to-green-600 h-full rounded-full transition-all duration-1000"
                    style="width: {{ $totalGeneral > 0 ? ($totalPrimaria / $totalGeneral) * 100 : 0 }}%"></div>
            </div>
        </div>

        {{-- Secundaria Card --}}
        <div
            class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group card-hover">
            <div class="flex items-center justify-between mb-4">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition-colors duration-300">
                    <i class="ph-fill ph-student text-2xl"></i>
                </div>
                <span class="text-2xl font-black text-gray-800">{{ $totalSecundaria }}</span>
            </div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Población Secundaria</p>
            <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-400 to-purple-600 h-full rounded-full transition-all duration-1000"
                    style="width: {{ $totalGeneral > 0 ? ($totalSecundaria / $totalGeneral) * 100 : 0 }}%"></div>
            </div>
        </div>
    </div>

    {{-- Detailed Tables & Quick Actions --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-slide-up" style="animation-delay: 0.2s">
        {{-- Tables Grid --}}
        <div class="lg:col-span-2 space-y- base">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Primaria Detailed Table --}}
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="bg-gray-50/50 px-6 py-4 flex items-center justify-between border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2 uppercase text-xs tracking-widest">
                            <i class="ph-fill ph-list-numbers text-green-500 text-lg"></i>
                            Base Primaria
                        </h3>
                        <span
                            class="px-3 py-1 bg-green-100 text-green-700 text-[10px] font-black rounded-full uppercase">{{ $totalPrimaria }}
                            matriculas</span>
                    </div>
                    <div class="p-2">
                        <table class="w-full text-sm text-left text-gray-600">
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($primaria as $p)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="px-4 py-3 font-bold text-gray-700">{{ $p->grado | grado }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <span
                                                class="inline-flex items-center px-4 py-1 bg-green-50 text-green-700 rounded-lg font-black text-xs border border-green-100 group-hover:bg-green-500 group-hover:text-white transition-all cursor-default">
                                                {{ $p->alumnos }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Secundaria Detailed Table --}}
                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow">
                    <div class="bg-gray-50/50 px-6 py-4 flex items-center justify-between border-b border-gray-100">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2 uppercase text-xs tracking-widest">
                            <i class="ph-fill ph-list-numbers text-purple-500 text-lg"></i>
                            Base Secundaria
                        </h3>
                        <span
                            class="px-3 py-1 bg-purple-100 text-purple-700 text-[10px] font-black rounded-full uppercase">{{ $totalSecundaria }}
                            matriculas</span>
                    </div>
                    <div class="p-2">
                        <table class="w-full text-sm text-left text-gray-600">
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($secundaria as $p)
                                    <tr class="hover:bg-gray-50/50 transition-colors group">
                                        <td class="px-4 py-3 font-bold text-gray-700">{{ $p->grado | grado }}</td>
                                        <td class="px-4 py-3 text-right">
                                            <span
                                                class="inline-flex items-center px-4 py-1 bg-purple-50 text-purple-700 rounded-lg font-black text-xs border border-purple-100 group-hover:bg-purple-500 group-hover:text-white transition-all cursor-default">
                                                {{ $p->alumnos }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side Actions --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3
                    class="font-bold text-gray-800 flex items-center gap-2 mb-6 uppercase text-xs tracking-widest border-b border-gray-50 pb-4">
                    <i class="ph-bold ph-lightning text-yellow-500"></i>
                    Accesos Dinámicos
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('dashboard.matriculas') }}"
                        class="group flex items-center p-4 rounded-2xl hover:bg-colegio-50 border border-gray-50 hover:border-colegio-100 transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-colegio-50 text-colegio-600 flex items-center justify-center mr-4 group-hover:bg-colegio-600 group-hover:text-white transition-all duration-300 group-hover:rotate-12">
                            <i class="ph-fill ph-identification-card text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-black text-gray-800">Matrículas</h4>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tighter">Gestión de alumnos
                            </p>
                        </div>
                        <i class="ph ph-arrow-right text-gray-300 group-hover:text-colegio-600 transition-colors"></i>
                    </a>

                    <a href="{{ route('contabilidad.pagos-pensiones') }}"
                        class="group flex items-center p-4 rounded-2xl hover:bg-green-50 border border-gray-50 hover:border-green-100 transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center mr-4 group-hover:bg-green-600 group-hover:text-white transition-all duration-300 group-hover:rotate-12">
                            <i class="ph-fill ph-wallet text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-black text-gray-800">Contabilidad</h4>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tighter">Control de pagos
                            </p>
                        </div>
                        <i class="ph ph-arrow-right text-gray-300 group-hover:text-green-600 transition-colors"></i>
                    </a>

                    <a href="{{ route('dashboard.comunicados') }}"
                        class="group flex items-center p-4 rounded-2xl hover:bg-orange-50 border border-gray-50 hover:border-orange-100 transition-all duration-300">
                        <div
                            class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center mr-4 group-hover:bg-orange-600 group-hover:text-white transition-all duration-300 group-hover:rotate-12">
                            <i class="ph-fill ph-megaphone text-2xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-black text-gray-800">Comunicados</h4>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-tighter">Difusión masiva
                            </p>
                        </div>
                        <i class="ph ph-arrow-right text-gray-300 group-hover:text-orange-600 transition-colors"></i>
                    </a>
                </div>
            </div>

            {{-- Secondary Info Card --}}
            <div class="relative overflow-hidden bg-gray-900 rounded-2xl p-6 text-white shadow-lg">
                <div class="relative z-10">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Estado del Servidor</p>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                        <span class="text-sm font-black">Sistema Operativo</span>
                    </div>
                </div>
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/5 rounded-full"></div>
            </div>
        </div>
    </div>
</div>

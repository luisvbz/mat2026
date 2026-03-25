<div class="p-6 max-w-7xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-3">
                <div class="p-2 bg-colegio-100 rounded-lg text-colegio-600">
                    <i class="ph ph-squares-four text-2xl"></i>
                </div>
                Panel de Control - Matrículas 2026
            </h1>
            <p class="text-gray-500 mt-1 ml-14">Resumen y accesos rápidos del sistema.</p>
        </div>
        <div class="flex gap-2 text-sm">
            <span
                class="px-3 py-1 bg-white border border-gray-200 rounded-full shadow-sm flex items-center gap-2 font-medium text-gray-600">
                <i class="ph ph-calendar text-colegio-500"></i> {{ now()->format('d M Y') }}
            </span>
            <span
                class="px-3 py-1 bg-white border border-gray-200 rounded-full shadow-sm flex items-center gap-2 font-medium text-gray-600">
                <i class="ph ph-clock text-colegio-500"></i> {{ now()->format('H:i') }}
            </span>
        </div>
    </div>

    @php
        $totalPrimaria = $primaria->sum('alumnos');
        $totalSecundaria = $secundaria->sum('alumnos');
        $totalGeneral = $totalPrimaria + $totalSecundaria;
    @endphp

    {{-- Stats Cards Overview --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-users text-2xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Alumnos</p>
                <div class="flex items-end gap-2">
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalGeneral }}</h3>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div
                class="w-14 h-14 rounded-full bg-green-50 text-green-600 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-backpack text-2xl"></i>
            </div>
            <div class="w-full">
                <div class="flex justify-between items-end mb-1">
                    <p class="text-sm font-medium text-gray-500">Primaria</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalPrimaria }}</h3>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full"
                        style="width: {{ $totalGeneral > 0 ? ($totalPrimaria / $totalGeneral) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>

        <div
            class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
            <div
                class="w-14 h-14 rounded-full bg-purple-50 text-purple-600 flex items-center justify-center flex-shrink-0">
                <i class="ph-fill ph-student text-2xl"></i>
            </div>
            <div class="w-full">
                <div class="flex justify-between items-end mb-1">
                    <p class="text-sm font-medium text-gray-500">Secundaria</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $totalSecundaria }}</h3>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-purple-500 h-2 rounded-full"
                        style="width: {{ $totalGeneral > 0 ? ($totalSecundaria / $totalGeneral) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions & Details --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Column: Tables --}}
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Primaria Table --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 px-5 py-4 flex items-center justify-between">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="ph-fill ph-backpack text-green-600 text-lg"></i>
                            Matrículas Primaria
                        </h3>
                        <span
                            class="px-2 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full">{{ $totalPrimaria }}</span>
                    </div>
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3 font-semibold text-center">Grado</th>
                                <th class="px-5 py-3 font-semibold text-right">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($primaria as $p)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-3 font-medium text-gray-800 text-center">{{ $p->grado | grado }}
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <span
                                            class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-medium text-xs">
                                            {{ $p->alumnos }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Secundaria Table --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="bg-gray-50 border-b border-gray-100 px-5 py-4 flex items-center justify-between">
                        <h3 class="font-bold text-gray-800 flex items-center gap-2">
                            <i class="ph-fill ph-student text-purple-600 text-lg"></i>
                            Matrículas Secundaria
                        </h3>
                        <span
                            class="px-2 py-1 bg-purple-100 text-purple-700 text-xs font-bold rounded-full">{{ $totalSecundaria }}</span>
                    </div>
                    <table class="w-full text-sm text-left text-gray-600">
                        <thead class="text-xs text-gray-500 uppercase bg-white border-b border-gray-100">
                            <tr>
                                <th class="px-5 py-3 font-semibold text-center">Grado</th>
                                <th class="px-5 py-3 font-semibold text-right">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach ($secundaria as $p)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-5 py-3 font-medium text-gray-800 text-center">{{ $p->grado | grado }}
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <span
                                            class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-full font-medium text-xs">
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

        {{-- Right Column: Quick Actions --}}
        <div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden p-1">
                <div class="px-4 py-3 border-b border-gray-100 mb-2">
                    <h3 class="font-bold text-gray-800 flex items-center gap-2">
                        <i class="ph ph-lightning text-yellow-500 text-lg"></i>
                        Acciones Rápidas
                    </h3>
                </div>
                <div class="p-3 space-y-2">
                    <a href="{{ route('dashboard.matriculas') }}"
                        class="group flex items-center p-3 rounded-lg hover:bg-colegio-50 border border-transparent hover:border-colegio-100 transition-all">
                        <div
                            class="w-10 h-10 rounded-full bg-colegio-100 text-colegio-600 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <i class="ph-fill ph-address-book text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-800 group-hover:text-colegio-700">Ir a Matrículas
                            </h4>
                            <p class="text-xs text-gray-500">Gestionar alumnos inscritos</p>
                        </div>
                        <i class="ph ph-caret-right text-gray-400 group-hover:text-colegio-500"></i>
                    </a>

                    <a href="{{ route('contabilidad.pagos-pensiones') }}"
                        class="group flex items-center p-3 rounded-lg hover:bg-green-50 border border-transparent hover:border-green-100 transition-all">
                        <div
                            class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <i class="ph-fill ph-money text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-800 group-hover:text-green-700">Pagos de Pensiones
                            </h4>
                            <p class="text-xs text-gray-500">Revisar transferencias</p>
                        </div>
                        <i class="ph ph-caret-right text-gray-400 group-hover:text-green-500"></i>
                    </a>

                    <a href="{{ route('dashboard.comunicados') }}"
                        class="group flex items-center p-3 rounded-lg hover:bg-purple-50 border border-transparent hover:border-purple-100 transition-all">
                        <div
                            class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mr-3 group-hover:scale-110 transition-transform">
                            <i class="ph-fill ph-megaphone text-xl"></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-800 group-hover:text-purple-700">Comunicados</h4>
                            <p class="text-xs text-gray-500">Enviar mensajes a padres</p>
                        </div>
                        <i class="ph ph-caret-right text-gray-400 group-hover:text-purple-500"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>

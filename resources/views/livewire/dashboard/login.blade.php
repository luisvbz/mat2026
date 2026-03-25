<div class="bg-white p-8 rounded-2xl shadow-xl w-full">
    <div class="flex justify-center mb-8">
        <img src="{{ asset('images/logo.png') }}" alt="Logo Institucional" class="h-24 object-contain">
    </div>

    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center justify-center">
            <i class="ph ph-bank text-colegio-600 mr-2 text-3xl"></i>
            Matrícula 2026
        </h2>
        <p class="text-gray-500 mt-2 text-sm">Bienvenido al panel administrativo</p>
    </div>

    <form wire:submit.prevent="submitForm" class="space-y-6">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="ph ph-envelope text-colegio-500 mr-1"></i> Usuario
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ph ph-user text-gray-400 text-lg"></i>
                </div>
                <input type="text" wire:model.debounce.500ms="username"
                    class="block w-full pl-10 pr-3 py-3 border @error('username') border-red-300 ring-1 ring-red-300 @else border-gray-300 @enderror rounded-xl focus:ring-colegio-500 focus:border-colegio-500 transition-colors shadow-sm bg-gray-50 focus:bg-white"
                    placeholder="correo@ejemplo.com">
            </div>
            @error('username')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="ph ph-warning-circle mr-1"></i> {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-2">
                <i class="ph ph-lock-key text-colegio-500 mr-1"></i> Contraseña
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="ph ph-lock text-gray-400 text-lg"></i>
                </div>
                <input type="password" wire:model.debounce.500ms="password"
                    class="block w-full pl-10 pr-3 py-3 border @error('password') border-red-300 ring-1 ring-red-300 @else border-gray-300 @enderror rounded-xl focus:ring-colegio-500 focus:border-colegio-500 transition-colors shadow-sm bg-gray-50 focus:bg-white"
                    placeholder="••••••••">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <i class="ph ph-warning-circle mr-1"></i> {{ $message }}
                </p>
            @enderror
        </div>

        @error('credentials')
            <div class="rounded-lg bg-red-50 p-4 border border-red-100 flex items-start">
                <div class="flex-shrink-0">
                    <i class="ph ph-x-circle text-red-400 text-xl"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ $message }}
                    </p>
                </div>
            </div>
        @enderror

        <div class="pt-2">
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-xl shadow-md text-base font-bold text-white bg-colegio-600 hover:bg-colegio-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-colegio-500 transition-all hover:shadow-lg transform hover:-translate-y-0.5 disabled:opacity-75 disabled:cursor-not-allowed">
                <span wire:loading.remove wire:target="submitForm">Ingresar al Sistema</span>
                <div wire:loading wire:loading.class="flex items-center" wire:target="submitForm">
                    <i class="ph ph-spinner animate-spin mr-2 text-xl"></i> Verificando...
                </div>
            </button>
        </div>
    </form>
</div>

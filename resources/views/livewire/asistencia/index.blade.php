<div class="w-[60%] py-10 bg-white border border-grey-300 flex relative rounded-lg shadow-3xl" x-data="reloj()" x-init="iniciarReloj()">
    <!-- Sección izquierda con foto y datos -->
    <div class="flex flex-col items-center justify-center w-1/2 border-r border-gray-300">
        <div class="w-[150px] h-[200px] bg-gray-200 mb-5 flex items-center justify-center border">
            @if($matricula && $alumno && !$profesor)
            <img src="{{ $alumno->foto ?? '' }}" alt="Foto Estudiante" class="object-cover w-full h-full">
            @elseif(!$matricula && $profesor)
            <img src="{{ $profesor->foto ?? '' }}" alt="Foto Estudiante" class="object-cover w-full h-full">
            @endif
        </div>
        @if($matricula && $alumno && !$profesor)
        <p class="text-xl font-bold text-center">{{ $alumno->nombre_completo ?? '--'}}</p>
        <p class="text-lg text-center">Grado: <span class="font-semibold">{{ $matricula->grado ?? '--' }}°</span></p>
        <p class="text-lg text-center">Nivel: <span class="font-semibold">{{ $matricula->nivel == 'P' ? 'PRIMARIA' : 'SECUNDARIA'  }}</span></p>
        @elseif(!$matricula && $profesor)
        <p class="text-xl font-bold text-center">{{ $profesor->nombres ?? '--'}}, {{ $profesor->apellidos ?? '--'}}</p>
        <p class="text-lg text-center"><span class="font-semibold">{{ $profesor->cargo }}</span></p>
        @endif
    </div>

    <!-- Sección derecha con logo y horas -->
    <div class="flex flex-col items-center justify-center w-1/2 px-8 space-y-3">
        <div class="w-[250px] mb-7 flex items-center justify-center">
            <img src="{{ asset('images/logo.png') }}" alt="Logo Institución" class="object-contain h-16">
        </div>
        <h3 class="text-2xl font-bold text-gray-600">{{ date('d/m/Y') }}</h3>
        <h1 class="pb-4 text-5xl font-bold text-gray-800" x-text="hora"></h1>

        @if(!$marcacion)
        <div class="px-6 py-3 text-lg font-semibold text-center bg-gray-200 rounded-lg">ENTRADA: --:--</div>
        <div class="px-6 py-3 text-lg font-semibold text-center bg-gray-200 rounded-lg">SALIDA: --:--</div>
        @else
        <div class="px-6 py-3 text-lg font-semibold text-center bg-gray-200 rounded-lg">ENTRADA: <span class="font-bold">{{ $marcacion->entrada | date:'h:i:s a' }}</span></div>
        @if($marcacion->tardanza_entrada)
        <div class="px-6 py-3 text-lg font-semibold text-red-500 rounded-lg bg-red-50">Llegó tarde: <span class="font-bold">{{ $marcacion->tardanza_entrada | timeForHumans }}</span></div>
        @else
        <div class="px-6 py-3 text-lg font-semibold text-green-500 rounded-lg bg-green-50">A tiempo</div>
        @endif
        @if($marcacion->salida)
        <div class="px-6 py-3 text-lg font-semibold text-center bg-gray-200 rounded-lg">SALIDA: <span class="font-bold">{{ $marcacion->salida | date:'h:i:s a' }}</span></div>
        @if($marcacion->salida_anticipada)
        <div class="px-6 py-3 text-lg font-semibold text-red-500 rounded-lg bg-red-50">Salió antes: <span class="font-bold">{{ $marcacion->salida_anticipada | timeForHumans }}</span></div>
        @else
        <div class="px-6 py-3 text-lg font-semibold text-green-500 rounded-lg bg-green-50">A tiempo</div>
        @endif
        @endif
        @endif
        
        @if(session()->has('error'))
        <div class="px-6 py-3 text-lg font-semibold text-red-500 rounded-lg bg-red-50"><span class="font-bold">{{ session()->get('error') }}</span></div>
        @endif
        
    </div>

    <form wire:submit.prevent="marcarAsistencia" class="absolute inset-0">
        <input type="text" wire:model.debounce.100="dni" class="absolute" autofocus>
    </form>

    {{-- <form wire:submit.prevent="marcarAsistencia" class="absolute inset-0 opacity-0">
        <input type="text" wire:model.debounce.100="dni" class="absolute" autofocus>
    </form> --}}
</div>

@push('js')
<script>
    function reloj() {
        return {
            hora: ''
            , iniciarReloj() {
                this.actualizarHora();
                setInterval(() => {
                    this.actualizarHora();
                }, 1000);

                Livewire.on('resetPage', () => {
                    setTimeout(() => {
                        Livewire.emit('reiniciar');
                    }, 60000);
                })

            }
            , actualizarHora() {
                const ahora = new Date();
                this.hora = ahora.toLocaleTimeString();
            }
        }
    }

</script>
@endpush

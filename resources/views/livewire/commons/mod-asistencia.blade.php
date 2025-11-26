<div class="mod-contable" x-data="items()">
    <div class="items-container">
        <div class="item-section @if($route == 'asistencias.index') item-section-active @endif" @click='goLink("{{ route('asistencias.index') }}")'>
            <div class="item-section-left">
                <img src="{{ asset('images/icons/calendario.svg') }}" />
            </div>
            <div class="item-section-right">
                <div class="titulo">Asistencias</div>
                <div class="subtitulo">Estudiantes</div>
            </div>
        </div>
        <div class="item-section @if($route == 'permisos-alumnos.index') item-section-active @endif" @click='goLink("{{ route('permisos-alumnos.index') }}")'>
            <div class="item-section-left">
                <img src="{{ asset('images/icons/checklist.png') }}" />
            </div>
            <div class="item-section-right">
                <div class="titulo">Permisos</div>
                <div class="subtitulo">Alumno</div>
            </div>
        </div>
        <div class="item-section @if($route == 'asistencias.profesores.index') item-section-active @endif" @click='goLink("{{ route('asistencias.profesores.index') }}")'>
            <div class="item-section-left">
                <img src="{{ asset('images/icons/checklist.png') }}" />
            </div>
            <div class="item-section-right">
                <div class="titulo">Asistencia</div>
                <div class="subtitulo">Personal</div>
            </div>
        </div>
        <div class="item-section @if($route == 'permisos-profesores.index') item-section-active @endif" @click='goLink("{{ route('permisos-profesores.index') }}")'>
            <div class="item-section-left">
                <img src="{{ asset('images/icons/checklist.png') }}" />
            </div>
            <div class="item-section-right">
                <div class="titulo">Permisos</div>
                <div class="subtitulo">Personal</div>
            </div>
        </div>

    </div>
</div>
@push('scripts')
<script>
    function items() {
        return {
            goLink(link) {
                window.location.href = link;
            }
        }
    }

</script>
@endpush

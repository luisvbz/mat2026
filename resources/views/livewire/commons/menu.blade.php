<div class="menu-principal" x-data="menuPrincipal()">
    <div class="menu-principal-logo">
        <img src="{{ asset('images/logo.png') }}" />
    </div>
    <div class="menu-principal-items">
        <ul>
            <li @click='goUrl("{{ route('dashboard.principal') }}")'
                class="item-menu  @if ($route == 'dashboard.principal') item-active @endif"><i class="fas fa-home"></i> Inicio
            </li>
            <li @click='goUrl("{{ route('dashboard.matriculas') }}")'
                class="item-menu @if ($route == 'dashboard.matriculas') item-active @endif"><i
                    class="fas fa-graduation-cap"></i> Matriculas</li>
            <li @click='goUrl("{{ route('dashboard.profesores') }}")'
                class="item-menu @if ($route == 'dashboard.profesores') item-active @endif"><i
                    class="fas fa-graduation-cap"></i> Profesores</li>
            <li @click='goUrl("{{ route('dashboard.comunicados') }}")'
                class="item-menu @if ($route == 'dashboard.comunicados') item-active @endif"><i class="fas fa-bullhorn"></i>
                Comunicados</li>
            <li @click='goUrl("{{ route('dashboard.contabilidad') }}")'
                class="item-menu @if ($route == 'dashboard.contabilidad') item-active @endif"><i class="fas fa-money-bill"></i>
                Contabilidad</li>
            <li @click='goUrl("{{ route('asistencias.index') }}")'
                class="item-menu @if ($route == 'asistencias.index') item-active @endif"><i class="fas fa-user-check"></i>
                Asistencias</li>
            <li @click='goUrl("{{ route('asistencias.inasistentes') }}")'
                class="item-menu @if ($route == 'asistencias.inasistentes') item-active @endif"><i
                    class="fas fa-calendar-day"></i> Inasistencias HOY</li>
            <li @click='goUrl("{{ route('dashboard.solicitudes') }}")'
                class="item-menu @if ($route == 'dashboard.solicitudes') item-active @endif"><i
                    class="fas fa-clipboard-check"></i> Solicitudes de Documentos</li>
            <li @click='goUrl("{{ route('dashboard.recordatorios') }}")'
                class="item-menu @if ($route == 'dashboard.recordatorios') item-active @endif"><i
                    class="fas fa-alarm-clock"></i> Recordatorios</li>
            @if ($isAdmin)
                <li @click='goUrl("{{ route('dashboard.configuracion') }}")'
                    class="item-menu  @if ($route == 'dashboard.configuracion') item-active @endif"><i class="fas fa-cogs"></i>
                    Configuración</li>
            @endif
            <li wire:click="logout" class="item-menu"><i class="fas fa-sign-out"></i> Cerrar Sesión</li>
        </ul>
    </div>
</div>
@push('scripts')
    <script>
        function menuPrincipal() {
            return {
                goUrl(url) {
                    window.location.href = url;
                }
            }
        }
    </script>
@endpush

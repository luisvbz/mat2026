<div class="header-nav"  x-data="{ open: false }">
    <div class="logo">
        <a href="{{ route('principal') }}"><img src="{{ asset('images/logo.png') }}"></a>
    </div>
    <div class="menu">
        <a class="menu-item" href="{{ route('principal') }}">Inicio</a>
    </div>
    <div class="menu-mobile-button">
        <a @click="open = true"><i class="fas fa-bars"></i></a>
    </div>
    <div class="menu-mobile-items" x-show="open">
        <div><a @click.away="open = false" class="item" href="{{ route('principal') }}">Inicio</a></div>
    </div>
</div>

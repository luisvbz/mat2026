<!DOCTYPE html >
<html lang="es">
<!--guiacomercial.pe -->
<head>
    <meta name="language" content="ES">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IEP "Divino Salvador" | Login</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/login-admin.css') }}">


    @stack('css')
    <livewire:styles/>

    <!-- JS Required -->
    <noscript><style> .global-container { display: none; }  </style></noscript>

</head>

<body>
<!-- No Javascript -->
<noscript>
    <div class="nojs">
        <div><h2><i class="fas fa-exclamation-triangle"></i> Advertencia</h2><div>Este sitio web requiere de Javascript.</div></div>
    </div>
</noscript>
<!-- Login container-->
<div class="global-container">
    <!-- Content -->
    <div class="content" id="content-box">
        @yield('content')
    </div>
    <!-- Footer -->

</div>

<!-- Scripts -->
<livewire:scripts/>

@stack('scripts')
</body>
</html>

<!DOCTYPE html >
<html lang="es">
<!--guiacomercial.pe -->
<head>
    <meta name="language" content="ES">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IEP "Divino Salvador" | Asistencia</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/asistencia.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" />


    @stack('css')
    <livewire:styles/>

    <!-- JS Required -->
    <noscript><style> .global-container { display: none; }  </style></noscript>

</head>

<body>
<div class="global-container">
    <!-- Content -->
    <div class="content" id="content-box">
        <div class="dashboard-container">

        </div>

    </div>
    <!-- Footer -->

</div>

<!-- Scripts -->
<livewire:scripts/>
<script src="{{ asset('js/globals.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script>
    const SwalModal = (icon, title, html) => {
        Swal.fire({
            icon,
            title,
            html
        })
    }

    const SwalAlert = (icon, title, timeout = 7000) => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: timeout,
            onOpen: toast => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon,
            title
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        Livewire.on('swal:modal', data => {
            SwalModal(data.icon, data.title, data.text)
        });

        Livewire.on('swal:alert', data => {
            SwalAlert(data.icon, data.title, data.timeout)
        });
    })
</script>
@stack('scripts')
</body>
</html>

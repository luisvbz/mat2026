<!DOCTYPE html>
<html lang="es">
<!--guiacomercial.pe -->

<head>
    <meta name="language" content="ES">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IEP "Divino Salvador" | Panel Administrador</title>
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard/detalle-matricula.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" />
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">


    @stack('css')
    <livewire:styles />

    <!-- JS Required -->
    <noscript>
        <style>
            .global-container {
                display: none;
            }
        </style>
    </noscript>

</head>

<body>
    <!-- No Javascript -->
    <noscript>
        <div class="nojs">
            <div>
                <h2><i class="fas fa-exclamation-triangle"></i> Advertencia</h2>
                <div>Este sitio web requiere de Javascript.</div>
            </div>
        </div>
    </noscript>
    <!-- Login container-->
    <div class="global-container">
        <!-- Content -->
        <div class="content" id="content-box">
            <div class="dashboard-container">
                <div class="left">
                    <livewire:commons.menu />
                </div>
                <div class="right">
                    <livewire:commons.header-dashboard />
                    @yield('content')
                </div>
            </div>

        </div>
        <!-- Footer -->

    </div>

    <!-- Scripts -->
    <livewire:scripts />
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
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

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
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.css') }}" />


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
    <script src="{{ asset('js/globals.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.js') }}"></script>
    <script>
        const SwalModal = (icon, title, html) => {
            Swal.fire({
                icon,
                title,
                html
            })
        }

        const SwalConfirm = (icon, title, html, confirmButtonText, method, params, callback) => {
            Swal.fire({
                icon,
                title,
                html,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText,
                reverseButtons: true,
            }).then(result => {
                if (result.value) {
                    return Livewire.emit(method, params)
                }

                if (callback) {
                    return Livewire.emit(callback)
                }
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


            Livewire.on('swal:confirm', data => {
                SwalConfirm(data.icon, data.title, data.text, data.confirmText, data.method, data.params,
                    data.callback)
            })
        })
    </script>

    @stack('scripts')
</body>

</html>

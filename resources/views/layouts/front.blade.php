<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> @yield('title') | IEP "Divino Salvador" | Matrícula 2026</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/front.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" />
    @livewireStyles
  </head>
  <body>
    <div class="global-container">
        <x-header/>
        <div class="content" id="content-box">
            @yield('content')
        </div>
    </div>
    @livewireScripts
    <script src="{{ asset('js/globals.js') }}"></script>
    @stack('js')
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
  </body>
</html>

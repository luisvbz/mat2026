<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="language" content="ES">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IEP "Divino Salvador" | Panel Administrador (Tailwind)</title>

    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        colegio: {
                            50: "#f7eaea",
                            100: "#eec5c4",
                            200: "#dc8b89",
                            300: "#c6544e",
                            400: "#9f2d27",
                            500: "#792321",
                            600: "#6E211F",
                            700: "#4b1917",
                            800: "#2f100e",
                            900: "#170807"
                        },
                        highlight: {
                            50: "#fbf3e7",
                            100: "#f7e3c8",
                            200: "#f3d4aa",
                            300: "#eec48b",
                            400: "#e8af6f",
                            500: "#DA9C64",
                            600: "#c58652",
                            700: "#a06a3d",
                            800: "#7c4f2a",
                            900: "#57371d"
                        }
                    }
                }
            }
        }
    </script>

    <!-- Icons & Third-party CSS -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.33.1/sweetalert2.css" />
    <link rel="stylesheet" href="https://unpkg.com/trix@2.0.8/dist/trix.css">

    @stack('css')
    <livewire:styles />

    <noscript>
        <style>
            .global-container {
                display: none;
            }
        </style>
    </noscript>
</head>

<body class="bg-gray-50 text-gray-800 font-sans antialiased overflow-hidden">
    <noscript>
        <div class="fixed inset-0 bg-red-100 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-xl text-center">
                <h2 class="text-2xl font-bold text-red-600 mb-2"><i class="fas fa-exclamation-triangle"></i> Advertencia
                </h2>
                <div class="text-gray-700">Este sitio web requiere de Javascript.</div>
            </div>
        </div>
    </noscript>

    <div class="global-container flex h-screen w-full">
        <!-- Sidebar Navigation -->
        <div class="w-64 flex-shrink-0 border-r border-gray-200 bg-white">
            <livewire:commons.tailwind-menu />
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-full overflow-hidden bg-gray-50">
            <!-- Header (Can also be replaced with a tailwind version later) -->
            <livewire:commons.header-dashboard />

            <!-- Dashboard View Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Scripts -->
    <livewire:scripts />
    <script src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    <script src="{{ asset('js/globals.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <!-- SweetAlert Handlers -->
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
            Livewire.on('swal:modal', data => SwalModal(data.icon, data.title, data.text));
            Livewire.on('swal:alert', data => SwalAlert(data.icon, data.title, data.timeout));
        })
    </script>
    @stack('scripts')
</body>

</html>

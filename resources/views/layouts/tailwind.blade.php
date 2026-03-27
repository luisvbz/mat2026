<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            scroll-behavior: smooth;
        }

        /* Premium Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #6E211F;
        }

        /* Glassmorphism Classes */
        .glass-card {
            background: rgba(255, 255, 255, 0.8) !important;
            backdrop-filter: blur(8px) !important;
            border: 1px solid rgba(255, 255, 255, 0.3) !important;
        }

        .premium-shadow {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.025);
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
        }

        /* Animations */
        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        .animate-slide-up {
            animation: slideUp 0.6s ease-out forwards;
        }

        /* Skeleton Animation */
        @keyframes shimmer {
            0% {
                background-position: -468px 0;
            }

            100% {
                background-position: 468px 0;
            }
        }

        .skeleton {
            background: #f6f7f8;
            background-image: linear-gradient(to right, #f6f7f8 0%, #edeef1 20%, #f6f7f8 40%, #f6f7f8 100%);
            background-repeat: no-repeat;
            background-size: 800px 104px;
            display: inline-block;
            position: relative;
            animation: shimmer 1.5s infinite linear;
        }
    </style>

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
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/pikaday/css/pikaday.css">
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

<body class="bg-gray-100 text-gray-800 font-sans antialiased overflow-hidden">
    <noscript>
        <div class="fixed inset-0 bg-red-100 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-xl text-center">
                <h2 class="text-2xl font-bold text-red-600 mb-2"><i class="fas fa-exclamation-triangle"></i> Advertencia
                </h2>
                <div class="text-gray-700">Este sitio web requiere de Javascript.</div>
            </div>
        </div>
    </noscript>

    <div x-data="{ sidebarOpen: false }" @sidebar-toggle.window="sidebarOpen = !sidebarOpen"
        class="global-container flex h-screen w-full relative overflow-hidden">
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" x-transition.opacity
            class="fixed inset-0 z-40 bg-gray-900/50 backdrop-blur-sm md:hidden" @click="sidebarOpen = false"
            style="display: none;"></div>

        <!-- Sidebar Navigation -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-64 transform bg-white border-r border-gray-200 transition-transform duration-300 ease-in-out md:relative md:translate-x-0 md:flex-shrink-0 flex flex-col h-full">
            <livewire:commons.tailwind-menu />
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-full overflow-hidden bg-gray-100 min-w-0 relative z-0">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/pikaday/pikaday.js"></script>
    <script>
        const SwalModal = (icon, title, html) => {
            Swal.fire({
                icon,
                title,
                html,
                confirmButtonColor: '#6E211F'
            })
        }

        const SwalAlert = (icon, title, timeout = 7000) => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: timeout,
                timerProgressBar: true,
                didOpen: (toast) => {
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
                Swal.fire({
                    title: data.title,
                    text: data.text,
                    icon: data.type,
                    showCancelButton: true,
                    confirmButtonColor: '#6E211F',
                    cancelButtonColor: '#d33',
                    confirmButtonText: data.confirmText,
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        Livewire.emit(data.method, data.params);
                    } else if (data.callback) {
                        Livewire.emit(data.callback);
                    }
                })
            });
        })
    </script>
    @stack('scripts')
</body>

</html>

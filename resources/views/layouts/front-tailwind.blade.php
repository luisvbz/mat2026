<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') | IEP "Divino Salvador" | Matrícula 2026</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/new-main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.0/css/pikaday.min.css"
        integrity="sha512-yFCbJ3qagxwPUSHYXjtyRbuo5Fhehd+MCLMALPAUar02PsqX3LVI5RlwXygrBTyIqizspUEMtp0XWEUwb/huUQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8b2724',
                        secondary: '#4a4a4a',
                        backgroundLight: '#f5f5f5',
                        contrast1: '#ffffff',
                        contrast2: '#f2c94c',
                        contrast3: 'oklch(82.8% 0.189 84.429)'
                    },
                    animation: {
                        'float': 'float 3s ease-in-out infinite',
                        'glow': 'glow 2s ease-in-out infinite alternate',
                        'slide-in': 'slideIn 0.5s ease-out',
                        'bounce-subtle': 'bounceSubtle 0.6s ease-out',
                        'gradient': 'gradient 15s ease infinite'
                    }
                }
            }
        }
    </script>
    @stack('css')

    @livewireStyles
</head>

<body class="min-h-screen pattern-bg relative">
    <!-- Formas decorativas flotantes -->
    <div class="floating-shapes">
        <div class="shape w-32 h-32 bg-primary rounded-full top-20 left-10 animate-float"></div>
        <div class="shape w-24 h-24 bg-contrast3 rounded-full top-40 right-20 animate-float"
            style="animation-delay: 1s;"></div>
        <div class="shape w-40 h-40 bg-contrast2 rounded-full bottom-32 left-1/4 animate-float"
            style="animation-delay: 2s;"></div>
        <div class="shape w-28 h-28 bg-secondary rounded-full bottom-20 right-1/3 animate-float"
            style="animation-delay: 0.5s;"></div>
    </div>

    <!-- Header -->
    <header class="glass-card sticky top-0 z-50 institutional-shadow">
        <div class="container mx-auto px-6 py-4">
            <nav class="flex items-center justify-between">
                <div class="flex items-center space-x-4 group">
                    <div>
                        <a href="{{ route('principal') }}"><img class="max-h-[50px]"
                                src="{{ asset('images/logo.png') }}"></a>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-6">

                    <a href="/"
                        class="bg-primary hover:bg-red-800 text-white px-6 py-2 rounded-lg transition-all duration-300 institutional-shadow hover:shadow-lg">
                        <i class="fas fa-home mr-2"></i>Inicio
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button class="md:hidden text-gray-700 hover:text-primary text-2xl transition-colors duration-300">
                    <i class="fas fa-bars"></i>
                </button>
            </nav>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-12">
        @yield('content')

    </main>

    <!-- Footer -->
    <footer class="mt-20 glass-card institutional-shadow">
        <div class="container mx-auto px-6 py-8">
            <div class="flex flex-col md:flex-row items-center justify-between">
                <div class="flex items-center space-x-4 mb-4 md:mb-0">
                    <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center institutional-shadow">
                        <i class="fas fa-graduation-cap text-white"></i>
                    </div>
                    <div>
                        <p class="text-gray-800 font-bold text-lg">Institución Educativa Privada</p>
                        <p class="text-primary font-semibold">Divino Salvador</p>
                    </div>
                </div>
                <div class="flex items-center space-x-6">
                    <a href="#" class="text-gray-500 hover:text-primary transition-colors duration-300 text-xl">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary transition-colors duration-300 text-xl">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="#" class="text-gray-500 hover:text-primary transition-colors duration-300 text-xl">
                        <i class="fas fa-envelope"></i>
                    </a>
                </div>
            </div>
            <div class="border-t border-gray-200 mt-6 pt-6 text-center">
                <p class="text-gray-500 text-sm">© 2026 Institución Educativa Privada Divino Salvador. Todos los
                    derechos reservados.</p>
            </div>
        </div>
    </footer>
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
    <script src="{{ asset('js/new-main.js') }}"></script>
</body>

</html>

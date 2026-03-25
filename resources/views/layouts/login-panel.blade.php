<!DOCTYPE html>
<html lang="es">

<head>
    <meta name="language" content="ES">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IEP "Divino Salvador" | Login Panel</title>

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

    <!-- Phosphor Icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

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

<body
    class="bg-gradient-to-br from-colegio-50 via-white to-highlight-50 text-gray-800 font-sans antialiased min-h-screen flex flex-col justify-center items-center">
    <!-- No Javascript -->
    <noscript>
        <div class="fixed inset-0 bg-red-100 flex items-center justify-center z-50">
            <div class="bg-white p-8 rounded-lg shadow-xl text-center">
                <h2 class="text-2xl font-bold text-red-600 mb-2">
                    <i class="ph ph-warning"></i> Advertencia
                </h2>
                <div class="text-gray-700">Este sitio web requiere de Javascript.</div>
            </div>
        </div>
    </noscript>

    <div class="global-container w-full max-w-md px-4">
        @yield('content')
    </div>

    <!-- Scripts -->
    <livewire:scripts />
    @stack('scripts')
</body>

</html>

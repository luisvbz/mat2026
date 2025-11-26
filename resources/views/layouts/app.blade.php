<!DOCTYPE html>
<html lang="es" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarjeta Estudiante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#9D2449',
                        secondary: '#393E46',
                        contrast: '#DBC2CF',
                        contrast2: '#9D8D8F',
                        contrast3: '#4A82A6',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <livewire:styles />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        /* Fondo en patrón */
        body {
            background-image: url(/images/pattern.jpg);
            background-repeat: repeat;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-50 antialiased">
    <div wire:loading.delay.longer>
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm">
            <div class="w-16 h-16 border-t-4 border-b-4 border-primary rounded-full animate-spin"></div>
        </div>
    </div>
    {{ $slot }}

    <livewire:scripts />
    @stack('js')
</body>

</html>

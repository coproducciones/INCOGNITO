<!DOCTYPE html>
<html lang="es" class="h-full">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Dashboard') -
        {{ config('app.name', 'Incognito') }}
    </title>

    {{-- Tailwind --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',

            theme: {
                extend: {

                    colors: {
                        brand: {
                            500: '#00c896',
                            600: '#00a87e',
                        },

                        dark: {
                            900: '#0a0a0a',
                            800: '#111111',
                            700: '#1a1a1a',
                            600: '#222222',
                        }
                    },

                    fontFamily: {
                        sans: [
                            'Inter',
                            'ui-sans-serif',
                            'system-ui',
                            'sans-serif'
                        ]
                    }
                }
            }
        }
    </script>

    {{-- Google Fonts --}}
    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    <style>

        [x-cloak] {
            display: none !important;
        }

        body {
            font-family:
                'Inter',
                ui-sans-serif,
                system-ui,
                sans-serif;
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            text-decoration: none;
        }

        .menu-item-active {
            background-color: #00c896;
            color: #000;
        }

        .menu-item-inactive {
            color: #9ca3af;
        }

        .menu-item-inactive:hover {
            background-color: #1a1a1a;
            color: #fff;
        }

        .menu-item-icon-active {
            color: #000;
        }

        .menu-item-icon-inactive {
            color: #6b7280;
        }

        .menu-item-text {
            font-size: 14px;
        }

        .menu-dropdown-item {
            display: flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .menu-dropdown-item-active {
            color: #00c896;
        }

        .menu-dropdown-item-inactive {
            color: #9ca3af;
        }

        .menu-dropdown-item-inactive:hover {
            color: #fff;
            background: #1a1a1a;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

    </style>

    @stack('styles')

</head>

<body class="h-full bg-dark-900 text-white antialiased">

    {{-- Contenedor principal --}}
    <div class="min-h-screen flex flex-col">

        {{-- Header --}}
        @include('layouts.app-header')

        {{-- Contenido --}}
        <main class="flex-1 p-4 sm:p-6 lg:p-8 bg-dark-900">

            {{-- Mensaje de éxito --}}
            @if (session('success'))

                <div class="mb-6 px-4 py-3 rounded-lg bg-brand-500/10 border border-brand-500/30 text-brand-500 text-sm">

                    {{ session('success') }}

                </div>

            @endif

            {{-- Mensaje de error --}}
            @if (session('error'))

                <div class="mb-6 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">

                    {{ session('error') }}

                </div>

            @endif

            {{-- Contenido de cada página --}}
            @yield('content')

        </main>

        {{-- Footer --}}
        @include('layouts.partials.footer')

    </div>

    {{-- Alpine.js --}}
    <script
        src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"
        defer
    ></script>

    {{-- Chart.js --}}
    <script
        src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"
    ></script>

    @stack('scripts')

</body>

</html>

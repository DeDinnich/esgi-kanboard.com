<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Kanboard')</title>

    @if (app()->environment('production'))
        @vite(['resources/js/app.js'], 'build')
    @else
        @vite(['resources/js/app.js'])
    @endif
</head>
<body class="font-sans bg-light text-dark">

    <div class="d-flex">
        {{-- Sidebar --}}
        @include('partials.dashboard.aside')

        <div class="flex-grow-1 d-flex flex-column min-vh-100">
            {{-- Header --}}
            @include('partials.dashboard.header')

            {{-- Contenu principal --}}
            <main class="flex-grow-1 p-4">
                @yield('content')
            </main>
        </div>
    </div>

    @yield('js')
</body>
</html>

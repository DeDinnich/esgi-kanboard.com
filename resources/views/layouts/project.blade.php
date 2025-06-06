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
<body class="font-cormorant">

    @include('partials.project.header')

    <main>
        @yield('content')
    </main>

    @yield('js')
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Kanboard')</title>
    <meta name="description" content="@yield('description', 'Kanboard - Votre solution de gestion de projets en ligne')">
    <meta name="author" content="@yield('author', 'Kanboard Team')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&display=swap" rel="stylesheet">

    @if (app()->environment('production'))
        @vite(['resources/js/app.js'], 'build')
    @else
        @vite(['resources/js/app.js'])
    @endif
</head>
<body class="font-cormorant">

    @include('partials.auth.header')

    <main>
        @yield('content')
    </main>

    @include('partials.auth.footer')

    @yield('js')
</body>
</html>

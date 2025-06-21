<header class="py-3 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="fw-bold fs-4 text-uppercase">
            KANBOARD
        </div>

        <div>
            @if (request()->routeIs('register'))
                <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
                <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
            @elseif (request()->routeIs('login'))
                <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
                <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
            @else
                <a href="{{ route('home') }}" class="btn btn-primary">Retour à l'accueil</a>
                <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
            @endif
        </div>
    </div>
</header>

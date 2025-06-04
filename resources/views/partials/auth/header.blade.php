<header class="py-3 border-bottom">
    <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}" class="fw-bold fs-4 text-dark text-decoration-none">
            <img src="{{ asset('images/logo.svg') }}" alt="Kanboard" height="30" class="me-2"> Kanboard
        </a>

        <div>
            @if (request()->routeIs('register'))
                <a href="{{ route('login') }}" class="btn btn-outline-primary">Se connecter</a>
            @elseif (request()->routeIs('login'))
                <a href="{{ route('register') }}" class="btn btn-outline-primary">S'inscrire</a>
            @else
                <a href="{{ route('home') }}" class="btn btn-secondary">Retour à l'accueil</a>
            @endif
        </div>
    </div>
</header>

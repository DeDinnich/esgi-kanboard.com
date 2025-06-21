<header class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom bg-light fixed-top-custom">
    <div class="fw-bold fs-4 text-uppercase">
        KANBOARD
    </div>

    <nav class="position-relative">
        <ul class="nav gap-4 align-items-center">
            <li class="nav-item dropdown position-relative">
                <a href="#accueil" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                    Accueil
                </a>
                <ul class="dropdown-menu position-absolute">
                    <li><a class="dropdown-item" href="/#">Accueil</a></li>
                    <li><a class="dropdown-item" href="/#solution">La solution Kanboard</a></li>
                    <li><a class="dropdown-item" href="/#contact">Prendre contact</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('about') }}" class="nav-link">À propos</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('prices') }}" class="nav-link">Nos tarifs</a>
            </li>
        </ul>
    </nav>

    <div class="d-flex gap-3">
        <a href="{{ route('register') }}" class="btn btn-primary">S'inscrire</a>
        <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
    </div>
</header>

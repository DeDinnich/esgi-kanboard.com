@php
    $user = Auth::user();
    $initials = strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1));
@endphp

<header class="dashboard-header d-flex justify-content-between align-items-center px-4 py-3 bg-white border-bottom shadow-sm">
    <div>
        <strong>Bienvenue {{ $user->first_name }} {{ $user->last_name }}</strong>
    </div>
    <div class="d-flex align-items-center gap-3 position-relative">
        {{-- Cloche --}}
        <div class="position-relative dropdown">
            <i class="fas fa-bell fa-lg cursor-pointer dropdown-toggle" role="button" data-bs-toggle="dropdown"></i>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li class="dropdown-header">Notifications</li>
                <li><a class="dropdown-item" href="#">Projet X : Machin a supprimé la carte "..." à 12h34</a></li>
                <li><a class="dropdown-item" href="#">Projet Y : Vous avez été ajouté à "Sprint Q3"</a></li>
            </ul>
        </div>

        {{-- Avatar avec menu --}}
        <div class="dropdown">
            <button class="btn btn-secondary rounded-circle fw-bold text-uppercase dropdown-toggle"
                data-bs-toggle="dropdown" style="width: 40px; height: 40px;">
                {{ $initials }}
            </button>
            <ul class="dropdown-menu shadow">
                <li><a class="dropdown-item" href="{{ route('profile') }}">Gérer le compte</a></li>

            <li class="dropstart">
                <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Thème</a>
                <ul class="dropdown-menu custom-dropdown-menu">
                    <li><a class="dropdown-item" href="#">Clair</a></li>
                    <li><a class="dropdown-item" href="#">Sombre</a></li>
                </ul>
            </li>

                <li class="dropstart">
                    <a class="dropdown-item dropdown-toggle" href="#" data-bs-toggle="dropdown">Langue</a>
                    <ul class="dropdown-menu custom-dropdown-menu">
                        <li><a class="dropdown-item" href="#">Français</a></li>
                        <li><a class="dropdown-item" href="#">Anglais</a></li>
                    </ul>
                </li>

                <li><a class="dropdown-item" href="#">Besoin d’aide</a></li>
                <li><hr class="dropdown-divider"></li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Se déconnecter</button>
                </form>
            </ul>
        </div>
    </div>
</header>

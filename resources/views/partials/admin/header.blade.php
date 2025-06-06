@php
    $user = Auth::user();
    $initials = strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1));
@endphp

<header class="dashboard-header d-flex justify-content-between align-items-center px-4 py-3 bg-white border-bottom shadow-sm">
    <div>
        <strong>Bienvenue sur l’espace administrateur {{ $user->first_name }} {{ $user->last_name }}</strong>
        <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary ms-3">
            <i class="fas fa-arrow-left me-1"></i> Retour à l’espace utilisateur
        </a>
    </div>
    <div class="d-flex align-items-center gap-3 position-relative">
        {{-- Avatar avec menu --}}
        <div class="dropdown">
            <button class="btn btn-secondary rounded-circle fw-bold text-uppercase dropdown-toggle"
                data-bs-toggle="dropdown" style="width: 40px; height: 40px;">
                {{ $initials }}
            </button>
            <ul class="dropdown-menu shadow">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">Se déconnecter</button>
                </form>
            </ul>
        </div>
    </div>
</header>

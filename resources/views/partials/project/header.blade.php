<header class="d-flex justify-content-between align-items-center px-4 py-3 border-bottom bg-white">
    <div class="fw-bold fs-4 text-uppercase">
        <a href="{{ route('dashboard') }}" class="text-decoration-none text-dark">KANBOARD</a>
    </div>

    <div class="d-flex align-items-center gap-4">
        <h5 class="mb-0">{{ $project->nom ?? 'Projet' }}</h5>

        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#inviteMemberModal">
            <i class="fas fa-user-plus me-1"></i> Membres
        </button>

        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                Vue
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="{{ route('projects.show', $project->id) }}">Kanban</a></li>
                <li><a class="dropdown-item" href="{{ route('projects.showList', $project->id) }}">Liste</a></li>
                <li><a class="dropdown-item" href="{{ route('projects.showCalendar', $project->id) }}">Calendrier</a></li>
            </ul>
        </div>

        {{-- <button class="btn btn-sm btn-outline-secondary position-relative">
            <i class="fas fa-bell"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                3
                <span class="visually-hidden">notifications</span>
            </span>
        </button> --}}

        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary rounded-circle text-uppercase fw-bold" type="button" data-bs-toggle="dropdown">
                {{ strtoupper(substr(Auth::user()->first_name, 0, 1)) }}{{ strtoupper(substr(Auth::user()->last_name, 0, 1)) }}
            </button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Se déconnecter
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</header>

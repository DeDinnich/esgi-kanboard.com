<aside id="dashboard-aside" class="border-end d-flex flex-column shadow-sm transition-all" style="width: 260px; min-height: 100vh;">
    <div class="aside-top d-flex justify-content-between align-items-center p-3 border-bottom">
        <span id="aside-title" class="fw-bold fs-4">KANBOARD</span>
        <button id="toggle-sidebar" class="btn btn-sm btn-outline-secondary" title="Réduire">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <div class="p-3">
        <button class="btn btn-primary mb-4" data-bs-toggle="modal" data-bs-target="#createProjectModal">
            <span class="button-icon"><i class="fas fa-plus"></i></span>
            <span class="button-text"> Nouveau projet</span>
        </button>

        <h6 class="text-muted text-uppercase small mb-2">Mes projets</h6>
        <ul class="list-unstyled small mb-3" id="project-list">
            @forelse ($ownedProjects as $project)
                <li>
                    <a href="#{{-- route('projects.show', $project) --}}" class="d-block py-1">{{ $project->nom }}</a>
                </li>
            @empty
                <li class="text-muted">Aucun projet personnel</li>
            @endforelse
        </ul>

        <h6 class="text-muted text-uppercase small mb-2">Invitations</h6>
        <ul class="list-unstyled small mb-3">
            @forelse ($invitedProjects as $project)
                <li>
                    <a href="#{{-- route('projects.show', $project) --}}" class="d-block py-1">{{ $project->nom }}</a>
                </li>
            @empty
                <li class="text-muted">Aucune invitation</li>
            @endforelse
        </ul>

        <hr>

        <a href="#archivedCollapse" data-bs-toggle="collapse" class="text-muted small d-block mb-2">
            <i class="fas fa-box-archive me-1"></i> Projets archivés
        </a>
        <ul class="collapse list-unstyled small ps-3" id="archivedCollapse">
            @forelse ($archivedProjects as $project)
                <li>
                    <a href="#{{-- route('projects.show', $project) --}}" class="d-block py-1">{{ $project->nom }}</a>
                </li>
            @empty
                <li class="text-muted">Aucun projet archivé</li>
            @endforelse
        </ul>
    </div>

    <div id="aside-footer" class="mt-auto p-3 small text-muted">
        <div>&copy; {{ date('Y') }} Kanboard</div>
        <div>Créé par la team ESGI</div>
    </div>

    <div id="aside-expand" class="mt-auto d-none p-3 text-center">
        <button class="btn btn-sm btn-outline-secondary" title="Agrandir" id="expand-sidebar">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</aside>

<aside id="dashboard-aside" class="bg-white border-end d-flex flex-column shadow-sm transition-all" style="width: 260px; min-height: 100vh;">
    <div class="aside-top d-flex justify-content-between align-items-center p-3 border-bottom">
        <span id="aside-title" class="fw-bold fs-4">KANBOARD</span>
        <button id="toggle-sidebar" class="btn btn-sm btn-outline-secondary" title="Réduire">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <div class="p-3">

        <h6 class="text-muted text-uppercase small mb-2">Gestion</h6>
        <ul class="list-unstyled small mb-3" id="project-list">
            <li><a href="{{ route('admin.dashboard') }}" class="d-block py-1"><i class="fas fa-tachometer-alt me-1"></i> Tableau de bord</a></li>
            <li><a href="{{ route('admin.users') }}" class="d-block py-1"><i class="fas fa-user me-1"></i> Utilisateurs</a></li>
            <li><a href="{{ route('admin.subscriptions') }}" class="d-block py-1"><i class="fas fa-crown me-1"></i> Abonnements</a></li>
            <li><a href="{{ route('admin.projects') }}" class="d-block py-1"><i class="fas fa-folder me-1"></i> Projets</a></li>
            <li><a href="{{ route('admin.columns') }}" class="d-block py-1"><i class="fas fa-columns me-1"></i> Colonnes</a></li>
            <li><a href="{{ route('admin.tasks') }}" class="d-block py-1"><i class="fas fa-tasks me-1"></i> Tâches</a></li>
            <li><a href="{{ route('admin.project_collaborators') }}" class="d-block py-1"><i class="fas fa-users me-1"></i> Collab. Projets</a></li>
            <li><a href="{{ route('admin.task_collaborators') }}" class="d-block py-1"><i class="fas fa-user-friends me-1"></i> Collab. Tâches</a></li>
        </ul>

    </div>

    {{-- Footer complet visible en mode large --}}
    <div id="aside-footer" class="mt-auto p-3 small text-muted">
        <div>&copy; {{ date('Y') }} Kanboard</div>
        <div>Créé par la team ESGI</div>
    </div>

    {{-- Chevron seul visible en mode réduit --}}
    <div id="aside-expand" class="mt-auto d-none p-3 text-center">
        <button class="btn btn-sm btn-outline-secondary" title="Agrandir" id="expand-sidebar">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</aside>

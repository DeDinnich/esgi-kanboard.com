<aside id="dashboard-aside" class="bg-white border-end d-flex flex-column shadow-sm transition-all" style="width: 260px; min-height: 100vh;">
    <div class="aside-top d-flex justify-content-between align-items-center p-3 border-bottom">
        <span id="aside-title" class="fw-bold fs-4">KANBOARD</span>
        <button id="toggle-sidebar" class="btn btn-sm btn-outline-secondary" title="Réduire">
            <i class="fas fa-chevron-left"></i>
        </button>
    </div>

    <div class="p-3">
        <button class="btn btn-primary w-100 mb-3" id="new-project-button">
            <span class="button-icon"><i class="fas fa-plus"></i></span>
            <span class="button-text"> Nouveau projet</span>
        </button>

        <h6 class="text-muted text-uppercase small mb-2">Mes projets</h6>
        <ul class="list-unstyled small mb-3" id="project-list">
            <li><a href="#" class="d-block py-1">Projet 1</a></li>
            <li><a href="#" class="d-block py-1">Projet 2</a></li>
            <li><a href="#" class="d-block py-1">Projet 3</a></li>
            <li><a href="#" class="d-block py-1">Projet 4</a></li>
            <li><a href="#" class="d-block py-1">Projet 5</a></li>
            <li><a href="#" class="text-primary small"><i class="fas fa-chevron-down me-1"></i>Voir plus</a></li>
        </ul>

        <hr>

        <div>
            <a href="#archivedCollapse" data-bs-toggle="collapse" class="text-muted small d-block mb-2">
                <i class="fas fa-box-archive me-1"></i> Mes projets archivés
            </a>
            <ul class="collapse list-unstyled small ps-3" id="archivedCollapse">
                <li><a href="#" class="d-block py-1">Projet Archivé A</a></li>
                <li><a href="#" class="d-block py-1">Projet Archivé B</a></li>
            </ul>
        </div>
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

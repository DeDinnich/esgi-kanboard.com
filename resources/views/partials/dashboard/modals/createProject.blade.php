<!-- Modal Création Projet -->
<div class="modal fade" id="createProjectModal" tabindex="-1" aria-labelledby="createProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-3">
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createProjectModalLabel">Créer un nouveau projet</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom du projet</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Créer</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </form>
        </div>
    </div>
</div>

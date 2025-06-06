<div class="modal fade" id="createColumnModal" tabindex="-1" aria-labelledby="createColumnModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('columns.store') }}" method="POST" class="modal-content">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}">
            <div class="modal-header">
                <h5 class="modal-title" id="createColumnModalLabel">Créer une colonne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="column_name" class="form-label">Nom</label>
                    <input type="text" name="nom" class="form-control" id="column_name" required>
                </div>
                <div class="mb-3">
                    <label for="column_order" class="form-label">Ordre</label>
                    <input type="number" name="order" class="form-control" id="column_order" required min="1">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Ajouter</button>
            </div>
        </form>
    </div>
</div>

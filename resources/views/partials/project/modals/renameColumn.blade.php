<div class="modal fade" id="renameColumnModal-{{ $column->id }}" tabindex="-1" aria-labelledby="renameColumnLabel-{{ $column->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('columns.rename', $column) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="renameColumnLabel-{{ $column->id }}">Renommer la colonne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nom actuel</label>
                    <input type="text" class="form-control" value="{{ $column->nom }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nouveau nom</label>
                    <input type="text" class="form-control" name="nom" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Renommer</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="moveColumnModal-{{ $column->id }}" tabindex="-1" aria-labelledby="moveColumnLabel-{{ $column->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('columns.move', $column) }}" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title" id="moveColumnLabel-{{ $column->id }}">Déplacer la colonne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Position actuelle</label>
                    <input type="number" class="form-control" value="{{ $column->order }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nouvel ordre</label>
                    <input type="number" class="form-control" name="order" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Déplacer</button>
            </div>
        </form>
    </div>
</div>

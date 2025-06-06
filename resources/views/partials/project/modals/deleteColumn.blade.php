<div class="modal fade" id="deleteColumnModal-{{ $column->id }}" tabindex="-1" aria-labelledby="deleteColumnLabel-{{ $column->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('columns.delete', $column) }}" class="modal-content">
            @csrf
            @method('DELETE')
            <div class="modal-header">
                <h5 class="modal-title" id="deleteColumnLabel-{{ $column->id }}">Supprimer la colonne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <p>Êtes-vous sûr de vouloir supprimer cette colonne ?</p>
                <p class="text-danger">Toutes les tâches associées seront également supprimées.</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Confirmer</button>
            </div>
        </form>
    </div>
</div>

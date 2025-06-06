<div class="modal fade" id="restoreUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="restoreUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.restore', $user->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="restoreUserModalLabel{{ $user->id }}">Confirmer la restauration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment restaurer cet utilisateur ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-success">Restaurer</button>
                </div>
            </form>
        </div>
    </div>
</div>

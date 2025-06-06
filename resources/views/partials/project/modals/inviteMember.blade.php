<div class="modal fade" id="inviteMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('projects.invite', $project) }}">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Inviter un membre</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @include('components.alerts')

                <div class="mb-3">
                    <label class="form-label">Email de l'utilisateur</label>
                    <input type="email" name="email" class="form-control" placeholder="ex: user@example.com" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Envoyer l’invitation</button>
            </div>
        </form>
    </div>
</div>

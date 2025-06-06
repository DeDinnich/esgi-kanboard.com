    <div class="modal fade" id="changePasswordModal{{ $user->id }}" tabindex="-1" aria-labelledby="changePasswordModalLabel{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel{{ $user->id }}">Changer le mot de passe</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                        <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="admin" value="{{ $user->admin }}">
                        <input type="hidden" name="subscription_id" value="{{ $user->subscription_id }}">

                        <div class="mb-3 position-relative">
                            <label class="form-label">Nouveau mot de passe</label>
                            <input type="password" name="password" class="form-control" required id="change_password_{{ $user->id }}">
                            <i class="fa fa-eye position-absolute end-0 translate-middle-y pe-3 cursor-pointer toggle-password" data-target="#change_password_{{ $user->id }}" style="top: 70%"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <label class="form-label">Confirmer le mot de passe</label>
                            <input type="password" name="password_confirmation" class="form-control" required id="change_password_confirm_{{ $user->id }}">
                            <i class="fa fa-eye position-absolute end-0 translate-middle-y pe-3 cursor-pointer toggle-password" data-target="#change_password_confirm_{{ $user->id }}" style="top: 70%"></i>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

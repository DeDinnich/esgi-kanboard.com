<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Créer un utilisateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Prénom</label>
                        <input type="text" name="first_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nom</label>
                        <input type="text" name="last_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required id="create_password">
                        <i class="fa fa-eye position-absolute end-0 translate-middle-y pe-3 cursor-pointer toggle-password" data-target="#create_password" style="top: 70%"></i>
                    </div>
                    <div class="mb-3 position-relative">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="form-control" required id="create_password_confirm">
                        <i class="fa fa-eye position-absolute end-0 translate-middle-y pe-3 cursor-pointer toggle-password" data-target="#create_password_confirm" style="top: 70%"></i>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Abonnement</label>
                        <select name="subscription_id" class="form-select">
                            @foreach($subscriptions as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="admin" value="1" id="adminCheck">
                        <label class="form-check-label" for="adminCheck">Administrateur</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-primary">Créer</button>
                </div>
            </form>
        </div>
    </div>
</div>

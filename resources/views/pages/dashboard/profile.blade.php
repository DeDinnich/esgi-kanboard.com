@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mon profil</h2>

    <form id="profile-form" method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="first_name" class="form-label">Prénom</label>
                <input type="text" name="first_name" id="first_name" class="form-control" value="{{ Auth::user()->first_name }}" disabled>
            </div>
            <div class="col-md-6">
                <label for="last_name" class="form-label">Nom</label>
                <input type="text" name="last_name" id="last_name" class="form-control" value="{{ Auth::user()->last_name }}" disabled>
            </div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Adresse email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ Auth::user()->email }}" disabled>
        </div>

        <div class="d-flex gap-2 flex-wrap">
            <button type="button" class="btn btn-primary" id="edit-profile-btn">Modifier mes infos personnelles</button>
            <a href="{{ route('password.ask') }}" class="btn btn-warning">Réinitialiser mon mot de passe</a>
            <button type="button" class="btn btn-danger" disabled>Supprimer mon compte</button>
        </div>
    </form>
</div>
@endsection

@section('js')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const editBtn = document.getElementById('edit-profile-btn');
    const form = document.getElementById('profile-form');
    let isEditing = false;

    editBtn.addEventListener('click', () => {
        const inputs = form.querySelectorAll('input');

        if (!isEditing) {
            inputs.forEach(input => input.disabled = false);
            editBtn.textContent = 'Valider les modifications';
            isEditing = true;
        } else {
            form.submit();
        }
    });
});
</script>
@endsection

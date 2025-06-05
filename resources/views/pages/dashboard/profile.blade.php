@extends('layouts.dashboard')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Mon profil</h2>

    <form id="profile-form" method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Prénom</label>
                <input type="text" name="first_name" class="form-control" value="{{ $user->first_name }}" disabled>
            </div>
            <div class="col-md-6">
                <label class="form-label">Nom</label>
                <input type="text" name="last_name" class="form-control" value="{{ $user->last_name }}" disabled>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Adresse email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" disabled>
        </div>

        @include('components.alerts')

        <div class="row my-4">
            <div class="col-md-6">
                <button type="button" class="btn btn-primary w-100" id="edit-profile-btn">
                    Modifier mes infos personnelles
                </button>
            </div>
            <div class="col-md-6">
                <a href="{{ route('password.ask') }}" class="btn btn-warning w-100">Réinitialiser mon mot de passe</a>
            </div>
        </div>
    </form>



    @include('components.dashboard.profile.cards', [
        'plans' => $plans,
        'featuresList' => $featuresList,
        'activePlanId' => $activePlan?->id
    ])

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

    document.querySelectorAll('.choose-plan').forEach(button => {
        button.addEventListener('click', function () {
            const planId = this.dataset.planId;
            const alertBox = document.getElementById('alert-' + planId);
            alertBox.classList.remove('d-none');
        });
    });
});
</script>
@endsection

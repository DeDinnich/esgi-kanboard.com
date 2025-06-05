@extends('layouts.auth')

@section('title', 'Inscription')

@section('content')
<div class="container my-5" style="max-width: 500px;">
    <h1 class="mb-4">Créer un compte</h1>
    <form class="mb-3" method="POST" action="{{ route('register.post') }}">
        @csrf
        <div class="mb-3">
            <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
        </div>
        <div class="mb-3">
            <input type="text" name="nom" class="form-control" placeholder="Nom" required>
        </div>
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3 position-relative">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required id="register_password">
            <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" onclick="togglePassword('register_password', this)"></i>
        </div>
        <div class="mb-3 position-relative">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required id="confirm_password">
            <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" onclick="togglePassword('confirm_password', this)"></i>
        </div>
        <button type="submit" class="btn btn-primary w-100">Créer mon compte</button>
    </form>
    @include('components.alerts')
</div>
@endsection

@section('js')
<script>
function togglePassword(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('fa-eye-slash');
}
</script>
@endsection

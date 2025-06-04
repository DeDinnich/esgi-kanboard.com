@extends('layouts.auth')

@section('title', 'Connexion')

@section('content')
<div class="container my-5" style="max-width: 500px;">
    <h1 class="mb-4">Connexion</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="mb-3 position-relative">
            <input type="password" name="password" class="form-control" placeholder="Mot de passe" required id="login_password">
            <i class="fas fa-eye position-absolute top-50 end-0 translate-middle-y me-3 cursor-pointer" onclick="togglePassword('login_password', this)"></i>
        </div>
        <div class="mb-3 text-end">
            <a href="{{ route('password.ask') }}" class="small text-decoration-none">Mot de passe oublié ?</a>
        </div>
        <button type="submit" class="btn btn-primary w-100">Se connecter</button>
    </form>
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

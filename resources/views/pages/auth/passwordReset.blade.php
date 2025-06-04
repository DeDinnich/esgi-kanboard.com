@extends('layouts.auth')

@section('title', 'Définir un nouveau mot de passe')

@section('content')
<div class="container my-5" style="max-width: 500px;">
    <h1 class="mb-4">Nouveau mot de passe</h1>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <input type="password" name="password" class="form-control" placeholder="Nouveau mot de passe" required>
        </div>
        <div class="mb-3">
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirmer le mot de passe" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Réinitialiser</button>
    </form>
</div>
@endsection

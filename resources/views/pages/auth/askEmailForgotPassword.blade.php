@extends('layouts.auth')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="container my-5" style="max-width: 500px; min-height: 82vh;">
    <h1 class="mb-4">Réinitialiser le mot de passe</h1>
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <input type="email" name="email" class="form-control" placeholder="Votre adresse email" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-3">Envoyer le lien</button>
    </form>
    @include('components.alerts')
</div>
@endsection

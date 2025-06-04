@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('content')
    <h1 class="mb-4">Bienvenue sur votre tableau de bord, {{ Auth::user()->first_name }} 👋</h1>

    <p class="lead">Vous pouvez ici accéder à vos projets, visualiser vos tâches et gérer vos préférences.</p>
@endsection

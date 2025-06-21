@extends('layouts.landing')

@section('title', 'À propos de Kanboard')
@section('description', 'Découvrez Kanboard, la solution de gestion de projets intuitive pour les équipes de toutes tailles.')

@section('content')
    <div class="container">
        <div class="text-center mb-5" style="margin-top: 8rem;">
            <h1 class="fw-bold">À propos</h1>
            <p class="lead">Découvrez l'histoire et la mission derrière Kanboard</p>
        </div>
        @include('components.landing.about.content')
    </div>
@endsection

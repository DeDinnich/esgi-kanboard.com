@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('content')
    <h1 class="mb-4">Bienvenue sur votre tableau de bord, {{ Auth::user()->first_name }} 👋</h1>
    <p class="lead">Vous pouvez ici accéder à vos projets, visualiser vos tâches et gérer vos préférences.</p>

    @include('components.alerts')

    <div class="mb-5">
        <h3 class="mb-3">Vos projets</h3>
        <div class="row">
            @forelse ($ownedProjects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->nom }}</h5>
                            <p class="card-text text-muted">Créé le {{ $project->created_at->format('d/m/Y') }}</p>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-primary">Voir le projet</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Aucun projet personnel pour l’instant.</p>
            @endforelse
        </div>
    </div>

    <div>
        <h3 class="mb-3">Projets où vous êtes invité</h3>
        <div class="row">
            @forelse ($invitedProjects as $project)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100 border-info">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->nom }}</h5>
                            <p class="card-text text-muted">Créé le {{ $project->created_at->format('d/m/Y') }}</p>
                            <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">Voir le projet</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">Vous n’êtes membre d’aucun projet externe.</p>
            @endforelse
        </div>
    </div>

    @include('partials.dashboard.modals.createProject')
@endsection

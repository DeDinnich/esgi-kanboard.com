@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('content')
    <h1 class="mb-4">Bienvenue sur votre tableau de bord, {{ Auth::user()->first_name }} 👋</h1>
    <p class="lead">Vous pouvez ici accéder à vos projets, visualiser vos tâches et gérer vos préférences.</p>

    <div class="row">
        @forelse ($projects as $project)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $project->nom }}</h5>
                        <p class="card-text text-muted">
                            Créé le {{ $project->created_at->format('d/m/Y') }}
                        </p>
                        <a href="{{-- route('projects.show', $project) --}}" class="btn btn-sm btn-primary">Voir le projet</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Vous n’avez encore aucun projet actif.</div>
            </div>
        @endforelse
    </div>
@endsection

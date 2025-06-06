@extends('layouts.project')

@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0">Tâches du projet : {{ $project->nom }}</h3>
            <a href="{{ route('projects.show', $project) }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Retour au Kanban
            </a>
        </div>

        @include('components.alerts')

        @include('components.project.taskTable', ['project' => $project])
    </div>
@endsection

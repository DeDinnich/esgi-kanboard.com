@extends('layouts.admin')

@section('title', 'Gestion des Task Collaborators')

@section('content')
    <h2 class="mb-4">Gestion des Task Collaborators</h2>

    @include('components.admin.manageTaskCollaborators.table', [
        'columns' => ['ID', 'Tâche', 'Utilisateur', 'Actions']
    ])
@endsection

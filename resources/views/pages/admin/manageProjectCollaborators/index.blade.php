@extends('layouts.admin')

@section('title', 'Gestion des ProjectCollaborators')

@section('content')
    <h2 class="mb-4">Gestion des ProjectCollaborators</h2>

    @include('components.admin.manageProjectCollaborators.table', [
        'columns' => ['ID', 'Projet', 'Utilisateur', 'Actions']
    ])
@endsection

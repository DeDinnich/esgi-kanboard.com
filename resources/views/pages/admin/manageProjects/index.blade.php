@extends('layouts.admin')

@section('title', 'Gestion des projects')

@section('content')
    <h2 class="mb-4">Gestion des projects</h2>

    @include('components.admin.manageProjects.table', [
        'columns' => ['ID', 'Nom', 'Créé par', 'Archivé', 'Actions']
    ])
@endsection

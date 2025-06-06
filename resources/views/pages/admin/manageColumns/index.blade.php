@extends('layouts.admin')

@section('title', 'Gestion des colonnes')

@section('content')
    <h2 class="mb-4">Gestion des colonnes</h2>

    @include('components.admin.manageColumns.table', [
        'columns' => ['ID', 'Nom', 'Projet', 'Ordre', 'Actions']
    ])
@endsection

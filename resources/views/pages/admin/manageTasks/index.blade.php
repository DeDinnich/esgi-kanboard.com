@extends('layouts.admin')

@section('title', 'Gestion des Tasks')

@section('content')
    <h2 class="mb-4">Gestion des tasks</h2>

    @include('components.admin.manageTasks.table', [
        'columns' => ['ID', 'Nom', 'Colonne', 'Priorité', 'État', 'Actions']
    ])
@endsection

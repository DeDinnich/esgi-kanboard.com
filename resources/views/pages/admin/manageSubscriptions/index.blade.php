@extends('layouts.admin')

@section('title', 'Gestion des Subscriptions')

@section('content')
    <h2 class="mb-4">Gestion des Subscriptions</h2>

    @include('components.admin.manageSubscriptions.table', [
        'columns' => ['ID', 'Nom', 'Email', 'Admin', 'Statut', 'Actions']
    ])
@endsection

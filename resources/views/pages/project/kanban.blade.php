@extends('layouts.project')

@section('title', $project->nom)

@section('content')
    <div class="container py-4">
        <h2 class="mb-4">Vue Kanban du projet : {{ $project->nom }}</h2>

        @include('components.alerts')
        @include('components.project.kanbanBoard', ['columns' => $project->columns])
        @include('partials.project.modals.inviteMember', ['project' => $project])
    </div>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
@endsection

@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <h2 class="mb-4">Statistiques générales</h2>

    <div class="row g-4">
        <div class="col-md-4">
            @include('components.admin.stats.userCount')
        </div>
        <div class="col-md-4">
            @include('components.admin.stats.projectCount')
        </div>
        <div class="col-md-4">
            @include('components.admin.stats.taskCount')
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-md-6">
            @include('components.admin.stats.subscriptionDistribution')
        </div>
        <div class="col-md-6">
            @include('components.admin.stats.taskCompletionRatio')
        </div>
    </div>
@endsection

@section('js')
    {{-- Injection des variables JS pour les graphiques --}}
    <script>
        const userLabels = {!! $userLabels !!};
        const userData = {!! $userData !!};

        const projectLabels = {!! $projectLabels !!};
        const projectData = {!! $projectData !!};

        const taskLabels = {!! $taskLabels !!};
        const taskData = {!! $taskData !!};

        const subLabels = {!! $subLabels !!};
        const subData = {!! $subData !!};

        const completionLabels = {!! $completionLabels !!};
        const completionData = {!! $completionData !!};
    </script>
@endsection

@extends('layouts.project')

@section('title', $project->nom . ' - Calendrier')

@section('content')
@include('partials.project.modals.inviteMember', ['project' => $project])
<div class="container-fluid mt-3">
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-3">
            <div class="d-flex gap-2 align-items-center">
                <h5 class="mb-0" id="calendar-month-label">...</h5>

                <button class="btn btn-outline-secondary" id="calendar-prev">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <button class="btn btn-outline-secondary" id="calendar-next">
                    <i class="fas fa-chevron-right"></i>
                </button>

                <select id="calendar-view-mode" class="form-select">
                    <option value="month" selected>Mois</option>
                    <option value="week">Semaine</option>
                    <option value="3days">3 jours</option>
                    <option value="day">Jour</option>
                </select>
            </div>

            <button class="btn btn-primary" id="calendar-sync-btn">
                <i class="fas fa-sync-alt me-1"></i> Synchroniser mon calendrier
            </button>
        </div>

        <div class="card-body" id="calendar-container">
            <!-- Le calendrier sera injecté ici en JS -->
        </div>
    </div>
</div>
@endsection

@extends('layouts.landing')

@section('title', 'Accueil - Kanboard')
@section('description', 'Kanboard est votre nouvelle solution de gestion de projet visuelle et collaborative.')
@section('keywords', 'kanban, gestion de projet, kanboard, organisation, travail en équipe')
@section('author', 'Kanboard Team')

@section('content')

    {{-- Bannière --}}
    @include('components.landing.index.banner')

    {{-- Chiffres clés --}}
    @include('components.landing.index.keyNumbers')

    {{-- Contenu principal --}}
    @include('components.landing.index.content')

    {{-- Formulaire de contact --}}
    @include('components.landing.index.contact')

@endsection

@section('js')
    {{-- Scripts spécifiques à la page d'accueil --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Init animations ou comportement JS si besoin
        });
    </script>
@endsection

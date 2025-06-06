@extends('layouts.admin')

@section('title', 'Gestion des Utilisateurs')

@section('content')
    <h2 class="mb-4">Gestion des Utilisateurs</h2>

    @include('components.alerts')

    <div class="d-flex justify-content-between mb-3">
        <input type="text" id="searchInput" class="form-control w-50" placeholder="Rechercher par prénom ou nom...">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            <i class="fas fa-user-plus me-1"></i> Créer un utilisateur
        </button>
    </div>

    <div id="usersTable">
        @include('components.admin.manageUsers.table', ['users' => $users])
    </div>
@endsection

@section('js')
    <script>
        function bindDynamicUserEvents() {
            document.querySelectorAll('.toggle-password').forEach(eye => {
                eye.addEventListener('click', () => {
                    const input = document.querySelector(eye.dataset.target);
                    if (!input) return;

                    if (input.type === 'password') {
                        input.type = 'text';
                        eye.classList.remove('fa-eye');
                        eye.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        eye.classList.remove('fa-eye-slash');
                        eye.classList.add('fa-eye');
                    }
                });
            });

            // Rebind Bootstrap modal events if needed (optionnel)
            // Bootstrap modals fonctionnent par data-bs-toggle, pas besoin de JS ici
        }

        // Initial binding
        bindDynamicUserEvents();

        // On recherche dynamique
        document.getElementById('searchInput').addEventListener('input', function () {
            const query = this.value;
            fetch(`{{ route('admin.users.search') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.text())
                .then(html => {
                    document.getElementById('usersTable').innerHTML = html;
                    bindDynamicUserEvents(); // Important : re-binder les events sur nouveaux éléments
                });
        });
    </script>
@endsection

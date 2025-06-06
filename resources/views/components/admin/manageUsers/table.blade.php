<table class="table table-bordered table-striped align-middle">
    <thead class="table-light">
        <tr>
            <th>Prénom</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Admin</th>
            <th>Password</th>
            <th>Abonnement</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($users as $user)
            <tr class="{{ $user->trashed() ? 'table-warning' : '' }}">
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <input type="checkbox" disabled {{ $user->admin ? 'checked' : '' }}>
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-secondary"
                        data-bs-toggle="modal"
                        data-bs-target="#changePasswordModal{{ $user->id }}">
                        Modifier
                    </button>
                </td>
                <td>{{ $user->subscription->name ?? '—' }}</td>
                <td>
                    @if (!$user->trashed())
                        <button class="btn btn-sm btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal{{ $user->id }}">
                            Modifier
                        </button>
                        <button class="btn btn-sm btn-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteUserModal{{ $user->id }}">
                            Archiver
                        </button>
                    @else
                        <button class="btn btn-sm btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#restoreUserModal{{ $user->id }}">
                            Restaurer
                        </button>
                        <button class="btn btn-sm btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#hardDeleteUserModal{{ $user->id }}">
                            Supprimer
                        </button>
                    @endif
                </td>
            </tr>

            {{-- Modals individuels --}}
            @include('partials.admin.modals.manageUsers.edit', ['user' => $user])
            @include('partials.admin.modals.manageUsers.delete', ['user' => $user])
            @include('partials.admin.modals.manageUsers.restore', ['user' => $user])
            @include('partials.admin.modals.manageUsers.harddelete', ['user' => $user])
            @include('partials.admin.modals.manageUsers.changePassword', ['user' => $user])
        @empty
            <tr>
                <td colspan="7" class="text-center">Aucun utilisateur trouvé.</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $users->links() }}

{{-- Modal global pour création --}}
@include('partials.admin.modals.manageUsers.create')

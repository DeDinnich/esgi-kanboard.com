<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tâche</th>
            <th>Utilisateur</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($collaborators as $collab)
            <tr>
                <td>{{ $collab->id }}</td>
                <td>{{ $collab->task->nom ?? 'Inconnu' }}</td>
                <td>{{ $collab->user->email ?? 'Inconnu' }}</td>
                <td>
                    <form method="POST" action="{{ route('admin.task_collaborators.delete', $collab) }}" class="d-inline">@csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Colonne</th>
            <th>Priorité</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($tasks as $task)
            <tr class="{{ $task->trashed() ? 'table-warning' : '' }}">
                <td>{{ $task->id }}</td>
                <td>{{ $task->nom }}</td>
                <td>{{ $task->column->nom ?? 'N/A' }}</td>
                <td>{{ ucfirst($task->priority ?? '—') }}</td>
                <td>{{ $task->trashed() ? 'Archivée' : 'Active' }}</td>
                <td>
                    @if (!$task->trashed())
                        <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-primary">Modifier</a>
                        <form method="POST" action="{{ route('admin.tasks.delete', $task) }}" class="d-inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-warning">Archiver</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.tasks.restore', $task->id) }}" class="d-inline">@csrf
                            <button class="btn btn-sm btn-success">Restaurer</button>
                        </form>
                        <form method="POST" action="{{ route('admin.tasks.forceDelete', $task->id) }}" class="d-inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

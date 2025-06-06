<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Projet</th>
            <th>Ordre</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($columns as $col)
            <tr class="{{ $col->trashed() ? 'table-warning' : '' }}">
                <td>{{ $col->id }}</td>
                <td>{{ $col->nom }}</td>
                <td>{{ $col->project->nom ?? 'Inconnu' }}</td>
                <td>{{ $col->order }}</td>
                <td>
                    @if (!$col->trashed())
                        <a href="{{ route('admin.columns.edit', $col) }}" class="btn btn-sm btn-primary">Modifier</a>
                        <form method="POST" action="{{ route('admin.columns.delete', $col) }}" class="d-inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-warning">Archiver</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.columns.restore', $col->id) }}" class="d-inline">@csrf
                            <button class="btn btn-sm btn-success">Restaurer</button>
                        </form>
                        <form method="POST" action="{{ route('admin.columns.forceDelete', $col->id) }}" class="d-inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

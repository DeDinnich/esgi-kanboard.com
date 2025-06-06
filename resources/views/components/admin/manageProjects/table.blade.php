<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Créé par</th>
            <th>Statut</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($projects as $project)
            <tr class="{{ $project->trashed() ? 'table-warning' : '' }}">
                <td>{{ $project->id }}</td>
                <td>{{ $project->nom }}</td>
                <td>{{ $project->owner->email ?? 'inconnu' }}</td>
                <td>{{ $project->trashed() ? 'Archivé' : 'Actif' }}</td>
                <td>
                    @if (!$project->trashed())
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-sm btn-primary">Modifier</a>
                        <form method="POST" action="{{ route('admin.projects.delete', $project) }}" class="d-inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-warning">Archiver</button>
                        </form>
                    @else
                        <form method="POST" action="{{ route('admin.projects.restore', $project->id) }}" class="d-inline">@csrf
                            <button class="btn btn-sm btn-success">Restaurer</button>
                        </form>
                        <form method="POST" action="{{ route('admin.projects.forceDelete', $project->id) }}" class="d-inline">@csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger">Supprimer</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

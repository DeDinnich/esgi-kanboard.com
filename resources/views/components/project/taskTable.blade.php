@php
    $tasks = $project->columns->flatMap(fn($col) => $col->tasks);
    $colors = ['basse' => 'success', 'moyenne' => 'warning', 'elevée' => 'danger'];
@endphp

<div class="table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>Nom</th>
                <th>Colonne</th>
                <th>Priorité</th>
                <th>Membres</th>
                <th>Date limite</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tasks as $task)
                <tr>
                    <td>{{ $task->nom }}</td>
                    <td>{{ $task->column->nom }}</td>
                    <td>
                        <span class="badge bg-{{ $colors[strtolower($task->priority ?? 'basse')] ?? 'secondary' }}">
                            {{ ucfirst($task->priority ?? 'basse') }}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach ($task->collaborateurs as $user)
                                <span class="badge rounded-circle bg-primary text-white" title="{{ $user->first_name }} {{ $user->last_name }}">
                                    {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td>{{ optional($task->date_limite)->format('d/m/Y') ?? 'Non définie' }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal-{{ $task->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('tasks.destroy', $task) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>

                        @include('partials.project.modals.editTask', ['task' => $task, 'project' => $project])
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Aucune tâche disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

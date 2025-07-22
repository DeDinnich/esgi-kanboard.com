<div class="container-fluid overflow-auto py-3" style="white-space: nowrap;">
    <div class="d-flex flex-nowrap gap-3 mx-2">

        @forelse ($columns ?? [] as $column)
            <div class="card shadow-sm" style="min-width: 320px;">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span class="fw-bold">{{ $column->nom }}</span>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#renameColumnModal-{{ $column->id }}">Renommer</button></li>
                            <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#moveColumnModal-{{ $column->id }}">Déplacer</button></li>
                            <li><button class="dropdown-item text-danger" data-bs-toggle="modal" data-bs-target="#deleteColumnModal-{{ $column->id }}">Supprimer</button></li>
                        </ul>
                    </div>
                </div>

                <div class="card-body p-2">
                    @forelse ($column->tasks->sortBy('order') ?? [] as $task)
                        <div class="border rounded p-2 mb-2 bg-light">
                            <div class="d-flex align-items-center mb-1">
                                @php
                                    $colors = ['basse' => 'success', 'moyenne' => 'warning', 'élevée' => 'danger'];
                                    $priority = strtolower($task->priority ?? 'basse');
                                @endphp

                                <span class="badge bg-{{ $colors[$priority] ?? 'secondary' }}" data-bs-toggle="tooltip" title="Priorité : {{ ucfirst($priority) }}">
                                    ●
                                </span>

                                <span class="ms-2 text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" title="{{ $task->nom }} - {{ $task->description }}">
                                    {{ Str::limit($task->nom, 20) }}
                                </span>

                                <div class="ms-auto dropdown">
                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#viewTaskModal-{{ $task->id }}">Voir</button></li>
                                        <li><button class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editTaskModal-{{ $task->id }}">Modifier</button></li>
                                        <li>
                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Supprimer</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="d-flex flex-wrap gap-1 mt-1">
                                @foreach ($task->collaborateurs ?? [] as $user)
                                    <span class="badge rounded-circle bg-primary text-white" title="{{ $user->first_name }} {{ $user->last_name }}">
                                        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        @include('partials.project.modals.viewTask', ['task' => $task])
                        @include('partials.project.modals.editTask', ['task' => $task, 'project' => $project])
                    @empty
                        <div class="text-muted small">Aucune tâche.</div>
                    @endforelse

                    <button class="btn btn-sm btn-outline-primary w-100 mt-2" data-bs-toggle="modal" data-bs-target="#createTaskModal-{{ $column->id }}">
                        <i class="fas fa-plus me-1"></i> Nouvelle tâche
                    </button>
                </div>
            </div>

            @include('partials.project.modals.renameColumn', ['column' => $column])
            @include('partials.project.modals.moveColumn', ['column' => $column])
            @include('partials.project.modals.deleteColumn', ['column' => $column])
            @include('partials.project.modals.createTask', ['column' => $column, 'project' => $project])
        @empty
            <div class="card text-center border border-warning text-warning" style="min-width: 320px;">
                <div class="card-body">
                    Aucun tableau n’a été créé pour ce projet.
                </div>
            </div>
        @endforelse

        {{-- Bouton "Créer une colonne" --}}
        <div class="card h-100 d-flex justify-content-center align-items-center p-3 border border-dashed border-primary text-center" style="min-width: 320px;">
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#createColumnModal">
                <i class="fas fa-plus me-1"></i> Créer une colonne
            </button>
        </div>

        @include('partials.project.modals.createColumn', ['project' => $project])
    </div>
</div>

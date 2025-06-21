@php
    $collaborateursDispos = $project->collaborateurs->push($project->owner)->unique('id');
@endphp

<div class="modal fade" id="createTaskModal-{{ $column->id }}" tabindex="-1" aria-labelledby="createTaskLabel-{{ $column->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('tasks.store', ['column' => $column->id]) }}" class="modal-content">
            @csrf
            <input type="hidden" name="column_id" value="{{ $column->id }}">
            <input type="hidden" name="project_id" value="{{ $project->id }}">

            <div class="modal-header">
                <h5 class="modal-title" id="createTaskLabel-{{ $column->id }}">Créer une tâche</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="nom" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" name="order" class="form-control" value="1" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Priorité</label>
                    <select name="priority" class="form-select">
                        <option value="basse">Basse</option>
                        <option value="moyenne">Moyenne</option>
                        <option value="élevée">Élevée</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date limite</label>
                    <input type="date" class="form-control" name="date_limite">
                </div>

                <div class="mb-3">
                    <label class="form-label">Collaborateurs</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($collaborateursDispos as $user)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="collaborateurs[]" value="{{ $user->id }}" id="collab-create-{{ $column->id }}-{{ $user->id }}">
                                <label class="form-check-label" for="collab-create-{{ $column->id }}-{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Créer</button>
            </div>
        </form>
    </div>
</div>

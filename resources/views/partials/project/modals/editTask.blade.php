@php
    $collaborateursDispos = $project->collaborateurs->push($project->owner)->unique('id');
@endphp

<div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="{{ route('tasks.update', $task) }}">
            @csrf
            @method('PUT')

            <div class="modal-header">
                <h5 class="modal-title">Modifier la tâche</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" class="form-control" name="nom" value="{{ old('nom', $task->nom) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea class="form-control" name="description">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Ordre</label>
                    <input type="number" class="form-control" name="order" value="{{ old('order', $task->order) }}" min="1" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Date limite</label>
                    <input type="date" class="form-control" name="date_limite" value="{{ old('date_limite', optional($task->date_limite)->format('Y-m-d')) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Collaborateurs</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach ($collaborateursDispos as $user)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="collaborateurs[]" value="{{ $user->id }}"
                                    id="collab-{{ $task->id }}-{{ $user->id }}"
                                    {{ $task->collaborateurs->contains('id', $user->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="collab-{{ $task->id }}-{{ $user->id }}">
                                    {{ $user->first_name }} {{ $user->last_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

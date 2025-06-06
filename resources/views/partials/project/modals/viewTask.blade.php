<!-- Modal Voir Tâche -->
<div class="modal fade" id="viewTaskModal-{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Détails de la tâche</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nom :</strong> {{ $task->nom }}</p>
                <p><strong>Description :</strong> {{ $task->description ?? 'Aucune' }}</p>

                <p><strong>Collaborateurs :</strong></p>
                <ul>
                    @forelse ($task->collaborateurs ?? [] as $user)
                        <li>{{ $user->first_name }} {{ $user->last_name }}</li>
                    @empty
                        <li>Aucun collaborateur assigné</li>
                    @endforelse
                </ul>

                <p><strong>Date limite :</strong> {{ $task->deadline ? $task->deadline->format('d/m/Y') : 'Non définie' }}</p>
            </div>
        </div>
    </div>
</div>

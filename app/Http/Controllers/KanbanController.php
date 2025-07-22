<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Column;
use App\Models\Task;
use Illuminate\Support\Facades\Log;


class KanbanController extends Controller
{
    public function show(Project $project)
    {
        $project->load([
            'columns' => fn($q) => $q->orderBy('order'),
            'collaborateurs',
            'columns.tasks' => fn($q) => $q->orderBy('created_at'),
            'columns.tasks.collaborateurs',
            'columns.tasks.creator',
        ]);

        return view('pages.project.kanban', compact('project'));
    }

    public function renameColumn(Request $request, Column $column)
    {
        $request->validate(['nom' => 'required|string|max:255']);
        $column->update(['nom' => $request->nom]);
        return back()->with('success', 'Colonne renommée.');
    }

    public function moveColumn(Request $request, Column $column)
    {
        $request->validate(['order' => 'required|integer']);
        $targetOrder = $request->order;
        $project = $column->project;

        $conflicting = $project->columns()->where('order', $targetOrder)->first();
        if ($conflicting) {
            $conflicting->update(['order' => $column->order]);
        }

        $column->update(['order' => $targetOrder]);
        return back()->with('success', 'Colonne déplacée.');
    }

    public function deleteColumn(Column $column)
    {
        foreach ($column->tasks as $task) {
            $task->delete();
        }
        $column->delete();
        return back()->with('success', 'Colonne supprimée avec ses tâches.');
    }

    public function createTask(Request $request, Column $column)
    {
        Log::info('Requête reçue pour créer une tâche', [
            'request_data' => $request->all(),
            'column_id' => $column->id,
        ]);

        try {
            $request->validate([
                'nom'            => 'required|string|max:255',
                'description'    => 'nullable|string',
                'order'          => 'required|integer|min:1',
                'priority'       => 'nullable|string|in:basse,moyenne,élevée',
                'date_limite'    => 'nullable|date',
                'collaborateurs' => 'nullable|array',
                'collaborateurs.*' => 'exists:users,id',
            ]);

            Log::info('Validation des données réussie', [
                'validated_data' => $request->only([
                    'nom', 'description', 'order', 'priority', 'date_limite', 'collaborateurs'
                ]),
            ]);

            $task = $column->tasks()->create([
                'user_id'     => auth()->id(),
                'nom'         => $request->nom,
                'description' => $request->description,
                'order'       => $request->order,
                'priority'    => $request->priority,
                'date_limite' => $request->date_limite,
            ]);

            Log::info('Tâche créée avec succès', [
                'task_id' => $task->id,
                'task_data' => $task->toArray(),
            ]);

            // Attacher les collaborateurs si fournis
            if ($request->filled('collaborateurs')) {
                $task->collaborateurs()->sync($request->collaborateurs);
                Log::info('Collaborateurs attachés à la tâche', [
                    'task_id' => $task->id,
                    'collaborateurs' => $request->collaborateurs,
                ]);
            }

            return back()->with('success', 'Tâche créée avec succès.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de la création de la tâche', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all(),
                'column_id' => $column->id,
            ]);

            return back()->withErrors('Une erreur est survenue lors de la création de la tâche.');
        }
    }

    public function storeColumn(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'nom'        => 'required|string|max:255',
            'order'      => 'required|integer|min:1',
        ]);

        $project = Project::findOrFail($request->project_id);

        // Vérifie s'il existe déjà une colonne avec le même ordre
        $existing = $project->columns()->where('order', $request->order)->first();
        if ($existing) {
            // Décale toutes les colonnes d’ordre supérieur ou égal
            $project->columns()
                ->where('order', '>=', $request->order)
                ->orderByDesc('order') // important pour ne pas écraser
                ->get()
                ->each(function ($col) {
                    $col->increment('order');
                });
        }

        // Création de la colonne
        $project->columns()->create([
            'user_id'   => auth()->id(),
            'nom'       => $request->nom,
            'order'     => $request->order,
        ]);

        return back()->with('success', 'Colonne créée avec succès.');
    }

    public function destroyTask(Task $task)
    {
        $task->collaborateurs()->detach();
        $task->delete();

        return back()->with('success', 'Tâche supprimée.');
    }

    public function updateTask(Request $request, Task $task)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'required|integer|min:1',
            'date_limite' => 'nullable|date',
            'collaborateurs' => 'nullable|array',
            'collaborateurs.*' => 'exists:users,id',
        ]);

        $oldOrder = $task->order;
        $newOrder = $request->order;
        $columnId = $task->column_id;

        if ($newOrder !== $oldOrder) {
            // 🔁 Réordonner les autres tâches de la même colonne
            $tasks = Task::where('column_id', $columnId)
                ->where('id', '!=', $task->id)
                ->orderBy('order')
                ->get();

            $updated = collect();

            $position = 1;
            foreach ($tasks as $t) {
                if ($position == $newOrder) {
                    $position++; // on réserve la place pour la tâche actuelle
                }
                $updated->push([
                    'id' => $t->id,
                    'order' => $position++,
                ]);
            }

            // Mise à jour en base (en batch)
            foreach ($updated as $item) {
                Task::where('id', $item['id'])->update(['order' => $item['order']]);
            }
        }

        // Mettre à jour la tâche elle-même
        $task->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'order' => $newOrder,
            'date_limite' => $request->date_limite,
        ]);

        $task->collaborateurs()->sync($request->collaborateurs ?? []);

        return back()->with('success', 'Tâche mise à jour avec succès.');
    }
}


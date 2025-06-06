<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\{
    User,
    Subscription,
    Project,
    Column,
    Task,
    ProjectCollaborateur,
    TaskCollaborateur
};

class AdminController extends Controller
{
    public function index()
    {
        if (! Auth::check() || ! Auth::user()->admin) {
            return redirect()->route('dashboard');
        }

        $users = User::selectRaw('admin, COUNT(*) as total')->groupBy('admin')->pluck('total', 'admin');
        $projects = [
            'active' => Project::withTrashed()->whereNull('deleted_at')->count(),
            'archived' => Project::onlyTrashed()->count()
        ];
        $tasks = Task::selectRaw('priority, COUNT(*) as total')->groupBy('priority')->pluck('total', 'priority');
        $subs = Subscription::selectRaw('name, COUNT(*) as total')->groupBy('name')->pluck('total', 'name');
        $completion = Task::selectRaw('completed_at IS NOT NULL as done, COUNT(*) as total')->groupBy('done')->pluck('total', 'done');

        return view('pages.admin.index', [
            'userLabels' => json_encode(['Standard', 'Admin']),
            'userData' => json_encode([$users[false] ?? 0, $users[true] ?? 0]),

            'projectLabels' => json_encode(['Actifs', 'Archivés']),
            'projectData' => json_encode([$projects['active'], $projects['archived']]),

            'taskLabels' => json_encode(['Basse', 'Moyenne', 'Haute']),
            'taskData' => json_encode([
                Task::where('priority', 'basse')->count(),
                Task::where('priority', 'moyenne')->count(),
                Task::where('priority', 'élevée')->count()
            ]),

            'subLabels' => json_encode($subs->keys()),
            'subData' => json_encode($subs->values()),

            'completionLabels' => json_encode(['Terminées', 'Non terminées']),
            'completionData' => json_encode([
                $completion[true] ?? 0,
                $completion[false] ?? 0
            ]),
        ]);
    }

    // ----------- Users -----------

    public function users()
    {
        abort_unless(Auth::check() && Auth::user()->admin, 403);

        $users = User::with('subscription')
            ->withTrashed()
            ->orderBy('first_name')
            ->paginate(10);

        $subscriptions = Subscription::all();

        return view('pages.admin.manageUsers.index', compact('users', 'subscriptions'));
    }

    public function updateUserPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Mot de passe mis à jour avec succès.');
    }

    public function searchUsers(Request $request)
    {
        $query = $request->get('q');

        $users = User::with('subscription')
            ->withTrashed()
            ->where(function ($q) use ($query) {
                $q->where('first_name', 'like', "%$query%")
                ->orWhere('last_name', 'like', "%$query%");
            })
            ->orderBy('first_name')
            ->paginate(10);

        $subscriptions = Subscription::all(); // ✅ Ajouter cette ligne

        return view('components.admin.manageUsers.table', compact('users', 'subscriptions'))->render();
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|confirmed|min:8',
            'admin'            => 'nullable|boolean',
            'subscription_id'  => 'nullable|exists:subscriptions,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['id'] = (string) Str::uuid();
        $validated['admin'] = $request->has('admin');

        User::create($validated);

        return back()->with('success', 'Utilisateur créé avec succès.');
    }

    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password'         => 'nullable|confirmed|min:8',
            'admin'            => 'nullable|boolean',
            'subscription_id'  => 'nullable|exists:subscriptions,id',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $validated['admin'] = $request->has('admin');

        $user->update($validated);

        return back()->with('success', 'Utilisateur mis à jour.');
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur archivé.');
    }

    public function restoreUser($id)
    {
        User::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Utilisateur restauré.');
    }

    public function forceDeleteUser($id)
    {
        User::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Utilisateur supprimé définitivement.');
    }

    // ----------- Subscriptions -----------
    public function subscriptions()
    {
        if (Auth::check() && Auth::user()->admin) {
            $subscriptions = Subscription::all();
            return view('pages.admin.manageSubscriptions.index', compact('subscriptions'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function createSubscription()
    {
        return view('pages.admin.manageSubscriptions.create');
    }

    public function storeSubscription(Request $request)
    {
        Subscription::create($request->all());
        return redirect()->route('pages.admin.manageSubscriptions')->with('success', 'Abonnement créé.');
    }

    public function editSubscription(Subscription $subscription)
    {
        return view('pages.admin.manageSubscriptions.edit', compact('subscription'));
    }

    public function updateSubscription(Request $request, Subscription $subscription)
    {
        $subscription->update($request->all());
        return redirect()->route('pages.admin.manageSubscriptions')->with('success', 'Abonnement mis à jour.');
    }

    public function deleteSubscription(Subscription $subscription)
    {
        $subscription->delete();
        return back()->with('success', 'Abonnement supprimé.');
    }

    public function forceDeleteSubscription($id)
    {
        Subscription::findOrFail($id)->forceDelete();
        return back()->with('success', 'Abonnement supprimé définitivement.');
    }

    // ----------- Projects -----------
    public function projects()
    {
        if (Auth::check() && Auth::user()->admin) {
            $projects = Project::withTrashed()->get();
            return view('pages.admin.manageProjects.index', compact('projects'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function createProject()
    {
        return view('pages.admin.manageProjects.create');
    }

    public function storeProject(Request $request)
    {
        Project::create($request->all());
        return redirect()->route('pages.admin.manageProjects')->with('success', 'Projet créé.');
    }

    public function editProject(Project $project)
    {
        return view('pages.admin.manageProjects.edit', compact('project'));
    }

    public function updateProject(Request $request, Project $project)
    {
        $project->update($request->all());
        return redirect()->route('pages.admin.manageProjects')->with('success', 'Projet mis à jour.');
    }

    public function deleteProject(Project $project)
    {
        $project->delete();
        return back()->with('success', 'Projet archivé.');
    }

    public function restoreProject($id)
    {
        Project::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Projet restauré.');
    }

    public function forceDeleteProject($id)
    {
        Project::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Projet supprimé définitivement.');
    }

    // ----------- Columns -----------
    public function columns()
    {
        if (Auth::check() && Auth::user()->admin) {
            $columns = Column::withTrashed()->get();
            return view('pages.admin.manageColumns.index', compact('columns'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function createColumn()
    {
        return view('pages.admin.manageColumns.create');
    }

    public function storeColumn(Request $request)
    {
        Column::create($request->all());
        return redirect()->route('pages.admin.manageColumns')->with('success', 'Colonne créée.');
    }

    public function editColumn(Column $column)
    {
        return view('pages.admin.manageColumns.edit', compact('column'));
    }

    public function updateColumn(Request $request, Column $column)
    {
        $column->update($request->all());
        return redirect()->route('pages.admin.manageColumns')->with('success', 'Colonne mise à jour.');
    }

    public function deleteColumn(Column $column)
    {
        $column->delete();
        return back()->with('success', 'Colonne archivée.');
    }

    public function restoreColumn($id)
    {
        Column::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Colonne restaurée.');
    }

    public function forceDeleteColumn($id)
    {
        Column::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Colonne supprimée définitivement.');
    }

    // ----------- Tasks -----------
    public function tasks()
    {
        if (Auth::check() && Auth::user()->admin) {
            $tasks = Task::withTrashed()->get();
            return view('pages.admin.manageTasks.index', compact('tasks'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function createTask()
    {
        return view('pages.admin.manageTasks.create');
    }

    public function storeTask(Request $request)
    {
        Task::create($request->all());
        return redirect()->route('pages.admin.manageTasks')->with('success', 'Tâche créée.');
    }

    public function editTask(Task $task)
    {
        return view('pages.admin.manageTasks.edit', compact('task'));
    }

    public function updateTask(Request $request, Task $task)
    {
        $task->update($request->all());
        return redirect()->route('pages.admin.manageTasks')->with('success', 'Tâche mise à jour.');
    }

    public function deleteTask(Task $task)
    {
        $task->delete();
        return back()->with('success', 'Tâche archivée.');
    }

    public function restoreTask($id)
    {
        Task::withTrashed()->findOrFail($id)->restore();
        return back()->with('success', 'Tâche restaurée.');
    }

    public function forceDeleteTask($id)
    {
        Task::withTrashed()->findOrFail($id)->forceDelete();
        return back()->with('success', 'Tâche supprimée définitivement.');
    }

    // ----------- Project Collaborators -----------
    public function projectCollaborators()
    {
        if (Auth::check() && Auth::user()->admin) {
            $collaborators = ProjectCollaborateur::all();
            return view('pages.admin.manageProjectCollaborators.index', compact('collaborators'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function destroyProjectCollaborator(ProjectCollaborateur $projectCollaborateur)
    {
        $projectCollaborateur->delete();
        return back()->with('success', 'Collaborateur supprimé du projet.');
    }

    // ----------- Task Collaborators -----------
    public function taskCollaborators()
    {
        if (Auth::check() && Auth::user()->admin) {
            $collaborators = TaskCollaborateur::all();
            return view('pages.admin.manageTaskCollaborators.index', compact('collaborators'));
        } else {
            return redirect()->route('dashboard');
        }
    }

    public function destroyTaskCollaborator(TaskCollaborateur $taskCollaborateur)
    {
        $taskCollaborateur->delete();
        return back()->with('success', 'Collaborateur supprimé de la tâche.');
    }
}

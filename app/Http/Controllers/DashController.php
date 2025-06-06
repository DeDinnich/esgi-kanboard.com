<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Project;
use App\Models\Column;

class DashController extends Controller
{
    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Projets que l'utilisateur a créés
        $ownedProjects = $user->projectsOwned()->latest()->get();

        // Projets où il est collaborateur, mais pas propriétaire
        $invitedProjects = $user->projectCollaborations()
            ->where('projects.user_id', '!=', $user->id) // éviter ambiguïté
            ->latest()
            ->get();

        // Projets archivés
        $archivedOwned = $user->projectsOwned()->onlyTrashed()->latest()->get();
        $archivedCollab = $user->projectCollaborations()->onlyTrashed()->latest()->get();

        $archivedProjects = $archivedOwned->merge($archivedCollab)->unique('id')->sortByDesc('created_at')->values();

        return view('pages.dashboard.home', compact('ownedProjects', 'invitedProjects', 'archivedProjects'));
    }

    /**
     * Show the user profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        $featuresList = [
            "Création de projets",
            "Ajout de tâches",
            "Inviter des membres",
            "Vues Kanban/Liste/Calendrier",
            "Commentaires sur tâches",
            "Notifications temps réel",
            "Rapports statistiques",
            "Synchronisation iCal",
            "Support prioritaire",
            "Mode hors-ligne",
        ];

        $plans = Subscription::orderBy('price')->get();
        $activePlan = $user->subscription; // relation déjà dispo

        Log::info('Data passed to view:', [
            'user' => $user,
            'plans' => $plans,
            'featuresList' => $featuresList,
            'activePlan' => $activePlan,
        ]);

        return view('pages.dashboard.profile', compact('user', 'plans', 'featuresList', 'activePlan'));
    }

    /**
     * Store a new project.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeProject(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
        ]);

        $project = Project::create([
            'user_id' => Auth::id(),
            'nom'     => $request->nom,
        ]);

        // Création automatique des 4 colonnes par défaut
        $defaultColumns = ['À faire', 'En cours', 'Fait', 'Annulé'];

        foreach ($defaultColumns as $index => $columnName) {
            Column::create([
                'user_id'    => Auth::id(),
                'project_id' => $project->id,
                'nom'        => $columnName,
                'order'      => $index + 1,
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Projet créé avec succès.');
    }
}

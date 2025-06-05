<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DashController extends Controller
{
    /**
     * Show the dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.home');
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
}

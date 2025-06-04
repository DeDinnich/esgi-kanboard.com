<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Subscription;

class LandingController extends Controller
{
    public function prices()
    {
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

        $plansJson = Subscription::all()
            ->sortBy('price') // Sort plans by price
            ->map(function ($plan) {
                return [
                    'id' => $plan->id,
                    'name' => $plan->name,
                    'price' => number_format($plan->price, 2) . '€ / mois',
                    'features' => collect(range(1, 10))->map(fn($i) => (bool) $plan->{'option' . $i})->toArray(),
                ];
            });

        return view('pages.landing.prices', [
            'rawPlans' => Subscription::all()->sortBy('price'), // Sort raw plans by price
            'plans' => $plansJson->values()->toArray(),
            'featuresList' => $featuresList,
        ]);
    }
}

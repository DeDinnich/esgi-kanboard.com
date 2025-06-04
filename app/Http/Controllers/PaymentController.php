<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Mail\PlanWelcomeMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Models\Subscription;


class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        Log::info('Début du processus de paiement.');

        try {
            Log::info('Validation des données de la requête.');
            $validated = $request->validate([
                'prenom' => 'required|string|max:255',
                'nom'    => 'required|string|max:255',
                'email'  => 'required|email',
                'plan'   => 'required|string',
            ]);

            Log::info('Données validées : ', $validated);

            if (User::where('email', $validated['email'])->exists()) {
                Log::warning('Un compte existe déjà avec cet email : ' . $validated['email']);
                return response()->json(['error' => 'Un compte existe déjà avec cet email. Veuillez choisir ce plan depuis votre espace.'], 409);
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));
            Log::info('Clé API Stripe définie.');

            // 🔍 Cherche la subscription via son ID
            $subscription = \App\Models\Subscription::find($validated['plan']);

            if (!$subscription) {
                Log::warning('Aucun plan trouvé avec cet ID : ' . $validated['plan']);
                return response()->json(['error' => 'Le plan sélectionné est invalide.'], 400);
            }

            $amount = intval($subscription->price * 100); // Stripe = en centimes
            Log::info('Montant calculé pour le plan ' . $subscription->name . ': ' . $amount);

            if ($amount === 0) {
                Log::warning('Plan gratuit sélectionné, aucun paiement requis.');
                return response()->json(['error' => 'Ce plan est gratuit, aucun paiement requis.'], 400);
            }

            $intent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => 'eur',
                'receipt_email' => $validated['email'],
                'metadata' => [
                    'prenom' => $validated['prenom'],
                    'nom'    => $validated['nom'],
                    'email'  => $validated['email'],
                    'plan_id' => $subscription->id,
                    'plan_name' => $subscription->name,
                ]
            ]);

            Log::info('Intent de paiement créé avec succès. ClientSecret : ' . $intent->client_secret);

            return response()->json(['clientSecret' => $intent->client_secret]);

        } catch (\Exception $e) {
            Log::error('Erreur Stripe : ' . $e->getMessage());
            return response()->json(['error' => 'Le paiement a échoué.'], 500);
        }
    }

    public function confirm(Request $request)
    {
        Log::info('Début du processus de confirmation de paiement.');

        try {
            Log::info('Validation des données de la requête.');
            $validated = $request->validate([
                'prenom' => 'required|string|max:255',
                'nom' => 'required|string|max:255',
                'email' => 'required|email',
                'plan' => 'required|string',
            ]);

            Log::info('Données validées : ', $validated);

            if (User::where('email', $validated['email'])->exists()) {
                Log::warning('Un compte existe déjà avec cet email : ' . $validated['email']);
                return redirect()->back()->with('error', 'Un compte existe déjà avec cet email.');
            }

            // 🔍 Récupération de l'abonnement
            $subscription = Subscription::find($validated['plan']);

            if (!$subscription) {
                Log::error("Aucune subscription trouvée pour le plan : " . $validated['plan']);
                return response()->json(['error' => 'Plan invalide.'], 400);
            }

            $password = Str::random(8);
            Log::info('Mot de passe généré pour le nouvel utilisateur : ' . $password);

            $user = User::create([
                'first_name' => $validated['prenom'],
                'last_name' => $validated['nom'],
                'email' => $validated['email'],
                'password' => Hash::make($password),
                'subscription_id' => $subscription->id, // ✅ ici on attache le plan
            ]);

            Log::info('Utilisateur créé avec succès : ', ['id' => $user->id, 'email' => $user->email]);

            $verificationUrl = URL::temporarySignedRoute(
                'verify-purchase-email',
                now()->addMinutes(60),
                ['user' => $user->id]
            );

            Mail::to($validated['email'])->send(new PlanWelcomeMail($user, $password, $verificationUrl));
            Log::info('Email de bienvenue envoyé à : ' . $validated['email']);

            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            Log::error('Erreur lors de la confirmation du paiement : ' . $e->getMessage());
            return response()->json(['error' => 'Une erreur est survenue lors de la confirmation.'], 500);
        }
    }
}

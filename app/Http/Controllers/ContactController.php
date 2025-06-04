<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use App\Mail\ContactConfirmation;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'objet' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Envoi à l'entreprise
            Mail::to('contact@kanboard.fr')->send(new ContactNotification($validated));

            // Accusé de réception au client
            Mail::to($validated['email'])->send(new ContactConfirmation($validated));

            return back()->with('success', 'Votre message a bien été envoyé. Un accusé de réception vous a été envoyé par email.');
        } catch (\Exception $e) {
            Log::error('Erreur lors de l’envoi du formulaire de contact : ' . $e->getMessage());
            return back()->with('error', 'Une erreur est survenue. Veuillez réessayer plus tard.');
        }
    }
}

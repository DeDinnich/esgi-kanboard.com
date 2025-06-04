@component('mail::message')
# Bienvenue sur Kanboard

Merci de votre inscription {{ $user->first_name }} !

Veuillez confirmer votre adresse email pour activer votre compte.

@component('mail::button', ['url' => $url])
Confirmer mon email
@endcomponent

Ce lien expirera dans 60 minutes.

Merci,<br>
L'équipe Kanboard
@endcomponent

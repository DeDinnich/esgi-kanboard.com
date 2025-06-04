@component('mail::message')
# Réinitialisation de mot de passe

Vous avez demandé la réinitialisation de votre mot de passe.

@component('mail::button', ['url' => $url])
Réinitialiser mon mot de passe
@endcomponent

Ce lien expirera dans 60 minutes.

Si vous n'avez rien demandé, ignorez simplement ce mail.

L’équipe Kanboard.
@endcomponent

@component('mail::message')
# Bienvenue sur Kanboard

Votre compte a bien été créé suite à l'achat de votre formule.

**Identifiants de connexion :**

- Email : {{ $email }}
- Mot de passe : {{ $password }}

@component('mail::button', ['url' => $verificationUrl])
Valider mon compte
@endcomponent

**Important :** Vous devez utiliser ce lien pour valider votre compte. Sans cette validation, vous ne pourrez pas vous connecter à votre espace.

Vous pourrez modifier votre mot de passe depuis votre tableau de bord.

L’équipe Kanboard.
@endcomponent

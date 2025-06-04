@component('mail::message')
# Bonjour {{ $prenom }},

Nous avons bien reçu votre message concernant :

**"{{ $objet }}"**

Nous vous remercions pour votre prise de contact.
Notre équipe reviendra vers vous dans les plus brefs délais.

---

Voici une copie de votre message :

> {{ $message }}

À très bientôt,
L’équipe **KANBOARD**
@endcomponent

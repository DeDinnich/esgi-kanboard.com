@component('mail::message')
# Nouveau message de contact

**De :** {{ $prenom }} {{ $nom }}
**Email :** {{ $email }}
**Objet :** {{ $objet }}

---

{{ $message }}

@endcomponent

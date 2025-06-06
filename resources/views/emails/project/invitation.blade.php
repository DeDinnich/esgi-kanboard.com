@component('mail::message')
# Invitation à rejoindre le projet {{ $projectName }}

Vous avez été invité à collaborer sur le projet **{{ $projectName }}**.

@component('mail::button', ['url' => $url])
Rejoindre le projet
@endcomponent

@endcomponent

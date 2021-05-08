@component('mail::message')
# School Admin

Bienvenue {{ $user->name }}.

Voici votre mot de passe: *{{ $user->password }}*

@component('mail::button', ['url' => 'http://schooladmin.test'])
Accéder à l'application
@endcomponent

Merci,<br>
{{ config('app.name') }}
@endcomponent

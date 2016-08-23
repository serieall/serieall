Bonjour,

Vous avez effectué une demande de changement de mot de passe suite à un oubli.


Cliquez sur le lien ci dessous pour réinitialiser votre mot de passe :
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>

A bientôt !
L'équipe Série-All

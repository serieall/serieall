Bonjour,<br />
<br />
Vous avez effectué une demande de changement de mot de passe suite à un oubli.<br />
<br />
<br />
Cliquez sur le lien ci dessous pour réinitialiser votre mot de passe :<br />
<a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a><br/>
<br/>
A bientôt !<br/>
L'équipe Série-All

<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Validez votre adresse E-mail</h2>
<br />
<div>
    Merci de vous être inscrit sur Série-All.<br/>
    Merci de suivre le lien ci-dessous pour valider l'inscription :<br/>
    <a href="{{ $link = url('user/activation', $this->token).'?email='.urlencode($user->getActivation($user)) }}"> {{ $link }} </a><br/><br/>

    A bientôt !
    L'équipe Série-All
</div>

</body>
</html>
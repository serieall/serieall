<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Validez votre adresse E-mail</h2>
<br />
<div>
    Bonjour ! <br />
    Merci de vous être inscrit sur Série-All.<br/>
    Merci de suivre le lien ci-dessous pour valider l'inscription :<br/>
    <a href="{{ url('user/activation', $token) }}"> >> Le lien où il faut cliquer << </a><br/><br/>

    A bientôt !
    L'équipe Série-All
</div>

</body>
</html>
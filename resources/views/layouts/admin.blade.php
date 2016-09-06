<!DOCTYPE html>
<html lang="en" id="html-admin">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SérieAll BETA</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/knacss.css" />
    <link rel="stylesheet" href="css/knacss_perso.css" />
</head>
<body id="body-admin">
    <header id="header-admin" class="fr w80">
        Administration Série-All
    </header>
    <nav id="nav-admin" class="fl w20">
        <ul>
            <li>Séries</li>
            <li>Articles</li>
            <li>Utilisateurs</li>
            <li>Système</li>
        </ul>
    </nav>

    <section class="fr w80">
        <article>
            @yield('content')
        </article>
    </section>
</body>
</html>
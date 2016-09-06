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
    <header id="header-admin" class="fr w90 pas">
        Administration Série-All
    </header>
    <nav id="nav-admin" class="fl w10 pam">
        <img id="logo-admin" src="images/logo_v2.png" alt="Logo Série-All" />
        <ul id="nav-ul-admin" class="w100">
            <a href="#" id="nav-a-admin"><li id="nav-li-admin" class="pam w100">Séries</li></a>
            <a href="#" id="nav-a-admin"><li id="nav-li-admin" class="pam w100">Articles</li></a>
            <a href="#" id="nav-a-admin"><li id="nav-li-admin" class="pam w100">Utilisateurs</li></a>
            <a href="#" id="nav-a-admin"><li id="nav-li-admin" class="pam w100">Système</li></a>
        </ul>
    </nav>

    <section class="fr w90">
        <article class="pam">
            @yield('content')
        </article>
    </section>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SérieAll BETA</title>

    <!-- CSS -->
    <link rel="stylesheet" href="css/knacss.css" />
    <link rel="stylesheet" href="css/knacss_perso.css" />
</head>
<body>
    <div class="grid-1-4">
        <nav id="nav-admin" class="w20">
            <ul>
                <li>Séries</li>
                <li>Articles</li>
                <li>Utilisateurs</li>
                <li>Système</li>
            </ul>
        </nav>
        <header id="header-admin" class="w80">
            Administration Série-All
        </header>
    </div>

    <section class="fr w80">
        <article>
            @yield('content') 
        </article>
    </section>
</body>
</html>
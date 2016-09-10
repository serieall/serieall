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
    <link rel="stylesheet" href="css/font-awesome.css" />
</head>
<body id="body-admin">
    <header id="header-admin" class="fr w85 h50p">
        <div class="grid-3-tiny-2 h50p">
            <ul id="header-beadcrumbs-admin" class="grid-item-double">
                @yield('breadcrumbs')
            </ul>
            <ul id="header-user-admin" class="txtright h50p">
                <li>
                    Wiki
                </li>
                <li>
                    <div id="header-dropdown-admin">
                        <span id="header-dropdown-button">{{ Auth::user()->username }}</span> <span class="caret"></span>
                        <div id="header-dropdown-content" class="txtleft">
                            <i class= "fa fa-caret-square-o-left"></i>
                            <a href="{{ url('/')}}">Retour sur le site</a>
                            <i class= "fa fa-sign-out"></i>
                            <a href="{{ url('/logout')}}">Déconnexion</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </header>


    <nav id="nav-admin" class="fl w15">
        <img id="logo-admin" src="images/logo_v2.png" alt="Logo Série-All" />
        <ul id="nav-ul-admin" class="w100">
            <li id="nav-li-admin" class="w100">
                <a href="#" id="nav-a-admin" class="pam">
                    <span class="big">Séries</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
            <li id="nav-li-admin" class="w100">
                <a href="#" id="nav-a-admin" class="pam">
                    <span class="big">Articles</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
            <li id="nav-li-admin" class="w100">
                <a href="#" id="nav-a-admin" class="pam">
                    <span class="big">Utilisateurs</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
            <li id="nav-li-admin" class="w100">
                <a href="#" id="nav-a-admin" class="pam">
                    <span class="big">Système</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
        </ul>
    </nav>

    <article id="article-admin" class="fr w85 pas">
        @yield('content')
    </article>
</body>
</html>
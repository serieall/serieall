<!DOCTYPE html>
<html lang="en" id="html-admin">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SérieAll BETA</title>
    <link rel="icon" href="images/logo_v2.ico">

    <!-- CSS -->
    {{ Html::style('/css/knacss.css') }}
    {{ Html::style('/css/knacss_perso.css') }}
    {{ Html::style('/css/font-awesome.css') }}
</head>
<body id="body-admin">
    <header id="header-admin" class="fr w85 h50p">
        <div class="grid-3-small-1 h50p">
            <ul id="header-beadcrumbs-admin" class="grid-item-double">
                @yield('breadcrumbs')
            </ul>
            <ul id="header-user-admin" class="txtright h50p">
                <li>
                    <a class="wiki" href="http://wiki.journeytotheit.ovh">
                        Wiki <span class="mls fa fa-question-circle"></span>
                    </a>
                </li>

                <li>
                    <div id="header-dropdown-admin">
                        <span id="header-dropdown-button">{{ Auth::user()->username }}<span class="mls fa fa-caret-down"></span></span>
                        <ul id="header-dropdown-content" class="txtleft">
                            <a href="{{ url('/')}}">
                                <li>
                                    <i class= "fa fa-caret-square-o-left"></i>
                                    Retour sur le site
                                </li>
                            </a>
                            <a href="{{ url('/logout')}}">
                                <li>
                                    <i class= "fa fa-sign-out"></i>
                                    Déconnexion
                                </li>
                            </a>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </header>

    <nav id="nav-admin" class="fl w15 responsive-menu">
        <img id="logo-admin" src="/images/logo_v2.png" alt="Logo Série-All" />
        <ul id="nav-ul-admin" class="w100">
            <li id="nav-li-admin" class="w100">
                <a href="{{ url('/admin/series') }}" id="nav-a-admin" class="pam
                    @if($nav_active = 'show')
                       active
                     @endif
                 ">
                    <span class="big">Séries</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
            <li id="nav-li-admin" class="w100">
                <a href="#" id="nav-a-admin" class="pam
                    @if($nav_active = 'articles')
                        active
                    @endif
                ">
                    <span class="big">Articles</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
            <li id="nav-li-admin" class="w100">
                <a href="#" id="nav-a-admin" class="pam
                    @if($nav_active = 'user')
                        active
                    @endif
                ">
                    <span class="big">Utilisateurs</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
            <li id="nav-li-admin" class="w100">
                <a href="#" id="nav-a-admin" class="pam
                    @if($nav_active = 'system')
                        active
                    @endif
                ">
                    <span class="big">Système</span>
                    <div class="fr">
                        <i id="nav-i-admin" class="fa fa-chevron-right txtright"></i>
                    </div>
                </a>
            </li>
        </ul>
    </nav>

    <article id="article-admin" class="fr w85 pam">
        @yield('content')
    </article>
</body>
</html>
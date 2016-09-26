<!DOCTYPE html>
<html lang="en" id="html-admin">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SérieAll BETA</title>
    <link rel="icon" href="images/logo_v2.ico">

    <!-- CSS -->
    {{ Html::style('/semantic/semantic.css') }}
    {{ Html::style('/semantic/semantic_perso.css') }}
    {{ Html::style('/css/font-awesome.css') }}

    <!-- Javascript -->
    {{ Html::script('/js/jquery.js') }}
    {{ Html::script('/js/datatables.js') }}
    {{ Html::script('/semantic/semantic.js') }}

</head>
<body>
<div class="pushed">
    <div class="ui stackable menu" id="menu-admin">
                <div class="ui breadcrumb item">
            @yield('breadcrumbs')
        </div>

            <a class="right menu item" href="http://wiki.journeytotheit.ovh">Wiki
                <i id="icon-wiki" class="help circle icon"></i>
            </a>
            <div class="ui dropdown item">
                {{ Auth::user()->username }} <i class="dropdown icon"></i>
                <div class="menu">
                    <a class="item" href="{{ url('/') }}">
                        Revenir sur le site
                    </a>
                    <a class="item" href="{{ url('/logout') }}">
                        Se déconnecter
                    </a>
                </div>
            </div>
    </div>
</div>

    <div class="ui left fixed vertical menu">
        <div class="item">
            <img class="ui centered image" src="/images/logo_v2.png">
        </div>
        <a class="ui header item
            @if($navActive == 'home')
                blue
            @endif" href="{{ route('adminIndex') }}">
            <i class="home icon"></i>
                Accueil
        </a>
        <a class="ui header item
            @if($navActive == 'show')
                blue
            @endif" href="{{ route('adminShow.index') }}">
            <i class="tv icon"></i>
                Séries
        </a>
        <a class="ui header item">
            <i class="file text outline icon"></i>
                Articles
        </a>
        <a class="ui header item">
            <i class="users icon"></i>
                Utilisateurs
        </a>
        <a class="ui header item">
            <i class="settings icon"></i>
                Système
        </a>
    </div>

    <div class="pushed">
        @yield('content')
    </div>

    <script>
        @yield('scripts')

        $('.dropdown')
                .dropdown()
        ;

        $('.ui.sidebar')
                .sidebar({
                    overlay: true
                })
                .sidebar('attach events', '.menu .click-sidebar')
        ;
    </script>

</body>
</html>
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
    <div class="ui stackable menu" id="menu-admin">
        <a class="item click-sidebar">
            <i class="content icon"></i>
            Choisir une catégorie
        </a>
        <div class="ui breadcrumb item">
            @yield('breadcrumbs')
        </div>

        <div class="right menu">
            <div class="item">
                <a class="" href="http://wiki.journeytotheit.ovh">Wiki
                    <i id="icon-wiki" class="help circle icon"></i>
                </a>
            </div>
            <div class="item">
                <div class="ui dropdown">
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
    </div>

    @yield('content')

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
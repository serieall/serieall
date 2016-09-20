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
            <i class="fa fa-bars"></i>
        </a>
        <div class="ui breadcrumb item">
            @yield('breadcrumbs')
        </div>
        <div class="right menu">
            <a class="item">Wiki</a>
            <div class="item">{{ Auth::user()->username }}</div>

        </div>
    </div>
    <div class="ui bottom attached segment pushable" id="div-bottom">
        <div class="ui visible left vertical sidebar menu">
            <div class="item">
                <img class="ui centered image" src="/images/logo_v2.png">
            </div>
            <a class="ui header item
                @if($navActive == 'show')
                    blue
                @endif" href="{{ url('/admin/series') }}">
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
                <i class="trash icon"></i>
                Système
            </a>
        </div>
        <div class="pusher">
            <div class="ui basic segment">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        @yield('scripts')

        $('.dropdown')
                .dropdown()
        ;

        $('.ui.sidebar')
                .sidebar({
                    dimPage: false,
                    closable: false,
                    overlay: true
                })
                .sidebar('attach events', '.menu .click-sidebar')
        ;
    </script>

</body>
</html>
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
    {{ Html::style('/css/font-awesome.css') }}

    <!-- Javascript -->
    {{ Html::script('/js/jquery.js') }}
    {{ Html::script('/js/datatables.js') }}
    {{ Html::script('/semantic/semantic.js') }}

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
    <div class="ui top attached demo menu">
        <a class="item">
            Menu
        </a>
    </div>
    <div class="ui bottom attached segment pushable">
        <div style="" class="ui inverted labeled icon left inline vertical sidebar menu uncover visible">
            <a class="item">
                Home
            </a>
            <a class="item">
                Topics
            </a>
            <a class="item">
                Friends
            </a>
            <a class="item">
                History
            </a>
        </div>
        <div class="pusher dimmed">
            <div class="ui basic segment">
                <article id="article-admin" class="fr w85 pam">
                    @yield('content')
                </article>
            </div>
        </div>
    </div>

    <script>
        @yield('scripts')

        $('.dropdown')
                .dropdown()
        ;

        $('#nav-admin')
                .sidebar('toggle')
        ;
    </script>

</body>
</html>
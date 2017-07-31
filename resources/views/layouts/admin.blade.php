<!DOCTYPE html>
<html lang="en" id="html-admin">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SérieAll BETA</title>
    <link rel="icon" href="{{ $folderImages }}logo_v2.ico">

    <!-- CSS -->
    {{ Html::style('/semantic/semantic.css') }}
    {{ Html::style('/semantic/semantic_perso.css') }}
    {{ Html::style('/js/jquery.css') }}

    <!-- Javascript -->
    {{ Html::script('/js/jquery.js') }}
    {{ Html::script('/js/jquery.ui.js') }}
    {{ Html::script('/js/datatables.js') }}
    {{ Html::script('/semantic/semantic.min.js') }}

<!-- Piwik -->
    <script type="text/javascript">
        var _paq = _paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//analytics.journeytotheit.ovh/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', '{{ env('APP_IDPIWIK') }}']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <noscript><p><img src="//analytics.journeytotheit.ovh/piwik.php?idsite={{ env('APP_IDPIWIK') }}" style="border:0;" alt="" /></p></noscript>
    <!-- End Piwik Code -->

</head>
<body>
    <div class="ui left fixed vertical menu">
        <div class="item">
            <img class="ui centered image" src="{{ $folderImages }}logo_v2.png">
        </div>
        <a class="ui header item
            @if($navActive == 'AdminHome')
                blue
            @endif" href="{{ route('admin') }}">
            <i class="home icon"></i>
            Accueil
        </a>
        <a class="ui header item
             @if($navActive == 'AdminShows')
                blue
             @endif" href="{{ route('admin.shows.index') }}">
            <i class="tv icon"></i>
            Séries
        </a>
        <a class="ui header item">
            <i class="file text outline icon"></i>
            Articles
        </a>
        <a class="ui header item
            @if($navActive == 'AdminUsers')
                blue
            @endif" href="{{ route('admin.users.index') }}">
            <i class="users icon"></i>
            Utilisateurs
        </a>
        <a class="ui header item
            @if($navActive == 'AdminSystem')
                blue
             @endif" href="{{ route('admin.system') }}">
            <i class="settings icon"></i>
            Système
        </a>
        <div class="ui attached message">
            <div class="header">
                Version {{ config('app.version') }}
            </div>
        </div>
    </div>

    <div class="pushed">
        <div class="ui stackable menu" id="menu-admin">
            <div class="ui breadcrumb item">
                @yield('breadcrumbs')
            </div>
            <div class="right menu">
                <a  class="item" href="http://wiki.journeytotheit.ovh">
                    <div>
                    Wiki
                        <i id="icon-wiki" class="help circle icon"></i>
                    </div>
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
        <div class="ui padding-article">
            @if (session('status'))
                <div id="message-top" class="ui container centered grid">
                    <div class="ui success compact message">
                        <i class="close icon"></i>
                        <div class="content">
                            <div class="header">
                                {{ session('status_header') }}
                            </div>
                            <p>{{ session('status') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            @if (session('warning'))
                <div id="message-top" class="ui container centered grid">
                    <div class="ui warning compact message">
                        <i class="close icon"></i>
                        <div class="content">
                            <div class="header">
                                {{ session('warning_header') }}
                            </div>
                            <p>{{ session('warning') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        $('.dropdown')
                .dropdown()
        ;

        $('.message .close')
                .on('click', function() {
                    $(this)
                            .closest('.message')
                            .transition('fade')
                    ;
                })
        ;
    </script>
    @yield('scripts')
</body>
</html>
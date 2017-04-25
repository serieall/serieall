<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>SérieAll BETA</title>
    <link rel="icon" href="images/logo_v2.ico">

    <!-- CSS -->
    {{ Html::style('/semantic/semantic.css') }}
    {{ Html::style('/semantic/semantic_perso.css') }}
    {{ Html::style('/js/jquery.css') }}

    <!-- Javascript -->
    {{ Html::script('/js/jquery.js') }}
    {{ Html::script('/js/jquery.ui.js') }}
    {{ Html::script('/js/datatables.js') }}
    {{ Html::script('/semantic/semantic.js') }}

    <!-- Piwik -->
    <script type="text/javascript">
        var _paq = _paq || [];
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="//analytics.journeytotheit.ovh/";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', '1']);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript'; g.async=true; g.defer=true; g.src=u+'piwik.js'; s.parentNode.insertBefore(g,s);
        })();
    </script>
    <noscript><p><img src="//analytics.journeytotheit.ovh/piwik.php?idsite=1" style="border:0;" alt="" /></p></noscript>
    <!-- End Piwik Code -->
</head>
<body>
    <div class="ui secondary pointing menu">
        <a href="/"><img src="images/logo_v2_ho.png" alt="logo_serieall" height="50px"/></a>
        <a class="item
            @if($navActive == 'show')
                active
            @endif">
            Séries TV
        </a>
        <a class="item
           @if($navActive == 'articles')
                active
            @endif">
            Articles
        </a>
        <a class="item
           @if($navActive == 'planning')
                active
            @endif">
            Planning
        </a>
        <a class="item
            @if($navActive == 'classement')
                active
            @endif">
            Classements
        </a>
        <div class="right secondary pointing menu">
            @if (Auth::guest())
                <a class="item
                    @if($navActive == 'articles')
                        active
                    @endif" href="{{ url('/login') }}">
                    <div>
                        Connexion
                        <i class="sign in icon"></i>
                    </div>
                </a>
                <a class="item
                    @if($navActive == 'articles')
                        active
                    @endif" href="{{ url('/register') }}">
                    <div>
                        Inscription
                        <i class="wizard icon"></i>
                    </div>
                </a>
            @else
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
            @endif
        </div>
    </div>
    <div class="ui centered grid">
        <div class="row">
                @yield('content')
        </div>
    </div>
    <div id="footer" class="ui vertical footer segment">
        <div class="ui center aligned container">
            <div class="ui centered stackable grid">
                <div class="centered three wide column">
                    <h3>Série-All</h3>
                    <ul class="ui list">
                        <li>A propos</li>
                        <li>Notre équipe</li>
                        <li>Mentions légales</li>
                        <li>Nous contacter</li>
                    </ul>
                </div>
                <div class="three wide column">
                    <h3>Communauté</h3>
                    <ul class="ui list">
                        <li>Inscription</li>
                        <li>Liste des membres</li>
                        <li>Forum</li>
                        <li>Rejoindre l'équipe</li>
                    </ul>
                </div>
                <div class="center aligned three wide column">
                    <div class="row">
                        <i class="circular facebook f big icon"></i>
                        <i class="circular twitter big icon"></i>
                    </div>
                    <div class="row">
                        <i class="circular mixcloud big icon"></i>
                        <i class="circular rss big icon"></i>
                        <i class="circular spotify big icon"></i>
                    </div>

                </div>
                <div class="three wide column">
                    <h3>Séries</h3>
                    <ul class="ui list">
                        <li>Liste des séries</li>
                        <li>Articles</li>
                        <li>Planning</li>
                        <li>Classement</li>
                    </ul>
                </div>
                <div class="three wide column">
                    <h3>Partenaires</h3>
                    <ul class="ui list">
                        <li>VODD</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#footer .icon').hover(function(){
                $(this).transition('tada');
            }, function(){});
        });
    </script>
    @yield('scripts')
</body>
</html>

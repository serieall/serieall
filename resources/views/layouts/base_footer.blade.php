<div id="footer" class="ui vertical footer segment">
    <div class="ui center aligned container">
        <div class="ui centered stackable grid">
            <div class="centered three wide column columnFooter">
                <div class="columnFooter">
                    <ul class="ui list">
                        <li class="title">
                            <h3>Série-All</h3>
                        </li>
                        <li><a href="{{ route('about') }}">À propos</a></li>
                        <li><a href="{{ route('team') }}">Notre équipe</a></li>
                        <li><a href="{{ route('cgu') }}">Mentions légales</a></li>
                        <li><a href="{{ route('contact') }}">Nous contacter</a></li>
                    </ul>
                </div>
            </div>
            <div class="three wide column">
                <div class="columnFooter">
                    <ul class="ui list">
                        <li class="title">
                            <h3>Communauté</h3>
                        </li>
                        <li><a href="#" class="clickRegister">Inscription</a></li>
                        <li><a href="{{ route('users.index') }}">Liste des membres</a></li>
                        <li><a href="{{ config('app.forum_url') }}">Forum</a></li>
                        <li>Rejoindre l'équipe</li>
                    </ul>
                </div>
            </div>
            <div class="center aligned three wide column">
                <div class="row">
                    <a href="https://www.facebook.com/SerieAll"><i class="circular facebook f big icon"></i></a>
                </div>
                <div class="row">
                    <a href="https://twitter.com/serieall"><i class="circular twitter big icon"></i></a>
                    <a href="https://open.spotify.com/user/serieall.fr"><i class="circular spotify big icon"></i></a>
                </div>
            </div>
            <div class="three wide column">
                <div class="columnFooter">
                    <ul class="ui list">
                        <li class="title">
                            <h3>Séries</h3>
                        </li>
                        <li><a href="{{ route('show.index') }}">Liste des séries</a></li>
                        <li><a href="{{ route('article.index') }}">Articles</a></li>
                        <li><a href="{{ route('planning.index') }}">Planning</a></li>
                        <li><a href="{{ route('ranking.index') }}">Classement</a></li>
                    </ul>
                </div>
            </div>
            <div class="three wide column">
                <div class="columnFooter">
                    <ul class="ui list">
                        <li class="title">
                            <h3>Partenaires</h3>
                        </li>
                        <li>VODD</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

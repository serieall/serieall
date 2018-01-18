<!DOCTYPE html>
<html lang="fr">
<head>
    @include('layouts.base_head')
</head>
<body id="body">
@include('cookieConsent::index')
<div class="ui sidebar inverted vertical menu">
    <div class="item ui search dropdown showDropdown">
        <div class="ui icon input">
            <input class="prompt" placeholder="Rechercher une série...">
            <i class="search icon"></i>
        </div>
        <div class="results">
        </div>
    </div>

    <a href="{{ route('show.index') }}" class="item
       @if($navActive == 'shows')
           active
        @endif">
        <i class="tv icon"></i>
        Séries TV
    </a>
    <a href="{{ route('article.index') }}" class="item
        @if($navActive == 'articles')
            active
        @endif">
        <i class="file text outline icon"></i>
        Articles
    </a>
    <a href="" class="item
        @if($navActive == 'planning')
            active
        @endif">
        <i class="calendar icon"></i>
        Planning
    </a>
    <a href="" class="item
        @if($navActive == 'classements')
            active
        @endif">
        <i class="trophy icon"></i>
        Classements
    </a>
    @if (Auth::guest())
        <a class="clickLogin item">
            Connexion
            <i class="sign in icon"></i>
        </a>
        <a class="clickRegister item">
            Inscription
            <i class="wizard icon"></i>
        </a>
    @else
        <a href="{{ route('user.profile', Auth::user()->username) }}" class="item">
            <img class="ui avatar image" src="{{ Gravatar::src(Auth::user()->email) }}">
            {{ Auth::user()->username }}
        </a>
        <div class="menu">
            @if(Auth::user()->role < 4)
                <a class="item" href="{{ route('admin')}}">
                    <i class="lock icon"></i>
                    Administration
                </a>
            @endif
            <a class="item" href="">
               <i class="alarm icon"></i>
               Notifications
            </a>
            <a class="item" href="{{ route('user.profile', Auth::user()->username) }}">
                <i class="user icon"></i>
                Profil
            </a>
            <a class="item" href="{{ route('logout') }}">
                <i class="sign out icon"></i>
                Se déconnecter
            </a>
        </div>
    @endif
</div>
<div class="pusher">
    <div class="ui tablet only mobile only grid header">
        <div class="ui  secondary pointing fluid menu">
            <a href="/"><img src="{{ $folderImages }}logo_v2_ho.png" alt="logo_serieall" height="50px"/></a>
            <div class="right secondary pointing stackable menu">
                <a class="item sidebarIcon"><i class="big sidebar icon"></i>Menu</a>
            </div>
        </div>
    </div>
    <div class="ui computer only grid header">
    <div class="ui  secondary pointing fluid stackable menu" id="header">
        <a href="/"><img src="{{ $folderImages }}logo_v2_ho.png" alt="logo_serieall" height="50px"/></a>
        <a href="{{ route('show.index') }}" class="item
            @if($navActive == 'shows')
                active
            @endif">
            Séries TV
        </a>
        <a href="{{ route('article.index') }}" class="item
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
            @if($navActive == 'classements')
                active
            @endif">
            Classements
        </a>
        <div class="right secondary pointing stackable menu">
            <div class="item ui search dropdown showDropdown">
                <div class="ui icon input">
                    <input class="prompt" placeholder="Rechercher une série...">
                    <i class="search icon"></i>
                </div>
                <div class="results">
                </div>
            </div>

            <a class="item
                @if($navActive == 'forum')
                    active
                @endif">
                Forum
            </a>
            @if (Auth::guest())
                <a class="clickLogin item
                    @if($navActive == 'login')
                        active
                    @endif">
                    <div>
                        Connexion
                        <i class="sign in icon"></i>
                    </div>
                </a>
                <a class="clickRegister item
                    @if($navActive == 'register')
                        active
                    @endif">
                    <div>
                        Inscription
                        <i class="wizard icon"></i>
                    </div>
                </a>
            @else

                <div class="icon item">
                    <i class="large alarm icon"></i>
                </div>
                <div class="ui pointing labeled icon dropdown link item" @if($navActive == 'profil')id="profil-actif"@endif>
                    <img class="ui avatar image" src="{{ Gravatar::src(Auth::user()->email) }}">
                    <span>{{ Auth::user()->username }}</span> <i class="dropdown icon"></i>
                    <div class="menu">
                        @if(Auth::user()->role < 4)
                            <a href="{{ route('admin')}}">
                                <div class="item">
                                    <i class="lock icon"></i>
                                    Administration
                                </div>
                            </a>
                        @endif
                        <a href="{{ route('user.profile', Auth::user()->username) }}">
                            <div class="item">
                                <i class="user icon"></i>
                                Profil
                            </div>
                        </a>

                        <a href="{{ route('logout') }}">
                            <div class="item">
                                <i class="sign out icon"></i>
                                Se déconnecter
                            </div>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
    </div>

    @if (session('status') || session('success') || session('error') || session('warning'))
        <div class="ui centered stackable grid" id="messageBox">
            <div class="ten wide column center aligned">
                <div class="ui
                 @if (session('success'))
                    success
                 @endif
                 @if (session('status'))
                    success
                 @endif
                 @if (session('warning'))
                    orange
                 @endif
                 @if (session('error'))
                     red
                 @endif
                 compact message">
                    <i class="close icon"></i>
                    <div class="content">
                        @if (session('success'))
                            <p>{{ session('success') }}</p>
                        @endif
                        @if (session('status'))
                            <p>{{ session('status') }}</p>
                        @endif
                        @if (session('warning'))
                            <p>{{ session('warning') }}</p>
                        @endif
                        @if (session('error'))
                            <p>{{ session('error') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="ui centered stackable grid" id="content">
        @yield('content')
    </div>

<div class="ui coupled modal">
    <div id="loginModal" class="ui tiny first modal">
        <div class="header">
            Connexion
        </div>
        <div class="content">
            <form id="formLogin" class="ui form" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="ui required field">
                    <label>Nom d'utilisateur</label>
                    <input name="username" placeholder="Nom d'utilisateur" value="{{ old('username') }}">
                    <div class="ui red hidden message"></div>
                </div>

                <div class="ui required field">
                    <label>Mot de passe</label>
                    <input name="password" placeholder="Mot de passe" type="password" value="{{ old('password') }}">
                    <div class="ui red hidden message"></div>
                </div>

                <div class="field">
                    <div class="ui checkbox">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Se souvenir de moi</label>
                    </div>

                    <div class="ui red hidden message"></div>
                </div>

                <div class="div-center">
                    <button class="ui submit positive button">Se connecter</button>
                    <br />
                    <a class="ui" href="{{ url('/password/reset') }}">Mot de passe oublié ?</a>
                </div>
            </form>
            <div class="ui tertiary inverted segment">
                <button id="goToSecondModal" class="ui fluid right labeled icon button">
                    <i class="right arrow icon"></i>
                    Pas encore membre ? Créez un compte !
                </button>
            </div>
        </div>
    </div>

    <div id="registerModal" class="ui tiny second modal">
        <div class="header">
            Inscription
        </div>
        <div class="content">

            <div class="ui positive hidden message">
                <div class="header">
                    Inscription terminée
                </div>
                <p>Nous vous avons envoyé un e-mail de confirmation.</p>
            </div>

            <form id="formRegister" class="ui form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}

                <div class="ui required field">
                    <label>Nom d'utilisateur</label>
                    <input name="username" placeholder="Nom d'utilisateur" type="text" value="{{ old('username') }}">

                    <div class="ui red hidden message"></div>
                </div>

                <div class="ui required field">
                    <label>Adresse E-mail</label>
                    <input name="email" placeholder="Adresse e-mail" type="email" value="{{ old('email') }}">

                    <div class="ui red hidden message"></div>
                </div>

                <div class="ui required field">
                    <label>Mot de passe</label>
                    <input name="password" placeholder="Mot de passe" type="password" value="{{ old('password') }}">

                    <div class="ui red hidden message"></div>
                </div>

                <div class="ui required field">
                    <label>Confirmer le mot de passe</label>
                    <input name="password_confirmation" placeholder="Confirmer le mot de passe" type="password" value="{{ old('password_confirmation') }}">

                    <div class="ui red hidden message"></div>
                </div>

                <div class="ui section divider"></div>

                <div class="ui required field">
                    {!! NoCaptcha::renderJs('fr') !!}
                    {!! NoCaptcha::display() !!}

                    <div class="captchaError ui red hidden message"></div>
                </div>

                <div class="ui required field">
                    <div class="ui checkbox">
                        <input type="checkbox" name="cgu">
                        <label for="cgu">J'ai lu et j'accepte les <a href="{{ route('cgu') }}">conditions générales d'utilisation</a></label>
                    </div>

                    <div class="ui red hidden message"></div>
                </div>

                <div class="div-center">
                    <button class="positive ui submit button">S'incrire !</button>
                </div>
            </form>
        </div>
    </div>
</div>

    @include('layouts.base_footer')
</div>
</body>
@include('layouts.base_js')
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    @include('layouts.base_head')
</head>
<body id="body">
    <div class="ui secondary pointing fluid stackable menu" id="header">
        <a href="/"><img src="{{ $folderImages }}logo_v2_ho.png" alt="logo_serieall" height="50px"/></a>
        <a href="{{ route('show.index') }}" class="item
            @if($navActive == 'shows')
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
            @if($navActive == 'classements')
                active
            @endif">
            Classements
        </a>
        <div class="right secondary pointing stackable menu">
            <div id="showDropdown" class="item ui search dropdown">
                <div class="ui icon input">
                    <input class="prompt" placeholder="Rechercher une série..." type="text">
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
                <a class="item
                    @if($navActive == 'login')
                        active
                    @endif" href="{{ url('/login') }}">
                    <div>
                        Connexion
                        <i class="sign in icon"></i>
                    </div>
                </a>
                <a class="item
                    @if($navActive == 'register')
                        active
                    @endif" href="{{ url('/register') }}">
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

    @include('layouts.base_footer')
</body>
@include('layouts.base_js')
</html>

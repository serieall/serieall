<!DOCTYPE html>
<html lang="en" id="html-admin">
<head>
    @include('layouts.base_head')
</head>
<body>
    <div class="ui left fixed vertical menu">
        <div class="item">
            <img class="ui centered image" src="{{ $folderImages }}logo_v2.png">
        </div>
        <a class="ui header item
            @if($navActive === 'AdminHome')
                blue
            @endif" href="{{ route('admin') }}">
            <i class="home icon"></i>
            Accueil
        </a>
        <a class="ui header item
             @if($navActive === 'AdminShows')
                blue
             @endif" href="{{ route('admin.shows.index') }}">
            <i class="tv icon"></i>
            Séries
        </a>
        <a class="ui header item
             @if($navActive === 'AdminArticles')
                blue
             @endif" href="{{ route('admin.articles.index') }}">
            <i class="file text outline icon"></i>
            Articles
        </a>
        <a class="ui header item
            @if($navActive === 'AdminUsers')
                blue
            @endif" href="{{ route('admin.users.index') }}">
            <i class="users icon"></i>
            Utilisateurs
        </a>
        <a class="ui header item
            @if($navActive === 'AdminSystem')
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
        <div class="ui stackable menu" id="menuAdmin">
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
        <div class="p-2">
            @if (session('status'))
                <div id="messageTop" class="ui container centered grid">
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
                <div id="messageTop" class="ui container centered grid">
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

            <div class="admin">
                @yield('content')
            </div>
        </div>
    </div>
</body>
@include('layouts.base_js')
</html>
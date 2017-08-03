@extends('layouts.fiche')

@section('menu_fiche')
    <div id="menuFiche" class="row">
        <div class="column">
            <div class="ui fluid six item stackable menu">
                <a class="item" href="{{ route('show.fiche', $showInfo['show']->show_url) }}">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="active item">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="item" href="{{ route('show.details', $showInfo['show']->show_url) }}">
                    <i class="big list icon"></i>
                    Informations détaillées
                </a>
                <a class="item">
                    <i class="big comments icon"></i>
                    Avis
                </a>
                <a class="item">
                    <i class="big write icon"></i>
                    Articles
                </a>
                <a class="item">
                    <i class="big line chart icon"></i>
                    Statistiques
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_left')
    <div id="showDetails" class="ui segment">
        <h1>Informations sur l'épisode</h1>
        <table class="ui basic table">
            <tr>
                <td>
                    <span class="ui bold text">Titre original</span>
                </td>
                <td>
                    {{ $episodeInfo->name }}
                </td>
            </tr>
        </table>
    </div>
@endsection

@section('content_fiche_right')
    <div class="ui stackable grid">
        <div class="row">
            <div class="ui segment center aligned">
                @if($seasonInfo->moyenne > $noteGood)
                    <p class="NoteSeason ui green text">
                @elseif($seasonInfo->moyenne > $noteNeutral && $seasonInfo->moyenne < $noteGood)
                    <p class="NoteSeason ui gray text">
                @else
                    <p class="NoteSeason ui red text">
                        @endif
                        {{ $seasonInfo->moyenne }}
                    </p>
                    <p>
                        {{ $seasonInfo->nbnotes }} notes
                    </p>

                    <div class="ui divider"></div>

                    <div class="ui feed">
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', 'Youkoulayley') }}" class="user">
                                        Youkoulayley
                                    </a>
                                    a noté <a href="">{{ $seasonInfo->name }}.01</a> -
                                    <span class="ui green text">
                                        15
                                    </span>
                                    <div class="date"> 1 Hour Ago </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>

        <div class="row">
            <div id="LastArticles" class="ui segment">
                <h1>Derniers articles sur l'épisode</h1>
                <div class="ui stackable grid">
                    <div class="row">
                        <div class="center aligned four wide column">
                            <img src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Affiche {{ $showInfo['show']->name }}" />
                        </div>
                        <div class="eleven wide column">
                            <a><h2>Critique 01.03</h2></a>
                            <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="center aligned four wide column">
                            <img src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Affiche {{ $showInfo['show']->name }}" />
                        </div>
                        <div class="eleven wide column">
                            <a><h2>Critique 01.02</h2></a>
                            <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="center aligned four wide column">
                            <img src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Affiche {{ $showInfo['show']->name }}" />
                        </div>
                        <div class="eleven wide column">
                            <a><h2>Critique 01.01</h2></a>
                            <p class="ResumeArticle">Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                        </div>
                    </div>
                </div>
                <a href="#"><p class="AllArticles">Tous les articles ></p></a>
            </div>
        </div>
    </div>
@endsection


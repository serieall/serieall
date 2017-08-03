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

@section('content_fiche_width')
    <div id="MiddleBlockShow" class="sixteen wide column">
        <div class="row center aligned">
            <div class="ui stackable secondary menu">
                <div class="ui segment">
                    <div id="seasonsLine" class="ui stackable grid">
                        @foreach($showInfo['show']->seasons as $season)
                            <a class="
                            @if($seasonInfo->name == $season->name)
                                    active
                            @endif
                            item" href="{{ route('show.seasons', [$showInfo['show']->show_url, $season->name]) }}">Saison {{ $season->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_left')
    <div class="ui stackable grid">
        <div class="row">
            <div id="ListSeasons" class="ui segment">
                <h1>Liste des épisodes</h1>
                    <table class="ui padded table center aligned">
                        @foreach($seasonInfo->episodes as $episode)
                            <tr>
                                <td>
                                    @if($episode->numero == 0)
                                        <a href="{{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $episode->numero]) }}">Episode spécial</a>
                                    @else
                                        <a href="{{ route('show.episodes', [$showInfo['show']->show_url, $seasonInfo->name, $episode->numero]) }}">Episode {{ $seasonInfo->name }}.{{ $episode->numero }}</a>
                                    @endif
                                </td>
                                <td>
                                    {{ $episode->name }}
                                </td>
                                <td>
                                    @if($episode->moyenne > $noteGood)
                                        <p class="ui green text">
                                    @elseif($episode->moyenne > $noteNeutral && $episode->moyenne < $noteGood)
                                        <p class="ui gray text">
                                    @else
                                        <p class="ui red text">
                                            @endif
                                            {{ $episode->moyenne }}
                                        </p>

                                </td>
                                <td>
                                    24
                                    <i class="green smile large icon"></i>

                                    12
                                    <i class="grey meh large icon"></i>

                                    3
                                    <i class="red frown large icon"></i>
                                </td>
                            </tr>
                        @endforeach
                    </table>
            </div>
        </div>

        <div class="row">
            <div id="ListAvis" class="ui segment">
                <h1>Derniers avis sur la saison</h1>
                <div class="ui stackable grid">
                    <div class="row">
                        <div class="center aligned three wide column">
                            <img class="ui tiny image" src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            <span>Youkoulayley</span><br />
                            <span class="ui red text">Administrateur</span>
                        </div>
                        <div class="AvisBox center aligned twelve wide column">
                            <table class="ui grey left border table">
                                <tr>
                                    <td class="ui grey text AvisStatus">Avis neutre</td>
                                    <td class="right aligned">Déposé le 26/05/2017 à 9h53</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="AvisResume">
                                        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam
                                            dicta dolorem excepturi non nulla, obcaecati quo rerum sequi sint? Ab
                                            cumque deserunt doloribus iste, molestias provident quia repellat
                                            repellendus soluta?
                                        </div>
                                        <div>A culpa eius esse laboriosam neque nobis odio, sapiente. Aliquam
                                            animi, at consectetur earum eos itaque iure modi nisi nulla odio
                                            perspiciatis ...
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui grey text">10 réponses</td>
                                    <td class="LireAvis"><a>Lire l'avis complet ></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="center aligned three wide column">
                            <img class="ui tiny image" src="{{ Gravatar::src('bmayelle@hotmail.fr') }}">
                            <span>Youkoulayley</span><br />
                            <span class="ui red text">Administrateur</span>
                        </div>
                        <div class="AvisBox center aligned twelve wide column">
                            <table class="ui green left border table">
                                <tr>
                                    <td class="ui green text AvisStatus">Avis favorable</td>
                                    <td class="right aligned">Déposé le 26/05/2017 à 9h53</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="AvisResume">
                                        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aperiam
                                            dicta dolorem excepturi non nulla, obcaecati quo rerum sequi sint? Ab
                                            cumque deserunt doloribus iste, molestias provident quia repellat
                                            repellendus soluta?
                                        </div>
                                        <div>A culpa eius esse laboriosam neque nobis odio, sapiente. Aliquam
                                            animi, at consectetur earum eos itaque iure modi nisi nulla odio
                                            perspiciatis ...
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ui grey text">10 réponses</td>
                                    <td class="LireAvis"><a>Lire l'avis complet ></a></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="three wide column">

                        </div>
                        <div class="twelve wide column">
                            <div class="ui DarkBlueSerieAll button">
                                <i class="write icon"></i> Ecrire un avis
                            </div>
                            <a class="AllAvis" href="#"><p>Toutes les avis ></p></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <h1>Derniers articles sur la saison</h1>
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
@extends('layouts.fiche')

@section('menu_fiche')
    <div id="menuFiche" class="menuFiche row">
        <div class="column">
            <div class="ui fluid six item stackable menu ficheContainer">
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
    <div id="episodeDetails" class="ui segment">
        <h1>
            @if(!empty($episodeInfo->name_fr))
                {{ $episodeInfo->name_fr }}
            @else
                {{ $episodeInfo->name }}
            @endif
        </h1>
        <h2 class="ui episode titreen">
            @if(!empty($episodeInfo->name_fr))
                {{ $episodeInfo->name }}
            @endif
        </h2>
        <p>
            @if(empty($episodeInfo->resume_fr))
                @if(empty($episodeInfo->resume))
                    Pas de résumé pour l'instant ...
                @else
                    {{ $episodeInfo->resume }}
                @endif
            @else
                {{ $episodeInfo->resume_fr }}
            @endif
        </p>
        <div class="ui divider"></div>

        <table class="ui basic table">
                <thead>
                    <tr>
                        @if($episodeInfo->diffusion_us != '0000-00-00')
                            <th>
                                <i class="calendar icon"></i>
                                Diffusion originale
                            </th>
                        @endif
                        @if($episodeInfo->diffusion_fr != '0000-00-00')
                            <th>
                                <i class="calendar icon"></i>
                                <p class="ui bold text">Diffusion française</p>
                            </th>
                        @endif
                    </tr>
                </thead>
            <tr>
                @if($episodeInfo->diffusion_us != '0000-00-00')
                    <td>
                        {{ $episodeInfo->diffusion_us }}
                    </td>
                @endif
                @if($episodeInfo->diffusion_fr != '0000-00-00')
                    <td>
                        {{ $episodeInfo->diffusion_fr }}
                    </td>
                @endif
            </tr>
        </table>

    </div>
@endsection

@section('content_fiche_right')
    <div class="ui stackable grid">
        <div class="row">
            <div class="ui segment center aligned">
                @if($episodeInfo->moyenne > $noteGood)
                    <p class="NoteSeason ui green text">
                @elseif($episodeInfo->moyenne > $noteNeutral && $episodeInfo->moyenne < $noteGood)
                    <p class="NoteSeason ui gray text">
                @else
                    <p class="NoteSeason ui red text">
                        @endif
                        {{ $episodeInfo->moyenne }}
                    </p>
                    <p>
                        {{ $episodeInfo->nbnotes }} notes
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


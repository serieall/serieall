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
    <div id="menuListSeasons" class="row">
        <div class="column ficheContainer">
            <div class="ui segment">
                <div class="ui stackable secondary menu">
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
                                <td class="left aligned">
                                    {!! affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $episode->numero, $episode->id, true, true) !!}
                                </td>
                                <td class="left aligned">
                                    @if(!empty($episode->name_fr))
                                        {{ $episode->name_fr }}
                                    @else
                                        {{ $episode->name }}
                                    @endif
                                </td>
                                <td>
                                    {{ $episode->diffusion_us }}
                                </td>
                                <td>
                                    @if($episode->moyenne < 1)
                                        <p class="ui black text">
                                            -
                                        </p>
                                    @else
                                        {!! affichageNote($episode->moyenne) !!}
                                    @endif
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
            @include('comments.listavis')
        </div>
    </div>
@endsection

@section('content_fiche_right')
    <div class="ui stackable grid">
        <div class="row">
            <div class="ui segment center aligned">
                @if($seasonInfo->moyenne < 1)
                    <p class="NoteSeason">
                        -
                    </p>
                    <p>
                        Pas encore de notes
                    </p>
                @else
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
                        {{ $seasonInfo->nbnotes }}
                        @if($seasonInfo->nbnotes <= 1)
                            note
                        @else
                            notes
                        @endif
                    </p>
                @endif

                <div class="ui divider"></div>

                <div class="ui feed">
                    @foreach($ratesSeason['users'] as $rate)
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src($rate['user']['email']) }}">
                            </div>
                            <div class="content">
                                <div class="summary">
                                    <a href="{{ route('user.profile', $rate['user']['username']) }}" class="user">
                                        {{ $rate['user']['username'] }}
                                    </a>
                                    a noté {!! affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $rate['episode']['numero'], $rate['episode']['id'], true, false) !!} - {!! affichageNote($rate['rate']) !!}

                                    <div class="date">{{ date('d-m-Y', strtotime($rate['updated_at'])) }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
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


@extends('layouts.fiche')

@section('content_fiche')

    <div id="menuFiche" class="row">
        <div class="column">
            <div class="ui fluid six item stackable menu">
                <a class="active item">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="item">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="item">
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

    <div class="row ui stackable grid">
        <div id="LeftBlockShow" class="ten wide column">
            <div class="ui stackable grid">
                <div class="row">
                    <div id="ListSeasons" class="ui segment">
                        <h1>Liste des saisons</h1>
                        <table class="ui padded table center aligned">
                            @foreach($seasons as $season)
                                <tr>
                                    <td>
                                        <a href="#">Saison {{ $season->name }}</a>
                                    </td>
                                    <td>
                                        @if($season->moyenne > $noteGood)
                                            <p class="ui green text">
                                        @elseif($season->moyenne > $noteNeutral && $season->moyenne < $noteGood)
                                            <p class="ui gray text">
                                        @else
                                            <p class="ui red text">
                                        @endif
                                            {{ $season->moyenne }}
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
                                    <td>
                                        {{ $season->episodes_count }} épisodes
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <a href="#"><p class="AllSeasons">Toutes les saisons ></p></a>
                    </div>
                </div>
                <div class="row">
                    <div id="ListAvis" class="ui segment">
                        <h1>Derniers avis sur la série</h1>

                    </div>
                </div>
            </div>
        </div>
        <div id="RightBlockShow" class="five wide column">
            <div class="ui stackable grid">
                <div class="row">
                    <div id="ButtonsActions">
                        <div class="ui segment">
                            <div class="ui fluid icon dropdown DarkBlueSerieAll button">
                                <span class="text"><i class="tv icon"></i>Actions sur la série</span>
                                <div class="menu">
                                    <div class="item">
                                        <i class="play icon"></i>
                                        Je regarde la série
                                    </div>
                                    <div class="item">
                                        <i class="pause icon"></i>
                                        Je met en pause la série
                                    </div>
                                    <div class="item">
                                        <i class="stop icon"></i>
                                        J'abandonne la série
                                    </div>
                                </div>
                            </div>
                            <button class="ui fluid button">
                                <i class="calendar icon"></i>
                                J'ajoute la série dans mon planning
                            </button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="LastArticles" class="ui segment">
                        <h1>Derniers articles sur la série</h1>
                        <div class="ui stackable grid">
                            <div class="row">
                                <div class="center aligned four wide column">
                                    <img src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Affiche {{ $show->name }}" />
                                </div>
                                <div class="eleven wide column">
                                    <a><h2>Critique 01.03</h2></a>
                                    <p>Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="center aligned four wide column">
                                    <img src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Affiche {{ $show->name }}" />
                                </div>
                                <div class="eleven wide column">
                                    <a><h2>Critique 01.02</h2></a>
                                    <p>Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="center aligned four wide column">
                                    <img src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Affiche {{ $show->name }}" />
                                </div>
                                <div class="eleven wide column">
                                    <a><h2>Critique 01.01</h2></a>
                                    <p>Ceci est une critique test, et on parle et on parle, tout ça pour faire des vues, nianiania...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">
                        <h1>Séries similaires</h1>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

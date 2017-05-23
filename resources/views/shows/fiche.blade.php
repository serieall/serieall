@extends('layouts.app')

@section('content')

    <div id="topImageShow"  class="row nobox">
        <div class="column">
            <img class="topImageBanniere" src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Bannière {{ $show->name }}" />
            <div id="topInfo" class="ui stackable grid">
                <div class="center aligned ten wide column">
                    <div class="ui centered stackable grid">
                        <div id="midaligned" class="four wide column">
                            <div class="topImageAffiche">
                                <img  src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Affiche {{ $show->name }}" />
                            </div>
                        </div>
                        <div class="twelve wide column">
                            <h1>{{ $show->name }}</h1>
                            @if($show->name != $show->name_fr)
                                <h2>{{ $show->name_fr }}</h2>
                            @endif

                            <p>
                                {{ $show->synopsis_fr }}
                            </p>

                            <table class="ui basic fixed table">
                                <tr>
                                    <td>
                                        @if( $show->encours == 1)
                                            <span class="ui green text">
                                                <i class="checkmark icon"></i>
                                                En cours
                                            </span>
                                        @else
                                            <span class="ui red text">
                                                <i class="remove icon"></i>
                                                Terminée
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if(empty($nationalities))
                                            <span class="ui grey text">Pas de nationalité</span>
                                        @else
                                            {{ $nationalities }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(empty($show->format))
                                            <span class="ui grey text">Pas de durée</span>
                                        @else
                                            {{ $show->format }} minutes
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(empty($genres))
                                            <span class="ui grey text">Pas de genre</span>
                                        @else
                                            {{ $genres }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(empty($channels))
                                            <span class="ui grey text">Pas de chaîne</span>
                                        @else
                                            {{ $channels }}
                                        @endif
                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </table>

                        </div>
                    </div>
                </div>
                <div class="center aligned five wide column">
                    <svg class="circleNote">
                        <g>
                            <circle cx="100" cy="100" r="90" fill="none" stroke="#ffffff" stroke-width="10" ></circle>
                            <circle @if($show->moyenne > $noteGood)
                                        class="circleGood"
                                    @elseif($show->moyenne > $noteNeutral && $show->moyenne < $noteGood)
                                        class="circleNeutral"
                                    @else
                                        class="circleBad"
                                    @endif
                                     cx="100" cy="100" r="90" fill="none" stroke="none" transform="rotate(-90 100 100)" stroke-width="20" stroke-dasharray="565.48" stroke-dashoffset="{{ $noteCircle }}" ></circle>
                        </g>
                        <text x="50%" y="58%" text-anchor="middle" fill="white">{{ $show->moyenne }}</text>
                    </svg>
                    <div id="ShowReviewCount">
                        <p>
                            245 avis <span class="ui green text">favorable <i class="green smile large icon"></i></span><br />
                            42 avis <span class="ui grey text">neutre <i class="gray meh large icon"></i></span><br />
                            25 avis <span class="ui red text">défavorable <i class="red frown large icon"></i></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                                        <i class="gray meh large icon"></i>

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
                    <div class="ui segment">
                        <h1>Derniers avis sur la série</h1>
                    </div>
                </div>
            </div>
        </div>
        <div id="RightBlockShow" class="five wide column">
            <div class="ui stackable grid">
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div id="topImageShow"  class="row nobox">
        <div class="column">
            <div class="topImageBanniereContainer">
                <img class="topImageBanniere" src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
            </div>
            <div id="topInfo" class="ui stackable grid topInfo ficheContainer">
                <div class="center aligned ten wide column">
                    <div class="ui centered stackable grid">
                        <div id="midaligned" class="four wide column">
                            <div class="topImageAffiche">
                                <img src="{!! ShowPicture($showInfo['show']->show_url) !!}" />
                            </div>
                        </div>
                        <div class="twelve wide column">
                            <h1>{{ $showInfo['show']->name }}</h1>
                            @if($showInfo['show']->name != $showInfo['show']->name_fr)
                                <h2>{{ $showInfo['show']->name_fr }}</h2>
                            @endif

                            <p class="showResume">
                                {{ $showInfo['showSynopsis'] }}
                            </p>

                            @if($showInfo['fullSynopsis'])
                                <a href="{{ route('show.details', $showInfo['show']->show_url) }}#showDetails">
                                    <p class="AllSynopsis">Lire le résumé complet ></p>
                                </a>
                            @endif

                            <table class="ui computer only basic fixed table">
                                <tr>
                                    <td>
                                        @if( $showInfo['show']->encours == 1)
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
                                        @if(empty($showInfo['nationalities']))
                                            <span class="ui grey text">Pas de nationalité</span>
                                        @else
                                            {{ $showInfo['nationalities'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(empty($showInfo['show']->format))
                                            <span class="ui grey text">Pas de durée</span>
                                        @else
                                            {{ $showInfo['show']->format }} minutes
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(empty($showInfo['genres']))
                                            <span class="ui grey text">Pas de genre</span>
                                        @else
                                            {{ $showInfo['genres'] }}
                                        @endif
                                    </td>
                                    <td>
                                        @if(empty($showInfo['channels']))
                                            <span class="ui grey text">Pas de chaîne</span>
                                        @else
                                            {{ $showInfo['channels'] }}
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
                            <circle cx="100" cy="100" r="90" fill="none" stroke="#ffffff" stroke-width="20"></circle>

                            <defs>
                                <linearGradient id="linear-good" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%"   stop-color="#21BA45"/>
                                    <stop offset="100%" stop-color="#7CB78A"/>
                                </linearGradient>
                                <linearGradient id="linear-neutral" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%"   stop-color="#767676"/>
                                    <stop offset="100%" stop-color="#B7B7B7"/>
                                </linearGradient>
                                <linearGradient id="linear-bad" x1="0%" y1="0%" x2="100%" y2="0%">
                                    <stop offset="0%"   stop-color="#DB2828"/>
                                    <stop offset="100%" stop-color="#D86363"/>
                                </linearGradient>
                            </defs>

                            <circle cx="100" cy="100" r="90" fill="none"
                                    @if($showInfo['show']->moyenne >= $noteGood)
                                        stroke="url(#linear-good)"
                                    @elseif($showInfo['show']->moyenne >= $noteNeutral && $showInfo['show']->moyenne < $noteGood)
                                        stroke="url(#linear-neutral)"
                                    @else
                                        stroke="url(#linear-bad)"
                                    @endif
                                    transform="rotate(-90 100 100)" stroke-width="20" stroke-dasharray="565.48" stroke-dashoffset="{{ $showInfo['noteCircle'] }}"></circle>
                        </g>
                        <text x="50%" y="58%" text-anchor="middle" fill="white">
                            @if($showInfo['show']->moyenne < 1)
                                -
                            @else
                                {{ $showInfo['show']->moyenne }}
                            @endif
                        </text>
                    </svg>
                    <div id="ShowReviewCount">
                        <p>
                            {{ affichageCountThumb($showInfo['showPositiveComments']) }} avis <span class="ui green text">favorable <i class="green smile large icon"></i></span><br />
                            {{ affichageCountThumb($showInfo['showNeutralComments']) }} avis <span class="ui light grey text">neutre <i class="ui text light grey meh large icon"></i></span><br />
                            {{ affichageCountThumb($showInfo['showNegativeComments']) }} avis <span class="ui red text">défavorable <i class="red frown large icon"></i></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="menuFiche" class="menuFiche row">
        <div class="column">
            <div class="ui fluid six item stackable menu ficheContainer">
                <a class="@if($FicheActive == "home") active @endif item" href="{{ route('show.fiche', $showInfo['show']->show_url) }}">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="@if($FicheActive == "seasons") active @endif item" href="{{ route('season.fiche', [$showInfo['show']->show_url, '1']) }}">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="@if($FicheActive == "details") active @endif item" href="{{ route('show.details', $showInfo['show']->show_url) }}">
                    <i class="big list icon"></i>
                    Détails
                </a>
                <a class="@if($FicheActive == "comments") active @endif item" href="{{ route('comment.fiche', $showInfo['show']->show_url) }}">
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

    @yield('menu_fiche')

    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlockShow" class="ten wide column">
            @yield('content_fiche_left')
        </div>
        <div id="RightBlockShow" class="five wide column">
            @yield('content_fiche_right')
        </div>
    </div>

@endsection
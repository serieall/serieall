@extends('layouts.app')

@section('content')
    <div id="topImageShow"  class="row nobox">
        <div class="column">
            <img class="topImageBanniere" src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Bannière {{ $showInfo['show']->name }}" />
            <div id="topInfo" class="ui stackable grid">
                <div class="center aligned ten wide column">
                    <div class="ui centered stackable grid">
                        <div id="midaligned" class="four wide column">
                            <div class="topImageAffiche">
                                <img  src="{{ $folderShows }}/{{ $showInfo['show']->show_url }}.jpg" alt="Affiche {{ $showInfo['show']->name }}" />
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
                            <circle cx="100" cy="100" r="90" fill="none" stroke="#ffffff" stroke-width="10" ></circle>
                            <circle @if($showInfo['show']->moyenne > $noteGood)
                                    class="circleGood"
                                    @elseif($showInfo['show']->moyenne > $noteNeutral && $showInfo['show']->moyenne < $noteGood)
                                    class="circleNeutral"
                                    @else
                                    class="circleBad"
                                    @endif
                                    cx="100" cy="100" r="90" fill="none" stroke="none" transform="rotate(-90 100 100)" stroke-width="20" stroke-dasharray="565.48" stroke-dashoffset="{{ $showInfo['noteCircle'] }}" ></circle>
                        </g>
                        <text x="50%" y="58%" text-anchor="middle" fill="white">{{ $showInfo['show']->moyenne }}</text>
                    </svg>
                    <div id="ShowReviewCount">
                        <p>
                            245 avis <span class="ui green text">favorable <i class="green smile large icon"></i></span><br />
                            42 avis <span class="ui grey text">neutre <i class="grey meh large icon"></i></span><br />
                            25 avis <span class="ui red text">défavorable <i class="red frown large icon"></i></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('menu_fiche')
    <div class="row ui stackable grid">
        @yield('content_fiche_width')
        <div id="LeftBlockShow" class="ten wide column">
            @yield('content_fiche_left')
        </div>
        <div id="RightBlockShow" class="five wide column">
            @yield('content_fiche_right')
        </div>
    </div>

@endsection
@extends('layouts.app')

@section('pageTitle', 'Profil de ' . $user->username)

@section('content')
    <div class="ui ten wide column">
        <div class="ui center aligned">
            <div class="ui stackable compact pointing menu">
                <a class="item" href="{{ route('user.profile', $user->user_url ) }}">
                    <i class="user icon"></i>
                    Profil
                </a>
                <a class="item" href="{{ route('user.profile.rates', $user->user_url ) }}">
                    <i class="star icon"></i>
                    Notes
                </a>
                <a class="item" href="{{ route('user.profile.comments', $user->user_url ) }}">
                    <i class="comment icon"></i>
                    Avis
                </a>
                <a class="item" href="{{ route('user.profile.shows', $user->user_url ) }}">
                    <i class="tv icon"></i>
                    Séries
                </a>
                <a class="active item">
                    <i class="ordered list icon"></i>
                    Classement
                </a>
                @if(Auth::check())
                    @if($user->username == Auth::user()->username)
                        <a class="item" href="{{ route('user.profile.planning', $user->user_url ) }}">
                            <i class="calendar icon"></i>
                            Mon planning
                        </a>
                        <a class="item" href="{{ route('user.profile.notifications', $user->user_url ) }}">
                            <i class="alarm icon"></i>
                            Notifications
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="ui segment">
            <div class="ui items">
                <div class="ui grid stackable">
                    <div class="eight wide column">
                        <div class="ui items">
                            <div class="item">
                        <span class="ui tiny image">
                            <img src="{{ Gravatar::src($user->email) }}" alt="Avatar de {{$user->username}}">
                        </span>
                                <div class="content">
                                    <a class="header">{{ $user->username }}</a><br />
                                    {!! roleUser($user->role) !!}
                                    <div class="description">
                                        <p>"<i>{{ $user->edito }}"</i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ui statistic">
                            <div class="label">
                                <i class="tv icon"></i>
                                {{ $time_passed_shows }} devant l'écran
                            </div>
                        </div>
                    </div>
                    <div class="ui center aligned eight wide column">
                        <div class="ui three statistics">
                            <div class="ui statistic">
                                <div class="label">
                                    Moyenne
                                </div>
                                <div class="value">
                                    {!! affichageNote($avg_user_rates->avg) !!}
                                </div>
                            </div>
                            <div class="ui statistic">
                                <div class="label">
                                    Nombre de notes
                                </div>
                                <div class="value">
                                    {{$avg_user_rates->nb_rates}}
                                </div>
                            </div>
                            <div class="ui statistic">
                                <div class="label">
                                    Nombre d'avis
                                </div>
                                <div class="value">
                                    {{$nb_comments}}
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="ui mini three statistics">
                            <div class="statistic">
                                <div class="value">
                                    <i class="green smile icon"></i>
                                    @if($comment_fav)
                                        {{ $comment_fav->total }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="label">
                                    Favorables
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="grey meh icon"></i>
                                    @if($comment_neu)
                                        {{ $comment_neu->total }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="label">
                                    Neutres
                                </div>
                            </div>
                            <div class="statistic">
                                <div class="value">
                                    <i class="red frown icon"></i>
                                    @if($comment_def)
                                        {{ $comment_def->total }}
                                    @else
                                        0
                                    @endif
                                </div>
                                <div class="label">
                                    Défavorables
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(!empty($user->facebook) || !empty($user->twitter) || !empty($user->website))
                <h3>Ses liens :</h3>
                @if(!empty($user->facebook))
                    <button class="ui facebook button" onclick="window.location.href='https://www.facebook.com/{{ $user->facebook }}'">
                        <i class="facebook icon"></i>
                        Facebook
                    </button>
                @endif

                @if(!empty($user->twitter))
                    <button class="ui twitter button" onclick="window.location.href='https://www.twitter.com/{{ $user->twitter }}'">
                        <i class="twitter icon"></i>
                        Twitter
                    </button>
                @endif

                @if(!empty($user->website))
                    <button class="ui grey button" onclick="window.location.href='{{ $user->website }}'">
                        <i class="at icon"></i>
                        Site Internet
                    </button>
                @endif
            @endif
        </div>

        <div class="ui segment">
            <div class="ui three column grid stackable">
                <div class="column">
                    <h2>Top séries</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">
                            @if(isset($top_shows[0]))
                                <img src="{{ ShowPicture($top_shows[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($top_shows) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($top_shows) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucune série notée.
                        @endcomponent
                    @endif
                    @foreach($top_shows as $show)
                        @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                            <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                        @endcomponent
                    @endforeach
                </div>

                <div class="column">
                    <h2>Top saisons</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">
                            @if(isset($top_seasons[0]))
                                <img src="{{ ShowPicture($top_seasons[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($top_seasons) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($top_seasons) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucune saison notée.
                        @endcomponent
                    @endif
                    @foreach($top_seasons as $season)
                        @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                            <a href="{{ route('season.fiche', [$season->show_url, $season->season_name]) }}">{{ $season->sname }} Saison {{ $season->season_name }}</a>
                        @endcomponent
                    @endforeach
                </div>
                <div class="column">
                    <h2>Top épisodes</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">
                            @if(isset($top_episodes[0]))
                                <img src="{{ ShowPicture($top_episodes[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($top_episodes) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($top_episodes) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucun épisode noté.
                        @endcomponent
                    @endif
                    @foreach($top_episodes as $episode)
                        @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                            <a href="{{ route('episode.fiche', [$episode->show_url, $episode->season_name, $episode->numero, $episode->id]) }}">{{$episode->sname}} / {{ sprintf('%02s', $episode->season_name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                        @endcomponent
                    @endforeach
                </div>
            </div>
            <div class="ui three column grid stackable">
                <div class="column">
                    <h2>Flop séries</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">
                            @if(isset($flop_shows[0]))
                                <img src="{{ ShowPicture($flop_shows[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($flop_shows) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($flop_shows) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucune série notée.
                        @endcomponent
                    @endif
                    @foreach($flop_shows as $show)
                        @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                            <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                        @endcomponent
                    @endforeach
                </div>
                <div class="column">
                    <h2>Flop saisons</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">

                            @if(isset($flop_seasons[0]))
                                <img src="{{ ShowPicture($flop_seasons[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($flop_seasons) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($flop_seasons) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucune saison notée.
                        @endcomponent
                    @endif
                    @foreach($flop_seasons as $season)
                        @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                            <a href="{{ route('season.fiche', [$season->show_url, $season->season_name]) }}">{{ $season->sname }} Saison {{ $season->season_name }}</a>
                        @endcomponent
                    @endforeach
                </div>
                <div class="column">
                    <h2>Flop épisodes</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">
                            @if(isset($flop_episodes[0]))
                                <img src="{{ ShowPicture($flop_episodes[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($flop_episodes) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($flop_episodes) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucun épisode noté.
                        @endcomponent
                    @endif
                    @foreach($flop_episodes as $episode)
                        @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                            <a href="{{ route('episode.fiche', [$episode->show_url, $episode->season_name, $episode->numero, $episode->id]) }}">{{$episode->sname}} / {{ sprintf('%02s', $episode->season_name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                        @endcomponent
                    @endforeach
                </div>
            </div>
            <div class="ui two column grid stackable">
                <div class="column">
                    <h2>Top pilot</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">
                            @if(isset($top_pilot[0]))
                                <img src="{{ ShowPicture($top_pilot[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($top_pilot) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($top_pilot) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucun pilot noté.
                        @endcomponent
                    @endif
                    @foreach($top_pilot as $episode)
                        @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                            <a href="{{ route('episode.fiche', [$episode->show_url, $episode->season_name, $episode->numero, $episode->id]) }}">{{$episode->sname}} / {{ sprintf('%02s', $episode->season_name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                        @endcomponent
                    @endforeach
                </div>
                <div class="column">
                    <h2>Flop pilot</h2>

                    <div class="ui fluid card imageFirstClassement">
                        <div class="image">
                            @if(isset($flop_pilot[0]))
                                <img src="{{ ShowPicture($flop_pilot[0]->show_url) }}" alt="">
                            @else
                                <img src="{{ ShowPicture($flop_pilot) }}" alt="">
                            @endif
                        </div>
                    </div>
                    @if(count($flop_pilot) == 0)
                        @component('components.message_simple', ['type' => 'info'])
                            Aucun pilot noté.
                        @endcomponent
                    @endif
                    @foreach($flop_pilot as $episode)
                        @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                            <a href="{{ route('episode.fiche', [$episode->show_url, $episode->season_name, $episode->numero, $episode->id]) }}">{{$episode->sname}} / {{ sprintf('%02s', $episode->season_name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                        @endcomponent
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
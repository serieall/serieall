@extends('layouts.app')

@section('pageTitle', 'Classements')

@section('content')
    <div class="ui fourteen wide column">
        <div class="ui segment">
            <h1>Classements des séries</h1>
            <div class="ui stackable pointing secondary menu">
                <a class="active item" data-tab="first">Meilleures séries</a>
                <a class="item" data-tab="second">Par la rédac</a>
                <a class="item" data-tab="third">Par pays</a>
                <a class="item" data-tab="four">Par catégorie</a>
                <a class="item" data-tab="five">Meilleures chaines</a>
            </div>

            <div class="ui active tab segment" data-tab="first">
                <div class="ui three column grid stackable">
                    <div class="column">
                        <h2>Top séries</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_shows[0]->show_url) }}" alt="Image illustrative de {{$top_shows[0]->name}}">
                            </div>
                        </div>
                        @foreach($top_shows as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>

                    <div class="column">
                        <h2>Top saisons</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_seasons[0]->show->show_url) }}" alt="Image illustrative de {{$top_seasons[0]->name}}">
                            </div>
                        </div>
                        @foreach($top_seasons as $season)
                            @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                                <a href="{{ route('season.fiche', [$season->show->show_url, $season->name]) }}">{{$season->show->name}} Saison {{ $season->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top épisodes</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_episodes[0]->show->show_url) }}" alt="Image illustrative de {{$top_episodes[0]->name}}">
                            </div>
                        </div>
                        @foreach($top_episodes as $episode)
                            @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                                <a href="{{ route('episode.fiche', [$episode->show->show_url, $episode->season->name, $episode->numero, $episode->id]) }}">{{$episode->show->name}} / {{ sprintf('%02s', $episode->season->name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                </div>
                <div class="ui three column grid stackable">
                    <div class="column">
                        <h2>Flop séries</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($flop_shows[0]->show_url) }}" alt="Image illustrative de {{$flop_shows[0]->name}}">
                            </div>
                        </div>
                        @foreach($flop_shows as $show)
                            @component('components.classements',  ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Flop saisons</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($flop_seasons[0]->show->show_url) }}" alt="Image illustrative de {{$flop_seasons[0]->name}}">
                            </div>
                        </div>
                        @foreach($flop_seasons as $season)
                            @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                                <a href="{{ route('season.fiche', [$season->show->show_url, $season->name]) }}">{{$season->show->name}} Saison {{ $season->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Flop épisodes</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($flop_episodes[0]->show->show_url) }}" alt="Image illustrative de {{$flop_episodes[0]->name}}">
                            </div>
                        </div>
                        @foreach($flop_episodes as $episode)
                            @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                                <a href="{{ route('episode.fiche', [$episode->show->show_url, $episode->season->name, $episode->numero, $episode->id]) }}">{{$episode->show->name}} / {{ sprintf('%02s', $episode->season->name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="ui tab segment" data-tab="second">
                <div class="ui three column grid stackable">
                    <div class="column">
                        <h2>Top séries</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($redac_top_shows[0]->show_url) }}" alt="Image illustrative de {{$redac_top_shows[0]->name}}">
                            </div>
                        </div>
                        @foreach($redac_top_shows as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top saisons</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($redac_top_seasons[0]->show_url) }}" alt="Image illustrative de {{$redac_top_seasons[0]->name}}">
                            </div>
                        </div>
                        @foreach($redac_top_seasons as $season)
                            @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                                <a href="{{ route('season.fiche', [$season->show_url, $season->name]) }}">{{ $season->sname }} Saison {{ $season->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top épisodes</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($redac_top_episodes[0]->show_url) }}" alt="Image illustrative de {{$redac_top_episodes[0]->name}}">
                            </div>
                        </div>
                        @foreach($redac_top_episodes as $episode)
                            @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                                <a href="{{ route('episode.fiche', [$episode->show_url, $episode->season_name, $episode->numero, $episode->id]) }}">{{$episode->sname}} / {{ sprintf('%02s', $episode->season_name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Flop séries</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($redac_flop_shows[0]->show_url) }}" alt="Image illustrative de {{$redac_flop_shows[0]->name}}">
                            </div>
                        </div>
                        @foreach($redac_flop_shows as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Flop saisons</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($redac_flop_seasons[0]->show_url) }}" alt="Image illustrative de {{$redac_flop_seasons[0]->name}}">
                            </div>
                        </div>
                        @foreach($redac_flop_seasons as $season)
                            @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                                <a href="{{ route('season.fiche', [$season->show_url, $season->name]) }}">{{ $season->sname }} Saison {{ $season->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Flop épisodes</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($redac_flop_episodes[0]->show_url) }}" alt="Image illustrative de {{$redac_flop_episodes[0]->name}}">
                            </div>
                        </div>
                        @foreach($redac_flop_episodes as $episode)
                            @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                                <a href="{{ route('episode.fiche', [$episode->show_url, $episode->season_name, $episode->numero, $episode->id]) }}">{{$episode->sname}} / {{ sprintf('%02s', $episode->season_name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="ui tab segment" data-tab="third">
                <div class="ui four column grid stackable">
                    <div class="column">
                        <h2>Top américain</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                @if(count($country_top_us) < 1)
                                    <img src="/images/shows/default_empty.jpg" alt="">
                                @else
                                    <img src="{{ ShowPicture($country_top_us[0]->show_url) }}"  alt="Image illustrative de {{$country_top_us[0]->name}}">
                                @endif
                            </div>
                        </div>
                        @foreach($country_top_us as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top français</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                @if(count($country_top_fr) < 1)
                                    <img src="/images/shows/default_empty.jpg" alt="">
                                @else
                                    <img src="{{ ShowPicture($country_top_fr[0]->show_url) }}" alt="Image illustrative de {{$country_top_fr[0]->name}}">
                                @endif
                            </div>
                        </div>
                        @foreach($country_top_fr as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top anglais</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                @if(count($country_top_en) < 1)
                                    <img src="/images/shows/default_empty.jpg" alt="">
                                @else
                                    <img src="{{ ShowPicture($country_top_en[0]->show_url) }}" alt="Image illustrative de {{$country_top_en[0]->name}}">
                                @endif
                            </div>
                        </div>
                        @foreach($country_top_en as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="ui tab segment" data-tab="four">
                <div class="ui four column grid stackable">
                    <div class="column">
                        <h2>Top Drame</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                @if(count($genre_top_drama) < 1)
                                    <img src="/images/shows/default_empty.jpg" alt="">
                                @else
                                    <img src="{{ ShowPicture($genre_top_drama[0]->show_url) }}" alt="Image illustrative de {{$genre_top_drama[0]->name}}">
                                @endif
                            </div>
                        </div>
                        @foreach($genre_top_drama as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top Comédie</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                @if(count($genre_top_comedy) < 1)
                                    <img src="/images/shows/default_empty.jpg" alt="">
                                @else
                                    <img src="{{ ShowPicture($genre_top_comedy[0]->show_url) }}" alt="Image illustrative de {{$genre_top_comedy[0]->name}}">
                                @endif
                            </div>
                        </div>
                        @foreach($genre_top_comedy as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top SF</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                @if(count($genre_top_sf) < 1)
                                    <img src="/images/shows/default_empty.jpg" alt="">
                                @else
                                    <img src="{{ ShowPicture($genre_top_sf[0]->show_url) }}" alt="Image illustrative de {{$genre_top_sf[0]->name}}">
                                @endif
                            </div>
                        </div>
                        @foreach($genre_top_sf as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top Policier</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                @if(count($genre_top_cop) < 1)
                                    <img src="/images/shows/default_empty.jpg" alt="">
                                @else
                                    <img src="{{ ShowPicture($genre_top_cop[0]->show_url) }}" alt="Image illustrative de {{$genre_top_cop[0]->name}}">
                                @endif
                            </div>
                        </div>
                        @foreach($genre_top_cop as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="ui tab segment" data-tab="five">
                <div class="ui four column grid stackable">
                    <div class="column">
                        <h2>Top Chaines</h2>

                        <div class="ui card imageFirstClassement">
                            <div class="image">
                                <img src="/images/shows/default_empty.jpg" alt="">
                            </div>
                        </div>
                        @foreach($channel_top_show as $channel)
                            @component('components.classements', ['avg_rate' => $channel->moyenne, 'number_rates' => $channel->nbnotes, 'loop' => $loop])
                                {{ $channel->name }}
                            @endcomponent
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ Html::script('/js/views/ranking/index.js') }}
@endpush
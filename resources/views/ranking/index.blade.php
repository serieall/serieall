@extends('layouts.app')

@section('pageTitle', 'Classements')

@section('content')
    <div class="ui fourteen wide column">
        <div class="ui segment">
            <h1>Classements des séries</h1>
            <div class="ui pointing secondary menu">
                <a class="active item" data-tab="first">Meilleures séries</a>
                <a class="item" data-tab="second">Par la rédac</a>
                <a class="item" data-tab="third">Par pays</a>
                <a class="item" data-tab="four">Par catégorie</a>
                <a class="item" data-tab="five">Meilleures chaines</a>
            </div>

            <div class="ui active tab segment" data-tab="first">
                <div class="ui four column grid stackable">
                    <div class="column">
                        <h2>Top séries</h2>

                        <div class="ui fluid card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_shows[0]->show_url) }}">
                            </div>
                        </div>
                        @foreach($top_shows as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Flop séries</h2>

                        <div class="ui fluid card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_shows[0]->show_url) }}">
                            </div>
                        </div>
                        @foreach($flop_shows as $show)
                            @component('components.classements',  ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top saisons</h2>

                        <div class="ui fluid card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_seasons[0]->show->show_url) }}">
                            </div>
                        </div>
                        @foreach($top_seasons as $season)
                            @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                                <a href="{{ route('season.fiche', [$season->show->show_url, $season->name]) }}">{{$season->show->name}} Saison {{ $season->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Flop saisons</h2>

                        <div class="ui fluid card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($flop_seasons[0]->show->show_url) }}">
                            </div>
                        </div>
                        @foreach($flop_seasons as $season)
                            @component('components.classements', ['avg_rate' => $season->moyenne, 'number_rates' => $season->nbnotes, 'loop' => $loop])
                                <a href="{{ route('season.fiche', [$season->show->show_url, $season->name]) }}">{{$season->show->name}} Saison {{ $season->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                </div>
                <div class="ui four column grid stackable">
                    <div class="column">
                        <h2>Top épisodes</h2>

                        <div class="ui fluid card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_episodes[0]->show->show_url) }}">
                            </div>
                        </div>
                        @foreach($top_episodes as $episode)
                            @component('components.classements', ['avg_rate' => $episode->moyenne, 'number_rates' => $episode->nbnotes, 'loop' => $loop])
                                <a href="{{ route('episode.fiche', [$episode->show->show_url, $episode->season->name, $episode->numero, $episode->id]) }}">{{$episode->show->name}} / {{ sprintf('%02s', $episode->season->name) }}.{{ $episode->numero }} {{ $episode->name }}</a>
                            @endcomponent
                        @endforeach
                    </div>
                    <div class="column">
                        <h2>Top épisodes</h2>

                        <div class="ui fluid card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($flop_episodes[0]->show->show_url) }}">
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
                <div class="ui four column grid stackable">
                    <div class="column">
                        <h2>Top séries</h2>

                        <div class="ui fluid card imageFirstClassement">
                            <div class="image">
                                <img src="{{ ShowPicture($top_shows[0]->show_url) }}">
                            </div>
                        </div>
                        @foreach($redac_top_shows as $show)
                            @component('components.classements', ['avg_rate' => $show->moyenne, 'number_rates' => $show->nbnotes, 'loop' => $loop])
                                <a href="{{ route('show.fiche', $show->show_url) }}">{{ $show->name }}</a>
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
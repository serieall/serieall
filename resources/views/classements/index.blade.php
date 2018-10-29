@extends('layouts.app')

@section('pageTitle', 'Classements')

@section('content')
    <div class="calendar ui fourteen wide column">
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
                        @component('components.classements', ['objects' => $top_shows])
                            @slot('title')
                            Top séries
                            @endslot
                            Show
                        @endcomponent
                    </div>
                    <div class="column">
                        @component('components.classements', ['objects' => $flop_shows])
                            @slot('title')
                                Flop séries
                            @endslot
                            Show
                        @endcomponent
                    </div>
                    <div class="column">
                        @component('components.classements', ['objects' => $top_seasons])
                            @slot('title')
                                Top saisons
                            @endslot
                            Season
                        @endcomponent
                    </div>
                    <div class="column">
                        @component('components.classements', ['objects' => $flop_seasons])
                            @slot('title')
                                Flop saisons
                            @endslot
                            Season
                        @endcomponent
                    </div>
                </div>
                <div class="ui four column grid stackable">
                    <div class="column">
                        @component('components.classements', ['objects' => $top_episodes])
                            @slot('title')
                                Top épisodes
                            @endslot
                            Episode
                        @endcomponent
                    </div>
                    <div class="column">
                        @component('components.classements', ['objects' => $flop_episodes])
                            @slot('title')
                                Flop épisodes
                            @endslot
                            Episode
                        @endcomponent
                    </div>
                </div>
            </div>
            <div class="ui tab segment" data-tab="second">
                <div class="ui four column grid stackable">
                    <div class="column">
                        @component('components.classements', ['objects' => $redac_top_shows])
                            @slot('title')
                                Top séries
                            @endslot
                            Show
                        @endcomponent
                    </div>
            </div>
            <div class="ui tab segment" data-tab="third">
                Coucou
            </div>
            <div class="ui tab segment" data-tab="four">
                Coucou
            </div>
            <div class="ui tab segment" data-tab="five">
                Coucou
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ Html::script('/js/views/classements/index.js') }}
@endpush
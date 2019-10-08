@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable centered grid home">
        <div class="row">
            <div class="four wide column">
                <h1>Fil d'actualité</h1>
                <div class="ui placeholder segment">
                    @include('pages.home_fil_actu')
                </div>
            </div>
            <div class="eight wide column div_show_moment">
                <h1>Les séries du moment</h1>
                <div class="shows_moment">
                    @foreach($shows_moment as $show)
                        <div class="hvr-rotate">
                            <a href="{{ route('show.fiche', $show->show_url) }}">
                                <img src="{{ getImage($show->thetvdb_id, "", $show->show_url, "poster", "170_250") }}" alt="poster">
                                <span class="overlay_shows_moment">{{ $show->name }} | {!! affichageNote($show->moyenne) !!}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <h1>Articles</h1>
                <div class="ui centered stackable cards article home">
                    @foreach($articles as $article)
                        <a class="ui raised card hvr-grow" href="{{ route('article.show', $article->article_url) }}">
                            <div class="content">
                                <div class="ui left aligned text header">{{ $article->name }}</div>
                            </div>
                            <div class="image article">
                                <img src="{{ getImage(0, config('app.url') . $article->image, pathinfo($article->image)['filename'], "banner", "340_100") }}" alt="Image article">
                            </div>
                            <div class="content">
                                <div class="meta">
                                    <i class="ui label {{ colorCategory($article->category->id) }}">{{ $article->category->name }}</i>
                                    <span class="right floated">{{ $article->comments->count() }} <i class="comment icon"></i></span>
                                </div>
                                <div class="description">
                                    <p>{{ $article->intro }}</p>
                                </div>
                            </div>
                            <div class="extra content">
                                <div class="center aligned  author">
                                    Par
                                    @foreach($article->users as $redac)
                                        <img class="ui avatar image" src="{{ Gravatar::src($redac->email) }}" alt="Avatar de {{$redac->username}}"> {{ $redac->username }}
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <h1>Planning</h1>
                <div class="ui piled segment home planning grid three columns">
                        <div class="column">
                            <div class="title b-blueSA">
                                Hier
                            </div>
                            <div class="list episodes">
                                @if($planning['yesterday']->count() != 0)
                                    @foreach($planning['yesterday'] as $episode)
                                        <div class="episode">
                                            @if(count($episode->show->channels) > 0)
                                            <div class="ui red horizontal label">{{ $episode->show->channels[0]->name }}</div>
                                            @endif
                                            {!! printShowEpisode($episode->show->name, $episode->show->show_url, $episode->season->name, $episode->numero, $episode->id) !!}
                                        </div>
                                    @endforeach
                                @else
                                    @component('components.message_simple', ['type' => 'info'])
                                        Pas d'épisodes diffusés hier.
                                    @endcomponent
                                @endif
                            </div>
                        </div>
                    <div class="column">
                        <div class="title b-darkBlueSA">
                            Aujourd'hui
                        </div>
                        <div class="list episodes">
                            @if($planning['today']->count() != 0)
                                @foreach($planning['today'] as $episode)
                                    <div class="episode">
                                        @if(count($episode->show->channels) > 0)
					<div class="ui red horizontal label">{{ $episode->show->channels[0]->name }}</div>
					@endif
					{!! printShowEpisode($episode->show->name, $episode->show->show_url, $episode->season->name, $episode->numero, $episode->id) !!}
                                    </div>
                                @endforeach
                            @else
                                @component('components.message_simple', ['type' => 'info'])
                                    Pas d'épisodes diffusés aujourd'hui.
                                @endcomponent
                            @endif
                        </div>
                    </div>
                    <div class="column">
                        <div class="title b-blueSA">
                            Demain
                        </div>
                        <div class="list episodes">
                            @if($planning['tomorrow']->count() != 0)
                                @foreach($planning['tomorrow'] as $episode)
                                    <div class="episode">
                                        @if(count($episode->show->channels) > 0)
					<div class="ui red horizontal label">{{ $episode->show->channels[0]->name }}</div>
					@endif
                                        {!! printShowEpisode($episode->show->name, $episode->show->show_url, $episode->season->name, $episode->numero, $episode->id) !!}
                                    </div>
                                @endforeach
                            @else
                                @component('components.message_simple', ['type' => 'info'])
                                    Pas d'épisodes diffusés demain.
                                @endcomponent
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="fifteen wide column div_last_added_shows">
                <h1>Les dernières séries ajoutées</h1>
                <div class="last_added_shows">
                    @foreach($last_added_shows as $show)
                        <div class="hvr-rotate">
                            <a href="{{ route('show.fiche', $show->show_url) }}">
                                <img src="{{ getImage($show->thetvdb_id, "", $show->show_url, "poster", "170_250") }}" alt="poster">
                                <span class="overlay_shows_moment">{{ $show->name }} | {!! affichageNote($show->moyenne) !!}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/slick/slick/slick.min.js"></script>

    {{ Html::script('/js/views/pages/home.js')}}
@endpush

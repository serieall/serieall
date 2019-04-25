@extends('layouts.app')

@section('pageTitle', 'Articles')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="ui row stackable grid">
        <div class="header row">
            <div class="background"></div>
            <div class="content">
            <h1>Tous les articles</h1>
            <p class="t-lightBlueSA">
                Liste de tous les articles de Série-All. <br />
                Vous pouvez filtrer les articles en cliquant sur un des boutons ci-dessous
            </p>

            <div class="m-2">
                <a href="{{ route('article.index') }}">
                    <button class="ui button {{$category === 'all' ? 'disabled' : ''}}">Tous les articles</button>
                    <span class="ui hidden message">Afficher tous les types d'articles.</span>
                </a>
                @foreach($categories as $currentCategory)
                    <a href="{{ route('article.indexCategory', strtolower($currentCategory->name)) }}">
                        <button class="ui {{$currentCategory->name === $category ? 'disabled' : ''}} button {{ colorCategory($currentCategory->id) }}">{{ $currentCategory->name }}</button>
                        <span class="ui hidden message">{{ $currentCategory->description }}</span>
                    </a>
                @endforeach
            </div>

            <p class="ui LightBlueSerieAll text description category help">Survolez un bouton pour avoir une description du type d'article.</p>
            </div>
        </div>

        <div class="row ficheContainer">
            <div id="LeftBlock" class="eleven wide column">
                <div class="ui segment">
                    <div class="ui items">
                        @if($articles_count === 0)
                            <div class="ui message info">
                                Pas d'articles dans cette catégorie.
                            </div>
                        @else
                        @foreach($articles as $article)
                            <div class="article item">
                                <div class="ol-{{ colorCategory($article->category_id) }} image article">
                                    <img src="{{ $article->image }}">
                                    <p>{{ $article->category->name }}</p>
                                </div>
                                <div class="content">
                                    <a href="{{  route('article.show', $article->article_url) }}" class="header">{{ $article->name }}</a>
                                    <div class="meta">
                                        <span>Le {!! formatDate('full', $article->published_at) !!}</span>
                                    </div>
                                    <div class="description">
                                        <p>{{ $article->intro }}</p>
                                    </div>
                                    <div class="extra">
                                        Par
                                        @foreach($article->users as $user)
                                            @if($loop->last)
                                                 <img class="ui avatar image" src="{{ Gravatar::src($user->email) }}">
                                                <span>{{ $user->username }}</span>
                                            @else
                                                <img class="ui avatar image" src="{{ Gravatar::src($user->email) }}">
                                                <span>{{ $user->username }}</span>,
                                            @endif
                                        @endforeach

                                        <div class="right floated">
                                            <i class="comment icon"></i>
                                            {{ $article->comments_count }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ui divider"></div>
                        @endforeach
                        @endif
                    </div>
                </div>
                {{ $articles->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var categoryHelp = '.description.category.help';

        // Change description button for category
        $('.header.row .ui.button').hover(function() {
            var text = $(this).next('span').text();
           $(categoryHelp).text(text);
        }, function() {
            $(categoryHelp).text('Survolez un bouton pour avoir une description du type d\'article.');
        });

    </script>
@endpush

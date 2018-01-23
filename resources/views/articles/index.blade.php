@extends('layouts.app')

@section('pageTitle', 'Articles')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="ui row stackable grid">
        <div id="LeftBlockArticle" class="eleven wide column">
            <div class="ui segment">
                <h1>Liste des articles</h1>
                <div class="ui items">
                    @foreach($articles as $article)
                        <div class="article item">
                            <div class="{{ colorCategory($article->category_id) }} image article">
                                <img src="{{ $article->image }}">
                                <p>{{ $article->category->name }}</p>
                            </div>
                            <div class="content">
                                <a href="{{  route('article.show', $article->article_url) }}" class="header">{{ $article->name }}</a>
                                <div class="meta">
                                    <span>Le {{ formatDate('full', $article->published_at) }}</span>
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
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

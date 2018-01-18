@extends('layouts.app')

@section('pageTitle', 'Articles')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlockShow" class="eleven wide column">
            <div class="ui segment">
                <h1>Liste des articles</h1>

                <div class="ui three stackable cards">
                    @foreach($articles as $article)
                        <div class="ui raised green card">
                            <img class="topImageAffiche" style="height:100px; " src="{{ $article->image }}">
                            <div class="content">
                                <div class="header">{{ $article->name }}</div>
                                <div class="meta">
                                    <span class="category">{{ $article->category->name }}</span>
                                </div>
                                <div class="description">
                                    <p>{{ $article->intro }}</p>
                                </div>
                            </div>
                            <div class="extra content">
                                <div class="right floated author">
                                    @foreach($article->users as $redac)
                                        <img class="ui avatar image" src="{{ Gravatar::src($redac->email) }}"> {{ $redac->username }}
                                    @endforeach
                                </div>
                            </div>
                            <a href="{{ route('article.view', $article->article_url) }}">
                                <div class="ui bottom attached button">
                                    <i class="eye icon"></i>
                                    Lire l'article
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

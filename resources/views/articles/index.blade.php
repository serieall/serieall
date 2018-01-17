@extends('layouts.app')

@section('pageTitle', 'Séries TV')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlockShow" class="eleven wide column">
            <div class="ui segment">
                <h1>Liste des articles</h1>


                @foreach($articles as $article)
                    <div class="ui raised link card">
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
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection

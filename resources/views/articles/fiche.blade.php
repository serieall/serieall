@extends('layouts.fiche')

@section('pageTitle', 'Articles - ' . $showInfo['show']->name)

@section('menu_fiche')
    <div id="menuListSeasons" class="row">
        <div class="column ficheContainer">
            <div class="ui segment">
                <div class="ui stackable secondary menu">
                    <div id="seasonsLine" class="ui stackable grid">
                        @foreach($categories as $category)
                            <a href="{{ route('article.ficheCategory', [$showInfo['show']->show_url, $category->id]) }}" class="item">{{ $category->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_middle')
    <div id="LeftBlock">
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
    </div>
@endsection

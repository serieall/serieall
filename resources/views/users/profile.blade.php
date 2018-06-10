@extends('layouts.app')

@section('pageTitle', 'Profil de ' . $user->username)

@section('content')
    <div class="ui ten wide column">
        <div class="ui center aligned">
            <div class="ui stackable compact pointing menu">
                <a class="active item">
                    <i class="user icon"></i>
                    Profil
                </a>
                <a class="item">
                    <i class="star icon"></i>
                    Notes
                </a>
                <a class="item">
                    <i class="comment icon"></i>
                    Avis
                </a>
                <a class="item">
                    <i class="tv icon"></i>
                    Séries
                </a>
                <a class="item">
                    <i class="ordered list icon"></i>
                    Classement
                </a>
                @if(Auth::check())
                    @if($user->username == Auth::user()->username)
                        <a class="item" href="{{ route('user.profile.parameters', $user->username ) }}">
                            <i class="settings icon"></i>
                            Paramètres
                        </a>
                    @endif
                @endif
            </div>
        </div>

        <div class="ui segment">
            <div class="ui items">
                <div class="item">
                    <span class="ui tiny image">
                        <img src="{{ Gravatar::src($user->email) }}">
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

        @if($user->articles->count() > 0)
            <div id="LeftBlock" class="ui segment profile">
                <h1>Articles écrits par {{ $user->username }}</h1>

                <div class="ui items">
                @foreach($user->articles as $article)
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
                </div>
            </div>
        @endif
    </div>
@endsection
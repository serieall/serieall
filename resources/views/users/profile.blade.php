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
    </div>
@endsection
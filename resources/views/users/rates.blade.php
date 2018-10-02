@extends('layouts.app')

@section('pageTitle', 'Profil de ' . $user->username)

@section('content')
    <div class="ui ten wide column">
        <div class="ui center aligned">
            <div class="ui stackable compact pointing menu">
                <a class="item" href="{{ route('user.profile', $user->username ) }}">
                    <i class="user icon"></i>
                    Profil
                </a>
                <a class=" active item">
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
        </div>
    </div>
@endsection
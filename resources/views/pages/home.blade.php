@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="five wide column">
        <h1>Dernières notes</h1>
        <div class="ui feed">
            @foreach($lastRates as $rate)
                <div class="event">
                    <div class="label">
                        <img src="{{ Gravatar::src($rate->user->username) }}">
                    </div>
                    <div class="content">
                        <div class="date">
                            {{ $rate->updated_at }}
                        </div>
                        <div class="summary">
                            {{ $rate->user->username }} a noté {!! afficheEpisodeName($rate->episode, true, true) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="five wide column">
        <h1>Derniers commentaires</h1>
        <div class="ui feed">
            @foreach($lastRates as $rate)
                <div class="event">
                    <div class="label">
                        <img src="{{ Gravatar::src($rate->user->username) }}">
                    </div>
                    <div class="content">
                        <div class="date">
                            {{ formatDate("full", $rate->updated_at) }}
                        </div>
                        <div class="summary">
                            {{ $rate->user->username }} a noté {!! afficheEpisodeName($rate->episode, true, true) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="five wide column">
        <h1>Derniers articles</h1>
        <div class="ui feed">
            @foreach($lastRates as $rate)
                <div class="event">
                    <div class="label">
                        <img src="{{ Gravatar::src($rate->user->username) }}">
                    </div>
                    <div class="content">
                        <div class="date">
                            {{ $rate->updated_at }}
                        </div>
                        <div class="summary">
                            {{ $rate->user->username }} a noté {!! afficheEpisodeName($rate->episode, true, true) !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')

    @foreach($lastRates as $rate)
        {{ $rate->user->username }} a noté {{ afficheEpisodeName($rate->episode) }}<br />
    @endforeach

@endsection

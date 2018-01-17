@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')

    @foreach($lastRates as $rate)
        {{ $rate->user->username }} a noté {!! affichageNumeroEpisode($rate->episode->show->show_url, $rate->episode->season->name, $rate->episode->numero, $rate->episode->id, true, true ) !!} <br />
    @endforeach

@endsection

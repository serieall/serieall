@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="five wide column">
        <h1>Fil d'actualité</h1>
        <div class="ui feed">
            @foreach($fil_actu as $actu)

                {{dd($actu)}}
            @endforeach
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('pageTitle', 'Error')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <style>
        body {
            background: url(/images/404.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        .background-error {
            height: 100%;

        }
        p.title {
            font-size: 72px;
            color: whitesmoke;
            margin-bottom: 40px;
            text-align: center;
            font-weight: 400;
            font-family: 'Lato';
            text-shadow: 2px 2px 3px black;
        }

    </style>

    <div class="ui centered stackable grid">
        <div id="midaligned" class="sixteen wide column">
            <div class="topImageAffiche">
                <p class="title">Erreur 404</p>
                <p class="title">Cette page n'existe pas.</p>
            </div>
        </div>
    </div>
@endsection

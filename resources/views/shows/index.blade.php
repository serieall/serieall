@extends('layouts.app')

@section('pageTitle', 'Séries TV')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid ficheContainer">
        <div id="LeftBlockShow" class="eleven wide column">
            <div class="ui segment">
                <h1>Liste des séries</h1>

                <div class="ui cards">
                @foreach($shows as $show)
                    <div class="card">
                        <div class="blurring dimmable image">
                            <img src="{{ ShowPicture($show->show_url) }}">
                        </div>
                        <div class="content">
                            <a href="{{ route('show.fiche', $show->show_url) }}" class="header">{{ $show->name }}</a>
                            <div class="meta">
                                <span class="genres">{{ $genres }}</span>
                            </div>
                        </div>
                        <div class="extra content">
                            <a>
                                <i class="calendar icon"></i>
                                {{ $show->annee }}
                            </a>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
        <div id="RightBlockShow" class="four wide column">
            <div class="ui segment">
                <h1>Filtres</h1>
            </div>
        </div>
    </div>
@endsection

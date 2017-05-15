@extends('layouts.app')

@section('content')

    <div id="topImageShow" class="row">
        <div class="column">
            <img src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Bannière {{ $show->name }}" />
        </div>
    </div>

    <div id="menuFiche" class="row">
        <div class="column">
            <div class="ui fluid six item menu">
                <a class="item">Présentation</a>
                <a class="item">Saisons</a>
                <a class="item">Informations détaillées</a>
                <a class="item">Avis</a>
                <a class="item">Articles</a>
                <a class="item">Statistiques</a>
            </div>
        </div>
    </div>


@endsection

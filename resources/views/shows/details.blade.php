@extends('layouts.fiche')

@section('pageTitle', 'Détails - ' . $showInfo['show']->name)

@section('menu_fiche')
    <div id="menuFiche" class="menuFiche row">
        <div class="column">
            <div class="ui fluid six item stackable menu ficheContainer">
                <a class="item" href="{{ route('show.fiche', $showInfo['show']->show_url) }}">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="item" href="{{ route('season.fiche', [$showInfo['show']->show_url, '1']) }}">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="active item">
                    <i class="big list icon"></i>
                    Informations détaillées
                </a>
                <a class="item">
                    <i class="big comments icon"></i>
                    Avis
                </a>
                <a class="item">
                    <i class="big write icon"></i>
                    Articles
                </a>
                <a class="item">
                    <i class="big line chart icon"></i>
                    Statistiques
                </a>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_left')
    <div id="showDetails" class="ui segment">
        <h1>Informations détaillées</h1>
        <table class="ui basic table">
            <tr>
                <td>
                    <span class="ui bold text">Titre original</span>
                </td>
                <td>
                    {{ $showInfo['show']->name }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="ui bold text">Titre français</span>
                </td>
                <td>
                    {{ $showInfo['show']->name_fr }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="ui bold text">Année de création</span>
                </td>
                <td>
                    {{ $showInfo['show']->annee }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="ui bold text">Chaîne(s) de diffusion</span>
                </td>
                <td>
                    {{ $showInfo['channels'] }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="ui bold text">Format</span>
                </td>
                <td>
                    {{ $showInfo['show']->format }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="ui bold text">Nationalité(s)</span>
                </td>
                <td>
                    {{ $showInfo['nationalities'] }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="ui bold text">Genre(s)</span>
                </td>
                <td>
                    {{ $showInfo['genres'] }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="ui bold text">Résumé complet</span>
                </td>
                <td>
                    {{ $showInfo['synopsis'] }}
                </td>
            </tr>
        </table>
    </div>
@endsection

@section('content_fiche_right')
    <div class="ui segment">
        <h1>Créateur(s)</h1>
            @foreach($showInfo['show']->creators as $creator)
                {{ $creator->name }}
                <br />
            @endforeach
    </div>
    <div class="ui segment" id="ListActors">
        <h1>Acteur(s)</h1>
        <div class="ui stackable grid">
            @foreach($showInfo['show']->actors as $actor)
                <div class="ui center aligned four wide column">
                    <img class=" ui tiny image" src="{!! ActorPicture($actor->artist_url) !!}" />

                    <span class="ui bold text">{{ $actor->name }}</span>
                    <br />
                    {{ $actor->role }}
                </div>
            @endforeach
        </div>
    </div>
@endsection

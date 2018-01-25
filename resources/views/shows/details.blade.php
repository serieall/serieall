@extends('layouts.fiche')

@section('pageTitle', 'Détails - ' . $showInfo['show']->name)

@section('content_fiche_left')
    <div id="showDetails" class="ui segment">
        <h1>Informations détaillées</h1>
        <table class="ui basic table">
            <tr>
                <td>
                    <span class="t-bold">Titre original</span>
                </td>
                <td>
                    {{ $showInfo['show']->name }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="t-bold">Titre français</span>
                </td>
                <td>
                    {{ $showInfo['show']->name_fr }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="t-bold">Année de création</span>
                </td>
                <td>
                    {{ $showInfo['show']->annee }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="t-bold">Chaîne(s) de diffusion</span>
                </td>
                <td>
                    {{ $showInfo['channels'] }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="t-bold">Format</span>
                </td>
                <td>
                    {{ $showInfo['show']->format }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="t-bold">Nationalité(s)</span>
                </td>
                <td>
                    {{ $showInfo['nationalities'] }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="t-bold">Genre(s)</span>
                </td>
                <td>
                    {{ $showInfo['genres'] }}
                </td>
            </tr>
            <tr>
                <td>
                    <span class="t-bold">Résumé complet</span>
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

                    <span class="t-bold">{{ $actor->name }}</span>
                    <br />
                    {{ $actor->role }}
                </div>
            @endforeach
        </div>
    </div>
@endsection

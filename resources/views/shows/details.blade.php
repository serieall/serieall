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
    @if(Auth::check() && Auth::user()->role <= 3)
        <div class="row">
            <a style="width: 100%" href="{{ route('admin.shows.edit', $showInfo['show']->id) }}">
                <button class="ui fluid blueSA button">
                    <i class="pencil alternate icon"></i>
                    Modifier la série dans l'admin
                </button>
            </a>
        </div>
    @endif
    <div class="ui segment">
        <h1>Créateur(s)</h1>
            @foreach($showInfo['show']->creators as $creator)
                {{ $creator->name }}
                <br />
            @endforeach
    </div>
@endsection

@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.shows.index') }}" class="section">
        Séries
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Voir la série
    </div>
@endsection

@section('content')
    <div class="ui centered grid">
        <div class="ten wide column segment">
            <div class="ui pointing secondary menu">
                <a class="dataShow item active" data-tab="first">Série</a>
                <a class="dataActor item" data-tab="second">Acteurs</a>
                <a class="dataSeason item" data-tab="third">Saisons & épisodes</a>
                <a class="dataRentree item" data-tab="fourth">Rentrée</a>
            </div>
            <div class="ui tab active" data-tab="first">
                <table class="ui celled table">
                    <tr>
                        <td>
                            Nom original
                        </td>
                        <td>
                            {{ $show->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Nom français
                        </td>
                        <td>
                            {{ $show->name_fr }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Résumé original
                        </td>
                        <td>
                            {{ $show->synopsis }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Résumé français
                        </td>
                        <td>
                            {{ $show->synopsis_fr }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Format
                        </td>
                        <td>
                            {{ $show->format }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Année
                        </td>
                        <td>
                            {{ $show->annee }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            En cours ?
                        </td>
                        <td>
                            @if($show->encours)
                                Oui
                            @else
                                Non
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Diffusion US
                        </td>
                        <td>
                            {{ $show->diffusion_us }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Diffusion française
                        </td>
                        <td>
                            {{ $show->diffusion_fr }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Taux érectile
                        </td>
                        <td>
                            {{ $show->taux_erectile }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Avis Rentrée
                        </td>
                        <td>
                            {{ $show->avis_rentree }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
@endsection
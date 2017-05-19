@extends('layouts.app')

@section('content')

    <div id="topImageShow"  class="row nobox">
        <div class="column">
            <img src="{{ $folderShows }}/{{ $show->show_url }}.jpg" alt="Bannière {{ $show->name }}" />
        </div>
    </div>

    <div id="menuFiche" class="row">
        <div class="column">
            <div class="ui fluid six item stackable menu">
                <a class="active item">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="item">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="item">
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

    <div class="row ui stackable grid">
        <div id="LeftBlockShow" class="ten wide column">
            <div class="ui stackable grid">
                <div class="row">
                    <div id="ListSeasons" class="ui segment">
                        <h1>Liste des saisons</h1>
                        <table class="ui padded table">
                            @foreach($seasons as $season)
                                <tr>
                                    <td>
                                        Saison {{ $season->name }}
                                    </td>
                                    <td>
                                        @if($season->moyenne > $noteGood)
                                            <p class="ui green label">
                                        @elseif($season->moyenne > $noteNeutral && $season->moyenne < $noteGood)
                                            <p class="ui gray label">
                                        @else
                                            <p class="ui red label">
                                        @endif
                                            {{ $season->moyenne }}
                                        </p>

                                    </td>
                                    <td>
                                        24
                                        <i class="green smile icon"></i>
                                    </td>
                                    <td>
                                        12
                                        <i class="gray meh icon"></i>
                                    </td>
                                    <td>
                                        3
                                        <i class="red frown icon"></i>
                                    </td>
                                    <td>
                                        {{ $season->episodes_count }} épisodes
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <p>Toutes les saisons ></p>



                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">
                        <h1>Derniers avis sur la série</h1>
                    </div>
                </div>
            </div>
        </div>
        <div id="RightBlockShow" class="five wide column">
            <div class="ui stackable grid">
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
                <div class="row">
                    <div class="ui segment">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.fiche')

@section('menu_fiche')
    <div id="menuFiche" class="row">
        <div class="column">
            <div class="ui fluid six item stackable menu">
                <a class="item" href="{{ route('show.fiche', $showInfo['show']->show_url) }}">
                    <i class="big home icon"></i>
                    Présentation
                </a>
                <a class="active item">
                    <i class="big browser icon"></i>
                    Saisons
                </a>
                <a class="item" href="{{ route('show.details', $showInfo['show']->show_url) }}">
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
    <div class="ui stackable grid">
            <div id="ListSeasons" class="ui segment">
                <h1>Liste des saisons</h1>
                <div class="ui stackable secondary menu">
                    <div id="seasonTab" class="ui stackable grid">
                        @foreach($showInfo['seasons'] as $season)
                            <a class="
                            @if($loop->first)
                                active
                            @endif
                             item" data-tab="{{ $season->id }}">Saison {{ $season->name }}</a>
                        @endforeach
                    </div>
                </div>

                <div class="active ui tab" data-tab="89">
                    test
                </div>

                <p class="ui tab" data-tab="90">
                    test
                </p>

                <a href="#"><p class="AllSeasons">Toutes les saisons ></p></a>
            </div>
    </div>
@endsection

@section('content_fiche_right')

@endsection

@section('scripts')
    <script>
        $('.ui.stackable.secondary.menu .item')
            .tab({
                apiSettings: {
                    url: '/api/episodes/seasons/{data-tab}'
                }

            })
        ;
    </script>
@endsection
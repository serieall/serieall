@extends('layouts.fiche')

@section('pageTitle', 'Avis ' . $showInfo['show']->name)

@section('menu_fiche')
    <div id="menuListSeasons" class="row">
        <div class="column ficheContainer">
            <div class="ui segment">
                <div class="ui stackable secondary menu">
                    <div id="seasonsLine" class="ui stackable grid">
                        <a class="
                            @if(!isset($seasonInfo))
                                active
                            @endif
                        item" href="{{ route('comment.fiche', [$showInfo['show']->show_url]) }}">Série</a>
                            @foreach($showInfo['show']->seasons as $season)
                                <a class="
                                    @if(isset($seasonInfo) && $seasonInfo->name == $season->name)
                                        active
                                    @endif
                                        item" href="{{ route('comment.fiche', [$showInfo['show']->show_url, $season->name]) }}">Saison {{ $season->name }}</a>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_left')
    <div class="ui stackable grid">
        <div class="row">
            <div id="ListAvis" class="ui segment left aligned">
                <h1>Avis</h1>
                <div id="LastComments" class="ui stackable grid">
                    @include('comments.last_comments')
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content_fiche_right')
    <div class="ui stackable grid">
        <div class="row">
            <div class="ui segment left aligned">
                @if(isset($seasonInfo))
                    <h1>Liste des épisodes</h1>
                    <div class="ui list">
                        @foreach($seasonInfo['episodes'] as $episode)
                            <div class="
                                @if(isset($episodeInfo) && $episode->id == $episodeInfo->id)
                                    active
                                @endif
                            item">
                                <i class="tv icon"></i>
                                <div class="content">
                                    @if($episode->numero == 0)
                                        <a class="header" href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $episode->numero, $episode->id]) }}">
                                    @else
                                        <a class="header" href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $episode->numero]) }}">
                                    @endif
                                            {!! affichageNumeroEpisode($showInfo['show']->show_url, $seasonInfo->name, $episode->numero, $episode->id, false, true) !!}</a>
                                            <div class="description">
                                                {{ $episode->name }}
                                            </div>
                                    </a>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <h1 class="center aligned">Liste des saisons</h1>

                    <div class="ui link list">
                        @foreach($showInfo['show']->seasons as $season)
                            <a class="item" href="{{ route('comment.fiche', [$showInfo['show']->show_url, $season->name]) }}">
                                <i class="browser icon"></i>
                                Saison {{ $season->name }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(window).on('hashchange', function() {
            if (window.location.hash) {
                var page = window.location.hash.replace('#', '');
                if (page == Number.NaN || page <= 0) {
                    return false;
                } else {
                    getComments(page);
                }
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function (e) {
                getComments($(this).attr('href').split('page=')[1]);
                e.preventDefault();
                $('#ListAvis').addClass('loading');
            });
        });

        function getComments(page) {
            $.ajax({
                url : '?page=' + page,
                dataType: 'json',
            }).done(function (data) {
                $('#LastComments').html(data);
                location.hash = page;
                $('#ListAvis').removeClass('loading');
            }).fail(function () {
                alert('Les commentaires n\'ont pas été chargés.');
                $('#ListAvis').removeClass('loading');
            });
        }
    </script>
@endsection

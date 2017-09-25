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
                <div class="ui stackable grid">
                    @if(!$comments['last_comment'])
                        <div class="row">
                            <div class="ui message">
                                <p>
                                    @if(isset($comments['user_comment']))
                                        {!! messageComment($object['model'], $comments['user_comment']) !!}
                                    @else
                                        {!! messageComment($object['model'], null) !!}
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="ui divider"></div>
                    @else
                        @foreach($comments['last_comment'] as $avis)
                            <div class="row">
                                <div class="center aligned three wide column">
                                    <a href="{{ route('user.profile', $avis['user']['username']) }}"><img class="ui tiny avatar image" src="{{ Gravatar::src($avis['user']['email']) }}">
                                        {{ $avis['user']['username'] }}</a>
                                    <br />
                                    {!! roleUser($avis['user']['role']) !!}
                                </div>
                                <div class="AvisBox center aligned twelve wide column">
                                    <table class="ui {!! affichageThumbBorder($avis['thumb']) !!} left border table">
                                        <tr>
                                            {!! affichageThumb($avis['thumb']) !!}
                                            <td class="right aligned">Déposé le {{ formatDate('full', $avis['created_at']) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="AvisResume">
                                                @if(strstr($avis['message'], "<div class=\"spoiler\">"))
                                                    L'auteur de cet avis a indiqué qu'il contenait des spoilers. Cliquez sur "Lire l'avis" pour le consulter.
                                                @else
                                                    {!! $avis['message'] !!}
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="left aligned reactions">
                                        <div class="ui threaded comments">
                                            <div class="comments">
                                                <div class="comment">
                                                    <a class="avatar">
                                                        <img src="/images/logo_v2.png">
                                                    </a>
                                                    <div class="content">
                                                        <a class="author">Jenny Hess</a>
                                                        <div class="metadata">
                                                            <span class="date">Just now</span>
                                                        </div>
                                                        <div class="text">
                                                            Elliot you are always so right :)
                                                        </div>
                                                        <div class="actions">
                                                            <a class="reply">Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="comment">
                                                    <a class="avatar">
                                                        <img src="/images/logo_v2.png">
                                                    </a>
                                                    <div class="content">
                                                        <a class="author">Jenny Hess</a>
                                                        <div class="metadata">
                                                            <span class="date">Just now</span>
                                                        </div>
                                                        <div class="text">
                                                            Elliot you are always so right :)
                                                        </div>
                                                        <div class="actions">
                                                            <a class="reply">Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="comment">
                                                    <a class="avatar">
                                                        <img src="/images/logo_v2.png">
                                                    </a>
                                                    <div class="content">
                                                        <a class="author">Jenny Hess</a>
                                                        <div class="metadata">
                                                            <span class="date">Just now</span>
                                                        </div>
                                                        <div class="text">
                                                            Elliot you are always so right :)
                                                        </div>
                                                        <div class="actions">
                                                            <a class="reply">Reply</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    @endif
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
                                        </div>
                                </a>
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



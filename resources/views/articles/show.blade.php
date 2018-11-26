@extends('layouts.app')

@section('pageTitle', $article->name)
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid">
        <div class="one wide column">
            <div class="divParentShareIcon">
                <div class="divChildShareIcon">
                    {!! Share::currentPage()->facebook()
                    ->twitter() !!}
                    <div class="ui divider"></div>
                    <ul>
                        <li>
                            <a id="goToComments" href="#ListAvis"><i class="large circular inverted comment icon"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="LeftBlock" class="eight wide column article">
            <div class="ui segment" id="segmentLeft">
                <div class="topInfoArticle">
                    <div class="title">
                        <div class="imageArticle">
                            <img src="{{ $article->image }}">
                        </div>
                        <div class="ui two column center aligned grid stackable">
                            <div class="row">
                                <h1>{{ $article->name }}</h1>
                                Le {!! formatDate('full', $article->published_at) !!}
                            </div>
                            <div class="row readingTime">
                                <i class="time icon"></i> ~ {!! calculateReadingTime($article->content) !!} de lecture
                            </div>
                            <div class="row intro">
                                {{ $article->intro }}
                            </div>
                            <div class="row bottom authors right aligned">
                                <span>
                                Par @foreach($article->users as $redac)
                                        <a class="underline-from-left" href="{{ route('user.profile', $redac->user_url) }}">{{ $redac->username }}</a>
                                        @if(!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="ui two column center aligned grid stackable" id="hiddenInfo">
                        <div class="row">
                            <h1>{{ $article->name }}</h1>
                        </div>
                        <div class="row readingTime">
                            <i class="time icon"></i> ~ {!! calculateReadingTime($article->content) !!} de lecture
                        </div>
                        <div class="row intro">
                            {{ $article->intro }}
                        </div>
                        <div class="row bottom">
                            <div class="column authors right aligned">
                                    <span>
                                    Par @foreach($article->users as $redac)
                                            {{ $redac->username }}
                                            @if(!$loop->last)
                                                ,
                                            @endif
                                        @endforeach
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>

                <br/>
                <div class="article content">
                    {!! $article->content !!}
                    <div class="ui divider"></div>
                    <h2 class="ui header">
                        <i class="small write icon"></i>
                        <div class="content">
                            @if($article->users_count > 1)
                                Les auteurs
                            @else
                                L'auteur
                            @endif

                        </div>
                    </h2>
                    <div class="ui five stackable cards">
                        @foreach($article->users as $redac)
                            <a class="ui card" href="{{ route('user.profile', $redac->user_url) }}">
                                <div class="content">
                                    <div class="center aligned description">
                                        <p>{{ $redac->edito }}</p>
                                    </div>
                                </div>
                                <div class="extra content">
                                    <div class="center aligned author">
                                        <img class="ui avatar image"
                                             src="{{ Gravatar::src($redac->email) }}"> {{ $redac->username }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

    <div class="ui segment">
        <div id="ListAvis">
            <h2 class="ui center aligned header">
                <div class="ui stackable grid">
                    <div class="eight wide column left aligned">
                        <i class="comments icon"></i>
                        <div class="content">
                            Commentaires
                        </div>
                    </div>
                    <div class="eight wide column right aligned">
                        @if(Auth::check())
                            <button class="ui button WriteAvis">
                                <i class="write icon"></i>
                                @if(!isset($comments['user_comment']))
                                    Écrire un commentaire
                                @else
                                    Modifier mon commentaire
                                @endif
                            </button>
                        @endif
                    </div>
                </div>
            </h2>
        </div>

        <div id="divLastComments">
            @if(count($comments['last_comment']) != 0)
                @include('comments.comment_article')
            @else
                <div class="ui segment noComment">
                    Pas de commentaires pour l'instant...
                </div>
            @endif
        </div>
        @if(Auth::check())
            @include('comments.form_comment')
        @endif
    </div>
    </div>

    <div id="RightBlock" class="three wide column article">
        <div class="ui segment linkedShow">
            @if($article->shows_count >= 1)
                @foreach($article->shows as $show)
                    <div class="articleShow">
                        <div class="ui grid" id="linkedObject">
                            <div class="articleShowImage">
                                <img src="{{ ShowPicture($show->show_url) }}" alt="Image {{ $show->name }}">
                            </div>
                            <div class="row show">
                                <div class="eleven wide column">
                                    <a href="{{ route('show.fiche', $show->show_url) }}"><span
                                                class="title">{{ $show->name }}</span></a>
                                </div>
                                <div class="four wide column rate right aligned">
                                    {!! affichageNote($show->moyenne) !!}
                                </div>
                            </div>
                            @if($article->seasons_count == 1)
                                @foreach($article->seasons as $season)
                                    <div class="row season">
                                        <div class="eleven wide column">
                                            <a href="{{ route('season.fiche', [$season->show->show_url, $season->name]) }}">Saison {{ $season->name }}</a>
                                        </div>
                                        <div class="four wide column right aligned">
                                            {!! affichageNote($season->moyenne) !!}
                                        </div>
                                    </div>
                                    @if($article->episodes_count == 1)
                                        @foreach($article->episodes as $episode)
                                            <div class="row episode">
                                                <div class="eleven wide column">
                                                    @if($episode->numero == 0)
                                                        <a href="{{ route('episode.fiche', [$episode->show->show_url, $episode->season->name, $episode->numero, $episode->id]) }}">{{ $episode->name }}</a>
                                                    @else
                                                        <a href="{{ route('episode.fiche', [$episode->show->show_url, $episode->season->name, $episode->numero]) }}">{{ $episode->name }}</a>
                                                    @endif

                                                </div>
                                                <div class="four wide column right aligned">
                                                    {!! affichageNote($episode->moyenne) !!}
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        @include('articles.linked')
    </div>
    </div>
    @if(Auth::check())
        @include('comments.form_reaction')
    @endif
@endsection

@push('scripts')
    <script src="/js/article.show.js"></script>
@endpush

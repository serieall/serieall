@extends('layouts.app')

@section('pageTitle', $article->name)
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid">
        <div id="LeftBlock" class="eight wide column article">
            <div class="ui segment">
                <div class="title">
                    <h1>{{ $article->name }}</h1>
                    <i class="time icon"></i> ~ {!! calculateReadingTime($article->content) !!} <br />
                    {{ $article->intro }}
                    <br />
                    {!! Share::currentPage()->facebook()
                                            ->twitter() !!}
                </div>

                <div class="imageArticle">
                    <img src="{{ $article->image }}">
                </div>
                <br />
                <div class="article content">
                    {!! $article->content !!}
                    <div class="ui divider"></div>
                    <h2 class="ui header">
                        <i class="write icon"></i>
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
                            <a class="ui card" href="{{ route('user.profile', $redac->username) }}" >
                                <div class="content">
                                    <div class="center aligned description">
                                        <p>{{ $redac->edito }}</p>
                                    </div>
                                </div>
                                <div class="extra content">
                                    <div class="center aligned author">
                                        <img class="ui avatar image" src="{{ Gravatar::src($redac->email) }}"> {{ $redac->username }}
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
                        <div class="ui grid">
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
            <div class="ui segment">
                @foreach($article->shows as $show)
                    <div>
                    <div class="articleShowImage">
                        <img src="{{ ShowPicture($show->show_url) }}" alt="Image {{ $show->name }}">
                        <div class="after"></div>
                        <div class="articleShow">
                            <div class="ui grid">
                                <div class="row">
                                    <div class="eleven wide column">
                                        <span class="title">{{ $show->name }}</span>
                                    </div>
                                    <div class="four wide column rate right aligned">
                                        {!! affichageNote($show->moyenne) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @if(Auth::check())
        @include('comments.form_reaction')
    @endif
@endsection

@section('scripts')
    <script src="/js/article.show.js"></script>
@endsection

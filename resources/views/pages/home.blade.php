@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable centered grid home">
        <div class="row">
            <div class="four wide column">
                <h1>Fil d'actualité</h1>
                <div class="ui placeholder segment">
                    <a class="ui @if($actu_mode == "all") blue @endif label">
                        Tout
                    </a>
                    <a class="ui label">
                        <i class="sort numeric down icon"></i>
                        Notes
                    </a>
                    <a class="ui label">
                        <i class="comment icon"></i>
                        Avis
                    </a>
                    <a class="ui label">
                        <i class="comments icon"></i>
                        Réactions
                    </a>
                    <div class="ui feed">
                        @foreach($fil_actu as $actu)
                            <div class="event">
                                <div class="label">
                                    <img src="{{ Gravatar::src($actu->user->email) }}">
                                </div>
                                <div class="content">
                                    <div class="date">
                                        {!! formatDate('full', $actu->created_at) !!}
                                    </div>
                                    <div class="summary">
                                        @if($actu->type == "rate")
                                            <a href="{{ route('user.profile', $actu->user->user_url) }}">{{ $actu->user->username }}</a> a mis {!! affichageNote($actu->rate) !!} à {!! printShowEpisode($actu->episode->show->name, $actu->episode->show->show_url, $actu->episode->season->name, $actu->episode->numero, $actu->episode->id) !!}
                                            @elseif($actu->type == "comment")
                                            <a href="{{ route('user.profile', $actu->user->user_url) }}">{{ $actu->user->username }}</a>  a
                                            @if($actu->commentable_type == "App\Models\Episode")
                                                commenté l'épisode {!! printShowEpisode($actu->commentable->show->name, $actu->commentable->show->show_url, $actu->commentable->season->name, $actu->commentable->numero, $actu->commentable->id) !!} {!! affichageThumbIcon($actu->thumb) !!}
                                            @elseif($actu->commentable_type == "App\Models\Season")
                                                commenté la saison {!! printShowSeason($actu->commentable->show->name, $actu->commentable->show->show_url, $actu->commentable->name) !!} {!! affichageThumbIcon($actu->thumb) !!}
                                            @elseif($actu->commentable_type == "App\Models\Show")
                                                commenté la série {!! printShow($actu->commentable->name, $actu->commentable->show_url) !!} {!! affichageThumbIcon($actu->thumb) !!}
                                            @elseif($actu->commentable_type == "App\Models\Article")
                                                commenté l'article {!! printArticle($actu->commentable->name, $actu->commentable->article_url) !!}
                                            @else
                                                répondu au commentaire de <a href="{{ route('user.profile', $actu->parent->user->user_url) }}">{{ $actu->parent->user->username }}</a> sur
                                                @if($actu->parent->commentable_type == "App\Models\Episode")
                                                    {!! printShowEpisode($actu->parent->commentable->show->name, $actu->parent->commentable->show->show_url, $actu->parent->commentable->season->name, $actu->parent->commentable->numero, $actu->parent->commentable->id) !!}
                                                @elseif($actu->parent->commentable_type == "App\Models\Season")
                                                    {!! printShowSeason($actu->parent->commentable->show->name, $actu->parent->commentable->show->show_url, $actu->parent->commentable->name) !!}
                                                @elseif($actu->parent->commentable_type == "App\Models\Show")
                                                    {!! printShow($actu->parent->commentable->name, $actu->parent->commentable->show_url) !!}
                                                @elseif($actu->parent->commentable_type == "App\Models\Article")
                                                    {!! printArticle($actu->parent->commentable->name, $actu->parent->commentable->article_url) !!}
                                                @endif
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="eight wide column div_show_moment">
                <h1>Les séries  du moment</h1>
                <div class="shows_moment">
                    @foreach($shows_moment as $show)
                        <div class="hvr-rotate">
                            <a href="{{ route('show.fiche', $show->show_url) }}">
                                <img src="{{ ShowPicture($show->show_url) }}" alt="">
                                <span class="overlay_shows_moment">{{ $show->name }} | {!! affichageNote($show->moyenne) !!}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
                <h1>Articles</h1>
                <div class="ui centered cards article home">
                    @foreach($articles as $article)
                        <a class="ui raised card hvr-grow" href="{{ route('article.show', $article->article_url) }}">
                            <div class="content">
                                <div class="header">{{ $article->name }}</div>
                            </div>
                            <div class="image article">
                                <img src="{{ $article->image }}" alt="Image article">
                            </div>
                            <div class="content">
                                <div class="meta">
                                    <i class="ui label {{ colorCategory($article->category->id) }}">{{ $article->category->name }}</i>
                                    <span class="right floated">{{ $article->comments->count() }} <i class="comment icon"></i></span>
                                </div>
                                <div class="description">
                                    <p>{{ $article->intro }}</p>
                                </div>
                            </div>
                            <div class="extra content">
                                <div class="center aligned  author">
                                    Par
                                    @foreach($article->users as $redac)
                                        <img class="ui avatar image" src="{{ Gravatar::src($redac->email) }}"> {{ $redac->username }}
                                    @endforeach
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                <h1>Planning</h1>
                <div class="ui piled segment home planning grid three columns">
                        <div class="column">
                            <div class="title b-blueSA">
                                Hier
                            </div>
                            <div class="list episodes">
                                @if($planning['yesterday']->count() != 0)
                                    @foreach($planning['yesterday'] as $episode)
                                        <div class="episode">
                                            <div class="ui red horizontal label">{{ $episode->show->channels[0]->name }}</div>
                                            {!! printShowEpisode($episode->show->name, $episode->show->show_url, $episode->season->name, $episode->numero, $episode->id) !!}
                                        </div>
                                    @endforeach
                                @else
                                    @component('components.message_simple', ['type' => 'info'])
                                        Pas d'épisodes diffusés hier.
                                    @endcomponent
                                @endif
                            </div>
                        </div>
                    <div class="column">
                        <div class="title b-darkBlueSA">
                            Aujourd'hui
                        </div>
                        <div class="list episodes">
                            @if($planning['today']->count() != 0)
                                @foreach($planning['today'] as $episode)
                                    <div class="episode">
                                        <div class="ui red horizontal label">{{ $episode->show->channels[0]->name }}</div>
                                        {!! printShowEpisode($episode->show->name, $episode->show->show_url, $episode->season->name, $episode->numero, $episode->id) !!}
                                    </div>
                                @endforeach
                            @else
                                @component('components.message_simple', ['type' => 'info'])
                                    Pas d'épisodes diffusés aujourd'hui.
                                @endcomponent
                            @endif
                        </div>
                    </div>
                    <div class="column">
                        <div class="title b-blueSA">
                            Demain
                        </div>
                        <div class="list episodes">
                            @if($planning['tomorrow']->count() != 0)
                                @foreach($planning['tomorrow'] as $episode)
                                    <div class="episode">
                                        <div class="ui red horizontal label">{{ $episode->show->channels[0]->name }}</div>
                                        {!! printShowEpisode($episode->show->name, $episode->show->show_url, $episode->season->name, $episode->numero, $episode->id) !!}
                                    </div>
                                @endforeach
                            @else
                                @component('components.message_simple', ['type' => 'info'])
                                    Pas d'épisodes diffusés demain.
                                @endcomponent
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="fifteen wide column div_last_added_shows">
                <h1>Les dernières séries ajoutées</h1>
                <div class="last_added_shows">
                    @foreach($last_added_shows as $show)
                        <div class="hvr-rotate">
                            <a href="{{ route('show.fiche', $show->show_url) }}">
                                <img src="{{ ShowPicture($show->show_url) }}" alt="">
                                <span class="overlay_shows_moment">{{ $show->name }} | {!! affichageNote($show->moyenne) !!}</span>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="/slick/slick/slick.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".shows_moment").slick({
                centerMode: true,
                centerPadding: '60px',
                slidesToShow: 4,
                infinite: true,
                variableWidth: false,
                responsive: [
                    {
                        breakpoint: 1650,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 1210,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 628,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });

            $(".last_added_shows").slick({
                centerMode: true,
                centerPadding: '60px',
                slidesToShow: 8,
                infinite: true,
                variableWidth: false,
                responsive: [
                    {
                        breakpoint: 1650,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 1210,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 628,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '40px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
        });


    </script>
@endpush

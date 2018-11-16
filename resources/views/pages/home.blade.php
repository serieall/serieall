@extends('layouts.app')

@section('pageTitle', 'Accueil')
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable centered grid home">
        <div class="four wide column">
            <h1>Fil d'actualité</h1>
            <div class="ui placeholder segment">
                <div class="ui feed">
                    @foreach($fil_actu as $actu)
                        <div class="event">
                            <div class="label">
                                <img src="{{ Gravatar::src($actu->user->username) }}">
                            </div>
                            <div class="content">
                                <div class="date">
                                    {{ formatDate($actu->updated_at, "full") }}
                                </div>
                                <div class="summary">
                                    @if($actu->type == "rate")
                                        {{ $actu->user->username }} a noté {!! afficheEpisodeName($actu->episode, true, true) !!}
                                        @elseif($actu->type == "comment")
                                        {{ $actu->user->username }} a commenté
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="six wide column article home">
            <h1>Articles</h1>
            <div class="ui centered cards">
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
        </div>

        <div class="three wide column ">
            <div class="foo">
                <h1>Les séries  du moment</h1>
            </div>
            <div class="shows_moment">
                @foreach($shows_moment as $show)
                    <div class="ui fluid card cardHome">
                        <div class="image">
                            <img src="{{ ShowPicture($show->show_url) }}">
                        </div>
                        <div class="content">
                            <a class="header">{{ $show->name }}</a>
                        </div>
                    </div>
                @endforeach
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
                infinite: true,
                speed: 500,
                fade: true,
                autoplay: true,
                cssEase: "linear",
            });
            $('.card__share > i').on('click', function(e){
                e.preventDefault() // prevent default action - hash doesn't appear in url
                $(this).parent().find( 'div' ).toggleClass( 'card__social--active' );
                $(this).toggleClass('share-expanded');
            });
        });


    </script>
@endpush

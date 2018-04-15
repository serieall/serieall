@extends('layouts.app')

@section('pageTitle', $article->name)
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid">
        <div id="LeftBlock" class="ten wide column article">
            <div class="ui segment">
                <div class="title">
                    <h1>{{ $article->name }}</h1>
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

            <div id="ListAvis" class="ui segment left aligned">
                <h1>Avis</h1>
                <div id="LastComments" class="ui stackable grid">
                    @include('comments.comment_article')
                </div>
            </div>

            {{ $comments['last_comment']->links() }}
        </div>

        <div id="RightBlock">

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
                dataType: 'json'
            }).done(function (data) {
                // On insére le HTML
                $('#LastComments').html(data);

                // On recharge les spoilers et on remonte en haut de la page.
                $.getScript('/spoiler/spoiler.js');
                $('html, body').animate({scrollTop:$('#ListAvis').offset().top}, 'slow');//return false;

                location.hash = page;
                $('#ListAvis').removeClass('loading');
            }).fail(function () {
                alert('Les commentaires n\'ont pas été chargés.');
                $('#ListAvis').removeClass('loading');
            });
        }
    </script>
@endsection

@extends('layouts.app')

@section('pageTitle', $article->name)
@section('pageDescription', 'Webzine communautaire des séries TV - Critiques et actualité des séries tv, notez et laissez vos avis sur les derniers épisodes, créez votre planning ...')

@section('content')
    <div class="row ui stackable grid">
        <div id="LeftBlock" class="eight wide column article">
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

                <div>
                    @if(count($comments['last_comment']) != 0)
                        @include('comments.comment_article')
                    @else
                        <div class="ui segment noComment">
                            Pas de commentaires pour l'instant...
                        </div>
                    @endif
                </div>
                @include('comments.form_comment')
            </div>


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
            var $divView = $('.showMoreOrLess');
            var innerHeight = $divView.removeClass('showMoreOrLess').height();
            $divView.addClass('showMoreOrLess');

            if(innerHeight < 0) {
                $('.fadeShowMoreOrLess').remove();
                $('.slideShowMoreOrLess').remove();
                $divView.removeClass('showMoreOrLess');
            }

            $('.slideShowMoreOrLess').click(function() {
                $('.showMoreOrLess').animate({
                    height: (($divView.height() == 0)? innerHeight  : "0px")
                }, 500);

                if($divView.height() == 0) {
                    $('.slideShowMoreOrLess').text('Cacher les réponses');
                    $('.fadeDiv').removeClass('fadeShowMoreOrLess');
                }
                else {
                    $('.slideShowMoreOrLess').text('Voir les réponses');
                    $('.fadeDiv').addClass('fadeShowMoreOrLess');
                }
                return false;
            });
        });

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function (e) {
                getComments($(this).attr('href').split('page=')[1]);
                e.preventDefault();
                $('#LastComments').addClass('loading');
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
                $('#LastComments').removeClass('loading');
            }).fail(function () {
                alert('Les commentaires n\'ont pas été chargés.');
                $('#LastComments').removeClass('loading');
            });
        }

        $('.ui.modal.avis').modal('attach events', '.ui.button.WriteAvis', 'show');
        $('.ui.fluid.selection.dropdown').dropdown({forceSelection: true});
        CKEDITOR.plugins.addExternal( 'spoiler', '/js/ckeditor/plugins/spoiler/plugin.js' );
        CKEDITOR.plugins.addExternal( 'wordcount', '/js/ckeditor/plugins/wordcount/plugin.js' );
        CKEDITOR.replace( 'avis' ,
            {
                extraPlugins: 'spoiler,wordcount',
                customConfig:'/js/ckeditor/config.js',
                wordcount: {
                    showCharCount: true,
                    showWordCount: false,
                    showParagraphs: false
                }
            });
        // Submission
        $(document).on('submit', '#formAvis', function(e) {
            e.preventDefault();

            var messageLength = CKEDITOR.instances['avis'].getData().replace(/<[^>]*>|\n|&nbsp;/g, '').length;
            var nombreCaracAvis = 20;

            if(messageLength < nombreCaracAvis ) {
                $('.nombreCarac').removeClass("hidden");
            }
            else {
                $('.submit').addClass("loading");

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json"
                })
                    .done(function () {
                        window.location.reload(false);
                    })
                    .fail(function (data) {
                        $('.submit').removeClass("loading");

                        $.each(data.responseJSON.errors, function (key, value) {
                            var input = 'input[class="' + key + '"]';

                            $(input + '+div').text(value);
                            $(input + '+div').removeClass("hidden");
                            $(input).parent().addClass('error');
                        });
                    });
            }
        });

        $('.ui.modal.reaction').modal('attach events', '.writeReaction', 'show');
        CKEDITOR.plugins.addExternal( 'spoiler', '/js/ckeditor/plugins/spoiler/plugin.js' );
        CKEDITOR.plugins.addExternal( 'wordcount', '/js/ckeditor/plugins/wordcount/plugin.js' );
        CKEDITOR.replace( 'reaction' ,
            {
                extraPlugins: 'spoiler,wordcount',
                customConfig:'/js/ckeditor/config.js',
                wordcount: {
                    showCharCount: true,
                    showWordCount: false,
                    showParagraphs: false
                }
            });

        $('.ui.button.writeReaction').click(function(e) {
            e.preventDefault();
            IDButton = $(this).attr('id');
            $('.object_parent_id').val(IDButton);
        });

        // Submission
        $(document).on('submit', '#formReaction', function(e) {
            e.preventDefault();

            var messageLength = CKEDITOR.instances['avis'].getData().replace(/<[^>]*>|\n|&nbsp;/g, '').length;
            var nombreCaracAvis = '20';

            if(messageLength < nombreCaracAvis ) {
                $('.nombreCarac').removeClass("hidden");
            }
            else {
                $('.submit').addClass("loading");

                $.ajax({
                    method: $(this).attr('method'),
                    url: $(this).attr('action'),
                    data: $(this).serialize(),
                    dataType: "json"
                })
                    .done(function () {
                        window.location.reload(false);
                    })
                    .fail(function (data) {
                        $('.submit').removeClass("loading");

                        $.each(data.responseJSON.errors, function (key, value) {
                            var input = 'input[class="' + key + '"]';

                            $(input + '+div').text(value);
                            $(input + '+div').removeClass("hidden");
                            $(input).parent().addClass('error');
                        });
                    });
            }
        });
    </script>
@endsection

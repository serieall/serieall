@extends('layouts.fiche')

@section('pageTitle', 'Avis ' . $showInfo['show']->name)
@section('pageDescription', 'Tous les avis sur la série ' . $showInfo['show']->name)

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
                                    @if(!empty($seasonInfo) && $seasonInfo->name == $season->name)
                                        active
                                    @endif
                                        item" href="{{ route('comment.fiche', [$showInfo['show']->show_url, $season->name]) }}">Saison {{ $season->name }}</a>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('comments.form_avis')
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
        @if(Auth::check())
        <div class="row">
            <div class="ui segment center aligned">
                <button class="ui DarkBlueSerieAll button fluid WriteAvis">
                    <i class="write icon"></i>
                    @if(!isset($comments['user_comment']))
                        Écrire un avis
                    @else
                        Modifier mon avis
                    @endif
                </button>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="ui segment left aligned">
                @if(!empty($seasonInfo))
                    <h1>Liste des épisodes</h1>
                    <div class="ui list">
                        @foreach($seasonInfo['episodes'] as $episode)
                            <div class="
                                @if(!empty($episodeInfo) && $episode->id == $episodeInfo->id)
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
                                                {{ afficheEpisodeName($episode, false, false) }}
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

@push('scripts')
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
            var nombreCaracAvis = '{!! config('param.nombreCaracAvis') !!}';

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
@endpush

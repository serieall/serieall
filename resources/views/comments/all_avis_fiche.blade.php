<div id="ListAvis" class="ui segment">
    <h1>Tous les avis</h1>
    <div>
        @include('comments.last_comments')
        <div class="ui stackable grid">
            @if(!empty($comments['user_comment']))
                <div class="row">
                    <h3>Mon avis</h3>
                </div>
                <div class="row">
                    <div class="center aligned three wide column">
                        <a href="{{ route('user.profile', $comments['user_comment']['user']['username']) }}"><img class="ui tiny avatar image" src="{{ Gravatar::src($comments['user_comment']['user']['email']) }}">
                            {{ $comments['user_comment']['user']['username'] }}</a>
                        <br />
                        {!! roleUser($comments['user_comment']['user']['role']) !!}
                    </div>
                    <div class="AvisBox center aligned twelve wide column">
                        <table class="ui {!! affichageThumbBorder($comments['user_comment']['thumb']) !!} table">
                            <tr>
                                {!! affichageThumb($comments['user_comment']['thumb']) !!}
                                <td class="right aligned">Déposé le {!! formatDate('full', $comments['user_comment']['created_at']) !!}</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="AvisResume">
                                    {!! $comments['user_comment']['message'] !!}
                                </td>

                            </tr>
                            <tr>
                                <td class="LireAvis">

                                    @if(Route::current()->getName() == "show.fiche")
                                        <a href="{{ route('comment.fiche', [$showInfo['show']->show_url]) }}">
                                    @elseif(Route::current()->getName() == "season.fiche")
                                        <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name]) }}">
                                    @elseif(Route::current()->getName() == "episode.fiche")
                                        @if($episodeInfo->numero != 0)
                                            <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $episodeInfo->numero]) }}">
                                        @else
                                            <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $episodeInfo->numero, $episodeInfo->id]) }}">
                                        @endif
                                    @else
                                        <a href="#">
                                    @endif
                                        <button class="ui basic right floated button">
                                            Lire l'avis complet
                                            <i class="right arrow icon"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="column">
                    @if(Auth::check())
                        <button class="ui DarkBlueSerieAll button WriteAvis">
                            <i class="write icon"></i>
                            @if(!isset($comments['user_comment']))
                                Écrire un avis
                            @else
                                Modifier mon avis
                            @endif
                        </button>
                    @endif
                    @if($comments['last_comment'])
                        @if(Route::current()->getName() == 'show.fiche')
                            <a href="{{ route('comment.fiche', [$showInfo['show']->show_url]) }}">
                        @elseif(Route::current()->getName() == 'season.fiche')
                            <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name]) }}">
                        @elseif(Route::current()->getName() == 'episode.fiche')
                            @if($episodeInfo->numero == 0)
                                <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $episodeInfo->numero, $episodeInfo->id]) }}">
                            @else
                                <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name, $episodeInfo->numero]) }}">
                            @endif
                        @else

                        @endif
                            <button class="ui right floated button">
                                Tous les avis
                                <i class="right arrow icon"></i>
                            </button>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('comments.form_avis')

@push('scripts')
{{--    <script src="/js/article.show.js"></script>--}}
{{--    <script src="/js/views/comments/paginate_comments.js"></script>--}}
    <script type="text/javascript">
        let lastComments = $('#LastComments');

        //Pagination
        lastComments.on('click', '.pagination a', function (e) {
            e.preventDefault();

            getComments($(this).attr('href').split('page=')[1]);
            $('#ListAvis').addClass('loading');
        });

        //Toggle affichage des réactions
        lastComments.on('click', '.showReactions',function() {
            $(this).parent().next('.divReactions').slideToggle("fast");
            $(this).toggleText(
                '<div class="visible content">Voir les réponses</div><div class="hidden content"><i class="down arrow icon"></i></div>',
                '<div class="visible content">Cacher les réponses</div><div class="hidden content"><i class="up arrow icon"></i></div>'
            );
        });

        //Ecriture des avis
        $('.ui.modal.avis').modal('attach events', '.ui.button.WriteAvis', 'show');
        $('.ui.fluid.selection.dropdown').dropdown({forceSelection: true});
        var editorAvis = CKEDITOR.instances.avis;
        if (editorAvis) {
            editorAvis.destroy(true);
        }
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


        //Ecriture des reactions
        var editorReaction = CKEDITOR.instances.reaction;
        if (editorReaction) {
            editorReaction.destroy(true);
        }


        CKEDITOR.plugins.addExternal('spoiler', '/js/ckeditor/plugins/spoiler/plugin.js');
        CKEDITOR.plugins.addExternal('wordcount', '/js/ckeditor/plugins/wordcount/plugin.js');
        CKEDITOR.replace('reaction',
            {
                extraPlugins: 'spoiler,wordcount',
                customConfig: '/js/ckeditor/config.js',
                wordcount: {
                    showCharCount: true,
                    showWordCount: false,
                    showParagraphs: false
                }
            });

        $('.ui.modal.reaction').modal('attach events', '.writeReaction', 'show');
        lastComments.on('click', '.writeReaction', function (e) {
            console.log("Click");
            e.preventDefault();
            IDButton = $(this).attr('id');
            username = $(this).attr('username');
            $('.object_parent_id').val(IDButton);
            $('.answerUsername').text(username);
        });


        //Utils functions
        function getComments(page) {
            $.ajax({
                url : '?page=' + page,
                dataType: 'json'
            }).done(function (data) {
                // On insére le HTML
                let lastComments = $('#LastComments');
                lastComments.html(data);

                // On recharge les spoilers
                $.getScript('/js/spoiler/spoiler.js');

                //Rechargement des réactions
                $('.ui.modal.reaction').modal('attach events', '.writeReaction', 'show');

                location.hash = page;
                $('#ListAvis').removeClass('loading');
            }).fail(function () {
                alert('Les commentaires n\'ont pas été chargés.');
                $('#LastComments').removeClass('loading');
            });
        }
    </script>
@endpush

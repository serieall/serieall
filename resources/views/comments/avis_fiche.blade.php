<div id="ListAvis" class="ui segment">
    <h1>Derniers avis</h1>
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
                                    {!! cutResume($avis['message']) !!}
                                </td>
                            </tr>
                            <tr>
                                <td class="ui grey text">{{--Réponse--}}</td>
                                <td class="LireAvis">
                                    @if(Route::current()->getName() == 'shows.fiche')
                                        <a href="{{ route('comment.fiche', [$showInfo['show']->show_url]) }}">
                                    @elseif(Route::current()->getName() == 'seasons.fiche')
                                        <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name]) }}">
                                    @elseif(Route::current()->getName() == 'episodes.fiche')
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
            @endforeach
        @endif
        @if(isset($comments['user_comment']))
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
                    <table class="ui {!! affichageThumbBorder($comments['user_comment']['thumb']) !!} left border table">
                        <tr>
                            {!! affichageThumb($comments['user_comment']['thumb']) !!}
                            <td class="right aligned">Déposé le {!! formatDate('full', $comments['user_comment']['created_at']) !!}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="AvisResume">
                                {!! cutResume($comments['user_comment']['message']) !!}
                            </td>

                        </tr>
                        <tr>
                            <td class="ui grey text">10 réponses</td>
                            <td class="LireAvis">
                            @if(Route::current()->getName() == 'show.fiche')
                                <a href="{{ route('comment.fiche', [$showInfo['show']->show_url]) }}">
                            @elseif(Route::current()->getName() == 'season.fiche')
                                <a href="{{ route('comment.fiche', [$showInfo['show']->show_url, $seasonInfo->name]) }}">
                            @elseif(Route::current()->getName() == 'episode.fiche')
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
                        @if(is_null($comments['user_comment']))
                            Ecrire un avis
                        @else
                            Modifier mon avis
                        @endif
                    </button>
                @endif
                @if($comments['last_comment'])
                    <a href="{{route('comment.fiche', [$showInfo['show']->show_url])}}">
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

<div class="ui modal">
    <div class="header">
        @if(isset($comments['user_comment']))
            Ecrire un avis
        @else
            Modifier mon avis
        @endif
    </div>
    <div class="content">
        <form id="formAvis" class="ui form" method="post" action="{{ route('comment.store') }}">
            {{ csrf_field() }}

            <input type="hidden" class="object" name="object" value="{{ $object['model'] }}">
            <input type="hidden" class="episode_id" name="episode_id" value="" disabled>
            <input type="hidden" class="note" name="note" value="" disabled>

            <div class="ui red hidden message"></div>

            <input type="hidden" name="object_id" class="object_id" value="{{ $object['id'] }}">
            <div class="ui red hidden message"></div>

            <div class="ecrireAvis ui info hidden message">
                Vous devez écrire un avis pour attribuer cette note.
            </div>

            <div class="ui field">
                <div class="textarea input">
                         <textarea name="avis" id="avis" class="avis" placeholder="Ecrivez votre avis ici...">
                             @if(isset($comments['user_comment']))
                                 {{ $comments['user_comment']['message'] }}
                             @endif
                         </textarea>

                    <div class="nombreCarac ui red hidden message">
                        100 caractères minimum requis.
                    </div>
                </div>

            </div>

            <div class="ui field">
                <div class="ui fluid selection dropdown">
                    <input name="thumb" id="thumb" class="thumb" type="hidden" value="@if(isset($comments['user_comment'])){{ $comments['user_comment']['thumb'] }}@endif">
                    <i class="dropdown icon"></i>
                    <div class="default text">Choisissez un type</div>
                    <div class="menu">
                        <div class="item" data-value="1">
                            <i class="green smile large icon"></i>
                            Avis favorable
                        </div>
                        <div class="item" data-value="2">
                            <i class="grey meh large icon"></i>
                            Avis neutre
                        </div>
                        <div class="item" data-value="3">
                            <i class="red frown large icon"></i>
                            Avis défavorable
                        </div>
                    </div>
                </div>
                <div class="ui red hidden message"></div>
            </div>

            <p></p>

            <button class="ui submit positive button">Envoyer</button>
        </form>
        <script>
            CKEDITOR.replace( 'avis' , {wordcount: { showCharCount: true, showWordCount: false, showParagraphs: false }} );
        </script>
    </div>
</div>

<script>
    $('.ui.modal').modal('attach events', '.ui.button.WriteAvis', 'show');
    $('.ui.fluid.selection.dropdown').dropdown({forceSelection: true});

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

                    $.each(data.responseJSON, function (key, value) {
                        var input = 'input[class="' + key + '"]';

                        $(input + '+div').text(value);
                        $(input + '+div').removeClass("hidden");
                        $(input).parent().addClass('error');
                    });
                });
        }
    });
</script>
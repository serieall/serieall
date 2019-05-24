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
                        <a href="{{ route('user.profile', $comments['user_comment']['user']['username']) }}"><img class="ui tiny avatar image" src="{{ Gravatar::src($comments['user_comment']['user']['email']) }}"  alt="Avatar {{$comments['user_comment']['user']['username']}}">
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
    <script src="/js/views/comments/paginate_comments.js" type="text/javascript" async></script>
@endpush

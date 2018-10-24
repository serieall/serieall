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
    <div class="row">
        <div class="column center aligned">
            {{ $comments['last_comment']->links() }}
        </div>
    </div>

    @if(count($comments['last_comment']) != 0)
        @foreach($comments['last_comment'] as $avis)
            <div id="{{ $avis->id }}" class="row">
                <div class="center aligned three wide column">
                    <a href="{{ route('user.profile', $avis['user']['user_url']) }}"><img class="ui tiny avatar image" src="{{ Gravatar::src($avis['user']['email']) }}">
                        {{ $avis['user']['username'] }}</a>
                    <br />
                    {!! roleUser($avis['user']['role']) !!}
                </div>
                <div class="AvisBox center aligned twelve wide column ui comment">
                    <div class="ui threaded comments">
                    <table class="ui {!! affichageThumbBorder($avis['thumb']) !!} table">
                        <tr>
                            {!! affichageThumb($avis['thumb']) !!}
                            <td class="right aligned">Déposé le {{ formatDate('full', $avis['created_at']) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="AvisResume">
                                {!! $avis['message'] !!}
                            </td>
                        </tr>
                    </table>
                    <div class="left aligned actions">
                        <?php $count_reactions = count($avis['children']) ?>
                        @if($count_reactions)
                            <span class="t-grey">{{ $count_reactions }}
                                @if($count_reactions > 1)
                                    réponses
                                @else
                                    réponse
                                @endif </span>
                            <div class="ui vertical animated button showReactions" tabindex="0">
                                <div class="visible content">Voir les réponses</div><div class="hidden content"><i class="down arrow icon"></i></div>
                            </div>
                        @endif
                        @if(Auth::check())
                            <button id="{{ $avis->id }}" username="{{ $avis->user->username }}" class="ui darkBlueSA button writeReaction">Répondre</button>
                        @endif
                    </div>
                    <div class="divReactions comments" style="display: none;">
                        @foreach($avis['children'] as $reaction)
                            <div class="comment">
                                <a class="avatar">
                                    <img src="{{ Gravatar::src($reaction->user->email) }}">
                                </a>
                                <div class="content">
                                    <a class="author" href="{{route('user.profile', $reaction->user->user_url)}}">{{ $reaction->user->username }}</a>
                                    <div class="metadata">
                                <span class="date">{!! formatDate('full', $reaction->created_at) !!}
                                    @if($reaction->created_at != $reaction->updated_at)
                                        (modifié le {!! formatDate('full', $reaction->updated_at) !!})
                                    @endif</span>
                                    </div>
                                    <div class="text">
                                        {!! $reaction->message !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <br>
                </div>
                </div>
            </div>
        @endforeach
    @else
        Pas d'avis pour l'instant...
    @endif

    <div class="row">
        <div class="column center aligned">
            {{ $comments['last_comment']->links() }}
        </div>
    </div>
    @if(Auth::check())
        @include('comments.form_reaction')
    @endif
@endif

@push('scripts')
    <script src="/js/article.show.js"></script>
@endpush
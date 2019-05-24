<div id="LastComments" class="ui threaded comments">
    @foreach($comments['last_comment'] as $comment)
        <div class="comment">
            <a class="avatar">
                <img src="{{ Gravatar::src($comment['user']['email']) }}"  alt="Avatar {{$comment['user']['username']}}">
            </a>
            <div class="content">
                <a class="author" href="{{ route('user.profile', $comment['user']['user_url'] )}}">{{ $comment['user']['username'] }}</a>
                <div class="metadata">
                    <span class="date">{!! formatDate('full', $comment->created_at) !!}
                        @if($comment->created_at != $comment->updated_at)
                            (modifié le {!! formatDate('full', $comment->updated_at) !!})
                        @endif
                    </span>
                </div>
                <div class="text">
                    @if($comment->spoiler)
                        <p>Le résumé de cet avis contient des spoilers, cliquez sur \"Lire l'avis complet\" pour le consulter.</p>
                    @else
                        {!! $comment->message !!}
                    @endif
                </div>
            </div>
            <div class="actions">
                <?php $count_reactions = count($comment['children']) ?>
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
                    <button id="{{ $comment->id }}" username="{{ $comment->user->username }}" class="ui darkBlueSA button writeReaction">Répondre</button>
                @endif
            </div>
            <div class="divReactions comments" style="display: none;">
                @foreach($comment['children'] as $reaction)
                    <div class="comment">
                        <a class="avatar">
                            <img src="{{ Gravatar::src($reaction->user->email) }}" alt="Avatar {{$reaction->user->username}}">
                        </a>
                        <div class="content">
                            <a class="author">{{ $reaction->user->username }}</a>
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
    @endforeach
    <div class="row">
        <div class="column center aligned">
            {{ $comments['last_comment']->links() }}
        </div>
    </div>
</div>
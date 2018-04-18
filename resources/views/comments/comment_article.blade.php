<div id="LastComments" class="ui threaded comments">
    @foreach($comments['last_comment'] as $comment)
        <div class="comment">
            <a class="avatar">
                <img src="{{ Gravatar::src($comment['user']['email']) }}">
            </a>
            <div class="content">
                <a class="author" href="{{ route('user.profile', $comment['user']['username'] )}}">{{ $comment['user']['username'] }}</a>
                <div class="metadata">
                    <span class="date">{!! formatDate('full', $comment->created_at) !!}
                        @if($comment->created_at != $comment->updated_at)
                            (modifié le {!! formatDate('full', $comment->updated_at) !!})
                        @endif
                    </span>
                </div>
                <div class="text">
                    {!! $comment->message !!}
                </div>
            </div>
            <div class="actions">
                <button id="showReactions" class="ui button">Voir les réponses</button>
                <button id="{{ $comment->id }}" class="ui button writeReaction">Répondre</button>
            </div>
            <div class="divReactions comments" style="display: none;">
                @foreach($comment['children'] as $reaction)
                    <div class="comment">
                        <a class="avatar">
                            <img src="{{ Gravatar::src($reaction->user->email) }}">
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
    {{ $comments['last_comment']->links() }}
    @include('comments.form_reaction')
</div>
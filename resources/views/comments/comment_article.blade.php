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
            <div class="comments">
                <div class="comment">
                    <a class="avatar">
                        <img src="https://framasoft.org/nav/img/logo.png">
                    </a>
                    <div class="content">
                        <a class="author">Jenny Hess</a>
                        <div class="metadata">
                            <span class="date">Just now</span>
                        </div>
                        <div class="text">
                            Elliot you are always so right :)
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <div class="actions">
                <button class="ui button">Répondre</button>
            </div>
        </div>
    @endforeach
    {{ $comments['last_comment']->links() }}
</div>


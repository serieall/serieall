<div id="LastComments" class="ui comments">
    @foreach($comments['last_comment'] as $comment)
        <div class="comment">
            <a class="avatar">
                <img src="{{ Gravatar::src($comment['user']['email']) }}">
            </a>
            <div class="content">
                <a class="author" href="{{ route('user.profile', $comment['user']['username'] )}}">{{ $comment['user']['username'] }}</a>
                <div class="metadata">
                    <span class="date">{{ formatDate('short', $comment->created_at) }}</span>
                </div>
                <div class="text">
                    {!! $comment->message !!}
                </div>
                <div class="actions">
                    <a class="reply">Répondre</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
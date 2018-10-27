<div class="row">
    <div class="center aligned three wide column">
        <a href="{{ route('user.profile', str_slug($user['Username'])) }}">
            <img class="ui tiny avatar image" src="{{ Gravatar::src($user['Email']) }}"> <br/>
            {{ $user['Username'] }}
        </a>
        <br />
        <span class="ui text">{{ $user['Role'] }}</span>
    </div>
    <div class="twelve wide column">
        <blockquote>
            {!! $user['Quote'] !!}
        </blockquote>
    </div>
</div>
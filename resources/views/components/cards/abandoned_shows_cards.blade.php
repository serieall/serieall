<div class="item card">
    <div class="image">
        <img src="{{ getImage($show->thetvdb_id, "", $show->show_url, "banner", "175_100") }}" alt="Image illustrative de {{$show->name}}">
    </div>
    <div class="content">
        <a class="header" href="{{route('show.fiche', $show->show_url)}}">{{$show->name}}</a>
        <div class="meta">
            <span>{{$show->message}}</span>
        </div>
        <div class="description">
            @if(Auth::Check() && Auth::user()->user_url == $user->user_url)
                <form method="post" class="ui form delete" action="{{ route('user.unfollowshow', [$show->sid]) }}">
                    {{ csrf_field() }}

                    <button class="ui right floated icon basic button"><i class="close icon"></i>Supprimer</button>
                </form>
            @endif
        </div>
    </div>
</div>
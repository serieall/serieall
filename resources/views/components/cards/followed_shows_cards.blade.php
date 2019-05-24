<div class="card">
    <a class="image" href="{{route('show.fiche', $show->show_url)}}">
        <img src="{{ShowPicture($show->show_url)}}" alt="Image illustrative de {{$show->name}}">
    </a>
    <div class="content">
        <div class="header">
            <a class="image" href="{{route('show.fiche', $show->show_url)}}">
                {{$show->name}}
            </a>
        </div>
        <div class="meta">
            <p></p>
            @if(Auth::Check() && Auth::user()->user_url == $user->user_url)
                <form method="post" class="ui form delete" action="{{ route('user.unfollowshow', [$show->sid]) }}">
                    {{ csrf_field() }}

                    <button class="ui fluid icon basic button"><i class="close icon"></i>Supprimer</button>
                </form>
            @endif
        </div>
    </div>
</div>
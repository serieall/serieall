<a id="all" class="ui @if($filter_home == "all") blue @endif label">
    Tout
</a>
<a id="rates" class="ui @if($filter_home == "rates") blue @endif label">
    <i class="sort numeric down icon"></i>
    Notes
</a>
<a id="comments" class="ui @if($filter_home == "comments") blue @endif  label">
    <i class="comment icon"></i>
    Avis
</a>
<div class="ui feed">
    @foreach($fil_actu as $actu)
        <div class="event">
            <div class="label">
                <img src="{{ Gravatar::src($actu->user->email) }}">
            </div>
            <div class="content">
                <div class="date">
                    {!! formatDate('full', $actu->created_at) !!}
                </div>
                <div class="summary">
                    @if($actu->type == "rate")
                        <a class="underline-from-left" href="{{ route('user.profile', $actu->user->user_url) }}">{{ $actu->user->username }}</a> a mis {!! affichageNote($actu->rate) !!} à {!! printShowEpisode($actu->episode->show->name, $actu->episode->show->show_url, $actu->episode->season->name, $actu->episode->numero, $actu->episode->id) !!}
                    @elseif($actu->type == "comment")
                        <a class="underline-from-left" href="{{ route('user.profile', $actu->user->user_url) }}">{{ $actu->user->username }}</a>  a
                        @if($actu->commentable_type == "App\Models\Episode")
                            commenté l'épisode {!! printShowEpisode($actu->commentable->show->name, $actu->commentable->show->show_url, $actu->commentable->season->name, $actu->commentable->numero, $actu->commentable->id) !!} {!! affichageThumbIcon($actu->thumb) !!}
                        @elseif($actu->commentable_type == "App\Models\Season")
                            commenté la saison {!! printShowSeason($actu->commentable->show->name, $actu->commentable->show->show_url, $actu->commentable->name) !!} {!! affichageThumbIcon($actu->thumb) !!}
                        @elseif($actu->commentable_type == "App\Models\Show")
                            commenté la série {!! printShow($actu->commentable->name, $actu->commentable->show_url) !!} {!! affichageThumbIcon($actu->thumb) !!}
                        @elseif($actu->commentable_type == "App\Models\Article")
                            commenté l'article {!! printArticle($actu->commentable->name, $actu->commentable->article_url) !!}
                        @else
                            répondu au commentaire de <a class="underline-from-left" href="{{ route('user.profile', $actu->parent->user->user_url) }}">{{ $actu->parent->user->username }}</a> sur
                            @if($actu->parent->commentable_type == "App\Models\Episode")
                                {!! printShowEpisode($actu->parent->commentable->show->name, $actu->parent->commentable->show->show_url, $actu->parent->commentable->season->name, $actu->parent->commentable->numero, $actu->parent->commentable->id) !!}
                            @elseif($actu->parent->commentable_type == "App\Models\Season")
                                {!! printShowSeason($actu->parent->commentable->show->name, $actu->parent->commentable->show->show_url, $actu->parent->commentable->name) !!}
                            @elseif($actu->parent->commentable_type == "App\Models\Show")
                                {!! printShow($actu->parent->commentable->name, $actu->parent->commentable->show_url) !!}
                            @elseif($actu->parent->commentable_type == "App\Models\Article")
                                {!! printArticle($actu->parent->commentable->name, $actu->parent->commentable->article_url) !!}
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>
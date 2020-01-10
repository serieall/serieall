<a id="all" class="ui @if($filter_home == "all") blue @endif label filter">
    Tout
</a>
<a id="rates" class="ui @if($filter_home == "rates") blue @endif label filter">
    <i class="sort numeric down icon"></i>
    Notes
</a>
<a id="comments" class="ui @if($filter_home == "comments") blue @endif label filter">
    <i class="comment icon"></i>
    Avis
</a>
<div class="ui feed">
    @foreach($fil_actu as $actu)
        <div class="event">
            <div class="label">
                @if($actu->type != "article")
                    <img src="{{ Gravatar::src($actu->user->email) }}" alt="{{$actu->user->username}}">
                @else

                    <img src="{{ Gravatar::src($actu->users[0]->email) }}" alt="{{$actu->users[0]->username}}">
                @endif
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
                    @elseif($actu->type == "article")
                        @foreach($actu->users as $user)<a class="underline-from-left" href="{{ route('user.profile', $user->user_url) }}">{{ $user->username }}</a> @if(!$loop->last),@endif @endforeach @if(count($actu->users) > 1)ont @else a @endif écrit un <i class="ui icon file alternate outline"></i>article : <a class="underline-from-left" href="{{ route('article.show', $actu->article_url) }}">{{$actu->name}}</a>
                    @endif
                </div>
                @if($actu->type == "article")
                <div class="extra images">
                    @foreach($actu->users as $user)
                        @if(!$loop->first)
                            <img class="ui mini circular image" src="{{ Gravatar::src($user->email) }}" alt="{{$user->username}}">
                        @endif
                    @endforeach
                </div>
                    @endif
            </div>
        </div>
    @endforeach
</div>
@foreach($comments as $comment)
    <div class="card">
        <div class="image">
            @if($comment->commentable_type == 'App\Models\Show')
                <img src="{{ShowPicture($comment->commentable->show_url)}}" alt="Image de la série">
            @else
                <img src="{{ShowPicture($comment->commentable->show->show_url)}}" alt="Image de la série">
            @endif
        </div>
        <div class="content">
            @if($comment->commentable_type == 'App\Models\Show')
                <a class="header" href="{{route('show.fiche', $comment->commentable->show_url)}}">{{$comment->commentable->name}}</a>
            @endif
        </div>
        <div class="extra">
            <b>Avis
                @if($comment->thumb == 1)
                    <span class="t-green">Favorable</span>
                @elseif($comment->thumb == 2)
                    <span class="t-grey">Neutre</span>
                @else
                    <span class="t-red">Défavorable</span>
                @endif
            </b><br>
            <a href="#">Lire l'avis</a>
        </div>
    </div>
@endforeach
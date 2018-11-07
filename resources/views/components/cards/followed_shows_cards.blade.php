<div class="card">
    <div class="image">
        <img src="{{ShowPicture($show->show_url)}}">
    </div>
    <div class="content">
        <a class="header" href="{{route('show.fiche', $show->show_url)}}">{{$show->name}}</a>
    </div>
    <div class="extra">
        <a class="left floated">
            <i class="star icon"></i>
            {{ $show->nbnotes }}
            @if($show->nbnotes > 1)
                notes
            @else
                note
            @endif
        </a>
        <a class="right floated">
            <i class="heartbeat icon"></i>
            {!! affichageNote($show->moyenne) !!}
        </a>
    </div>
</div>
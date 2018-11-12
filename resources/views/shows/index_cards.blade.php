<div class="row">
    <div class="ui six special cards stackable">
        @foreach($shows as $show)
            <div class="card">
                <div class="blurring dimmable image">
                    <div class="ui dimmer">
                        <div class="content">
                            <div class="center">
                                <a href="{{ route('show.fiche', $show->show_url) }}">
                                    <div class="ui inverted button">Voir la fiche série</div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <img src="{{ ShowPicture($show->show_url) }}">
                </div>
                <div class="content">
                    <a href="{{ route('show.fiche', $show->show_url) }}" class="header">{{ $show->name }}</a>
                    <div class="meta">
                        @foreach($show->genres as $genre)
                            {{ $genre->name }}
                            @if(!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="extra content">
                    <a>
                        <i class="calendar icon"></i>
                        {{ $show->annee }}
                    </a>
                    <a class="right floated">
                        <i class="heartbeat icon"></i>
                        {!! affichageNote($show->moyenne) !!}
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>

<div class="PaginateRow row">
    <div class="column center aligned">
        {{ $shows->links() }}
    </div>
</div>
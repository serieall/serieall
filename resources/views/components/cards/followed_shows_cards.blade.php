<div class="card">
    <a class="image" href="{{route('show.fiche', $show->show_url)}}">
        <img src="{{ShowPicture($show->show_url)}}">
    </a>
    <div class="content">
        <div class="header">
            <a class="image" href="{{route('show.fiche', $show->show_url)}}">
                {{$show->name}}
            </a>
        </div>
        <div class="meta">
            <p></p>
            <button class="ui fluid icon basic button"><i class="close icon"></i>Supprimer</button>
        </div>
    </div>
</div>
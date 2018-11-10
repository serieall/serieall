<div class="item card">
    <div class="image">
        <img src="{{ShowPicture($show->show_url)}}">
    </div>
    <div class="content">
        <a class="header" href="{{route('show.fiche', $show->show_url)}}">{{$show->name}}</a>
        <div class="meta">
            <span>{{$show->message}}</span>
        </div>
        <div class="description">
            <button class="ui right floated icon basic button"><i class="close icon"></i>Supprimer</button>
        </div>
    </div>
</div>
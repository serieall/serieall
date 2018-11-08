<div class="card">
    <div class="image">
        <img src="{{ShowPicture($show->show_url)}}">
    </div>
    <div class="content">
        <i class="right floated close icon"></i>
        <a class="header" href="{{route('show.fiche', $show->show_url)}}">{{$show->name}}</a>

    </div>
</div>
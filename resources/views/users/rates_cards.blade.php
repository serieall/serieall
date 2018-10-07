@foreach($rates as $rate)
    <div class="card">
        <div class="image">
            <img src="{{ShowPicture($rate->show_url)}}">
        </div>
        <div class="content">
            <a class="header" href="{{route('show.fiche', $rate->show_url)}}">{{$rate->name}}</a>
        </div>
        <div class="extra">
            Nombre de notes: <b>{{$rate->nb_rate}}</b> / Note : <b>{!! affichageNote($rate->avg_rate) !!}</b>
        </div>
    </div>
@endforeach
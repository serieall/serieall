<h2>{{ $title }}</h2>

<div class="ui fluid card imageFirstClassement">
    <div class="image">
        <img src="{{ ShowPicture($picture_show) }}">
    </div>
</div>

<div class="ui items">
    @foreach($objects as $object)
        <div class="item">
            <div class="content">
                <div class="header">
                    @if($loop->index == 0)
                        <i class="yellow trophy icon"></i>
                    @elseif($loop->index == 1)
                        <i class="grey trophy icon"></i>
                    @elseif($loop->index == 2)
                        <i class="brown trophy icon"></i>
                    @endif
                    {{ $loop->index + 1 }}. {{ $name_link }}
                    @if($slot == 'Show')
                         <a href="{{ route('show.fiche', $object->show_url) }}">{{ $object->name }}</a>
                    @elseif($slot == 'Season')
                        {{ $loop->index + 1 }}. <a href="{{ route('season.fiche', [$object->show->show_url, $object->name]) }}">{{$object->show->name}} Saison {{ $object->name }}</a>
                    @elseif($slot == 'Episode')
                        {{ $loop->index + 1 }}. <a href="{{ route('episode.fiche', [$object->show->show_url, $object->season->name, $object->numero, $object->id]) }}">{{$object->show->name}} / {{ sprintf('%02s', $object->season->name) }}.{{ $object->numero }} {{ $object->name }}</a>
                    @endif
                </div>
                <div class="description">
                    <p>
                        Note : {!! affichageNote($avg_rate) !!} /
                        Avec <b>{{ $number_rates }}</b> notes <br />
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>
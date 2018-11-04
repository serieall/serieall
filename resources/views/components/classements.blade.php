<div class="ui items">
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
                {{ $loop->index + 1 }}. {{ $slot }}
            </div>
            <div class="description">
                <p>
                    Note : {!! affichageNote($avg_rate) !!} /
                    Avec <b>{{ $number_rates }}</b> notes <br />
                </p>
            </div>
        </div>
    </div>
</div>
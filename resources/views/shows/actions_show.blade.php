@for ($i = 1; $i < 6; $i++)
    @if($i == 3 && $completed_show == 1)
            @continue
    @endif

    @if($state_show == $i)
        <form class="ui form noaction">
            <button class="ui button darkBlueSA">
                @if($i == 1)
                <i class="play icon"></i>
                Je regarde la série
                @elseif($i == 2)
                <i class="pause icon"></i>
                Je mets en pause la série
                @elseif($i == 5)
                <i class="eye icon"></i>
                Je veux voir cette série
                @elseif($i == 3)
                <i class="flag checkered icon"></i>
                J'ai terminé la série
                @elseif($i == 4)
                <i class="stop icon"></i>
                J'abandonne la série
                @endif
            </button>
        </form>
    @else
        <form class="ui form followshow" method="post" action="{{ route('user.followshowfiche') }}">
            {{ csrf_field() }}

            <input type="hidden" name="state" value={{ $i }}>
            <input type="hidden" name="shows" value="{{ $show_id }}">
            <button class="ui button">
                @if($i == 1)
                <i class="play icon"></i>
                Je regarde la série
                @elseif($i == 2)
                <i class="pause icon"></i>
                Je mets en pause la série
                @elseif($i == 5)
                <i class="eye icon"></i>
                Je veux voir cette série
                @elseif($i == 3)
                <i class="flag checkered icon"></i>
                J'ai terminé la série
                @elseif($i == 4)
                <i class="stop icon"></i>
                J'abandonne la série
                @endif
            </button>
        </form>
    @endif
@endfor
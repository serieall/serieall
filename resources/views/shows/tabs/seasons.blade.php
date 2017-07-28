<table class="ui padded table center aligned">
    @foreach($season->episodes as $episode)
        <tr>
            <td>
                @if($episode->numero == 0)
                    <a href="#">Episode spécial</a>
                @else
                    <a href="#">Episode {{ $season->name }}.{{ $episode->numero }}</a>
                @endif
            </td>
            <td>
                {{ $episode->name }}
            </td>
            <td>
                @if($episode->moyenne > $noteGood)
                    <p class="ui green text">
                @elseif($episode->moyenne > $noteNeutral && $episode->moyenne < $noteGood)
                    <p class="ui gray text">
                @else
                    <p class="ui red text">
                        @endif
                        {{ $episode->moyenne }}
                    </p>

            </td>
            <td>
                24
                <i class="green smile large icon"></i>

                12
                <i class="grey meh large icon"></i>

                3
                <i class="red frown large icon"></i>
            </td>
        </tr>
    @endforeach
</table>
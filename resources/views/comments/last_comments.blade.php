@if(!$comments['last_comment'])
    <div class="row">
        <div class="ui message">
            <p>
                @if(isset($comments['user_comment']))
                    {!! messageComment($object['model'], $comments['user_comment']) !!}
                @else
                    {!! messageComment($object['model'], null) !!}
                @endif
            </p>
        </div>
    </div>
    <div class="ui divider"></div>
@else
    <div class="row">
        <div class="column center aligned">
            {{ $comments['last_comment']->links() }}
        </div>
    </div>

    @if(count($comments['last_comment']) != 0)
        @foreach($comments['last_comment'] as $avis)
            <div id="{{ $avis->id }}" class="row">
                <div class="center aligned three wide column">
                    <a href="{{ route('user.profile', $avis['user']['username']) }}"><img class="ui tiny avatar image" src="{{ Gravatar::src($avis['user']['email']) }}">
                        {{ $avis['user']['username'] }}</a>
                    <br />
                    {!! roleUser($avis['user']['role']) !!}
                </div>
                <div class="AvisBox center aligned twelve wide column">
                    <table class="ui {!! affichageThumbBorder($avis['thumb']) !!} table">
                        <tr>
                            {!! affichageThumb($avis['thumb']) !!}
                            <td class="right aligned">Déposé le {{ formatDate('full', $avis['created_at']) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="AvisResume">
                                {!! $avis['message'] !!}
                            </td>
                        </tr>
                    </table>
                    <div class="left aligned reactions">

                    </div>
                </div>
            </div>
        @endforeach
    @else
        Pas d'avis pour l'instant...
    @endif

    <div class="row">
        <div class="column center aligned">
            {{ $comments['last_comment']->links() }}
        </div>
    </div>
@endif
@if(count($shows) == 0)
    @component('components.message_simple', ['type' => 'info'])
        Pas de séries dans cette section.
    @endcomponent
@endif
<div id="cardsRates" class="ui five cards stackable">
    @foreach($shows as $show)
        @component('components.cards.followed_shows_cards', ['show' => $show, 'user' => $user])
        @endcomponent
    @endforeach
</div>
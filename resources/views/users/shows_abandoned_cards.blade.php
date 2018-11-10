@if(count($shows) == 0)
    @component('components.message_simple', ['type' => 'info'])
        Pas de séries abandonées
    @endcomponent
@endif
<div id="cardsRates" class="ui items stackable">
    @foreach($shows as $show)
        @component('components.cards.abandoned_shows_cards', ['show' => $show])
        @endcomponent
    @endforeach
</div>
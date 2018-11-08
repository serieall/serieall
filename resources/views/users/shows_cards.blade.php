@if(count($in_progress_shows) == 0)
    @component('components.message_simple', ['type' => 'info'])
        Pas de séries en cours
    @endcomponent
@endif
<div id="cardsRates" class="ui five cards stackable">
    @foreach($in_progress_shows as $show)
        @component('components.cards.followed_shows_cards', ['show' => $show])
        @endcomponent
    @endforeach
</div>
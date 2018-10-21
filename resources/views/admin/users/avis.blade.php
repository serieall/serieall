<div class="ui form">
    <input type="hidden" value="{{ $comment->id }}">

    @component('components.dropdown_thumb')
        {!! $comment->thumb !!}
    @endcomponent

    @component('components.editor_comment')
        {!! $comment->message !!}
    @endcomponent

    <!-- Bouger l'avis -->

    <br />
    <div class="four wide column">
        <div class="flex-center">
            @component('components.button_submit')
                Modifier
            @endcomponent

            @component('components.button_delete')
                @slot('route')
                    {!! route('admin.users.destroyComment', $comment->id) !!}
                @endslot
                @slot('title')
                    Supprimer cet avis ?
                @endslot
                Supprimer
            @endcomponent
        </div>
    </div>

    <!-- Tableau des réactions -->
</div>
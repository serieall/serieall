<div class="ui form">
    <input type="hidden" value="{{ $comment->id }}">

    @component('components.dropdowns.dropdown_thumb')
        {!! $comment->thumb !!}
    @endcomponent

    @component('components.editors.editor_comment')
        {!! $comment->message !!}
    @endcomponent

    <!-- Bouger l'avis -->

    <br />
    <div class="four wide column">
        <div class="flex-center">
            @component('components.buttons.button', ['type' => 'positive'])
                Modifier
            @endcomponent

            @component('components.buttons.button_delete', ['type' => ''])
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
    <h2>Réactions</h2>
    @component('components.tables.table_admin', ['headers' => ["Utilisateur", "Message", "Actions"]])
        @foreach($comment->children as $reaction)
            <tr class="line">
                <td>
                    {{ $reaction->user->username }}
                </td>
                <td>
                    {{ $reaction->message }}
                </td>
                <td class="center aligned">
                    <div class="four wide column">
                        <div class="flex-center">
                            @component('components.buttons.button', ['type' => 'blue circular icon'])
                                <i class="edit icon"></i>
                            @endcomponent

                            @component('components.buttons.button_delete', ['type' => 'circular icon'])
                                @slot('route')
                                    {!! route('admin.users.destroyComment', $comment->id) !!}
                                @endslot
                                @slot('title')
                                    Supprimer cette réaction ?
                                @endslot
                                <i class="remove icon"></i>
                            @endcomponent
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    @endcomponent
</div>
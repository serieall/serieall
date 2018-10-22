@component('components.tables.table_admin', ['headers' => ["Utilisateur", "Message", "Nombre de réactions", "Actions"]])
    @foreach($comments as $comment)
        <tr class="line">
            <td>
                {{ $comment->user->username }}
            </td>
            <td>
                {!! cutResume($comment->message) !!}
            </td>
            <td>
                {{ count($comment->children) }}
            </td>
            <td class="center aligned">
                <div class="four wide column">
                    <div class="flex-center">
                        <a href="{{ route('admin.comments.edit', $comment->id) }}">
                            @component('components.buttons.button', ['type' => 'blue circular icon'])
                                <i class="edit icon"></i>
                            @endcomponent
                        </a>
                        @component('components.buttons.button_delete', ['type' => 'circular icon'])
                            @slot('route')
                                {!! route('admin.comments.destroy', $comment->id) !!}
                            @endslot
                            @slot('title')
                                Supprimer cet avis ?
                            @endslot
                            <i class="remove icon"></i>
                        @endcomponent
                    </div>
                </div>
            </td>
        </tr>
    @endforeach
@endcomponent
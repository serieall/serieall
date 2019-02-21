@component('components.tables.table_admin', ['headers' => ["Nom d'utilisateur", "Rôle", "Créé le", "Actions"]])
    <tr class="line">
        <td>
            <a href="{{ route('admin.users.edit', $user->id) }}">{{ $user->username }}</a>
        </td>
        <td>
            {!! roleUser($user->role)  !!}
        </td>
        <td>
            {{ $user->created_at }}
        </td>
        <td class="center aligned">
            <div class="four wide column">
                @if($user->suspended == 0)
                    <form action="{{ route('admin.users.ban', $user->id) }}" method="post" style="display:inline-flex">
                        {{ csrf_field() }}

                        <button class="circular ui orange icon button" title="Bannir l'utilisateur ?" value="Bannir cet utilisateur ?" onclick="return confirm('Voulez-vous vraiment bannir cet utilisateur ?')">
                            <i class="ui ban icon"></i>
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.users.ban', $user->id) }}" method="post">
                        {{ csrf_field() }}

                        <button class="circular ui green icon button" title="Débannir l'utilisateur ?" value="Autoriser cet utilisateur ?" onclick="return confirm('Voulez-vous vraiment autoriser cet utilisateur ?')">
                            <i class="ui checkmark icon"></i>
                        </button>
                    </form>
                @endif
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" style="display:inline">
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="DELETE">

                    <button class="circular ui red icon button" title="Supprimer l'utilisateur ?" value="Supprimer cet utilisateur ?" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                        <i class="ui close icon"></i>
                    </button>
                </form>
            </div>
            <div class="four wide column">

            </div>
        </td>
    </tr>
@endcomponent
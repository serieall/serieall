@component('components.tables.table_admin', ['headers' => ["Nom", "Chaines", "Nationalités", "Nombre de saison", "Nombre d'épisodes", "Actions"]])
    <tr class="line">
        <td>
            <a href="{{ route('admin.shows.edit', $show->id) }}">{{ $show->name }}</a>
        </td>
        <td>
            @foreach($show->channels as $channel)
                {{ $channel->name }}
                <br />
            @endforeach
        </td>
        <td>
            @foreach($show->nationalities as $nationality)
                {{ $nationality->name }}
                <br />
            @endforeach
        </td>
        <td class="center aligned">
            {{ $show->seasons->count() }}
        </td>
        <td class="center aligned">
            {{ $show->episodes->count()}}
        </td>
        <td class="center aligned">
            <div class="four wide column">
                <!-- Formulaire de suppression -->
                <form action="{{ route('admin.shows.destroy', $show->id) }}" method="post" >
                    {{ csrf_field() }}

                    <input type="hidden" name="_method" value="DELETE">

                    <button class="circular ui red icon button" value="Supprimer cette série ?" onclick="return confirm('Voulez-vous vraiment supprimer cette série ?')">
                        <i class="icon remove"></i>
                    </button>
                </form>
            </div>
        </td>
    </tr>
@endcomponent
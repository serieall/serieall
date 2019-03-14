@component('components.tables.table_admin_articles', ['headers' => ["Titre de l'article", "Chapô", "Catégorie", "Auteur(s)", "Date d'écriture", "Date de publication", "Actions"]])
    @for ($i = 0 ; $i < 10;  $i++)
        <tr class="line">
            <td>
                <a href="{{ route('admin.articles.edit', $articles[$i]->id) }}" title="Modifier l'article">{{ $articles[$i]->name }}</a>
            </td>
            <td>
                {{ $articles[$i]->intro }}
            </td>
            <td>
                {{ $articles[$i]->category->name }}
            </td>
            <td>
                @foreach($articles[$i]->users as $autor)
                    {{ $autor->username }}
                @endforeach
            </td>
            <td>
                {{ $articles[$i]->created_at }}
            </td>
            <td>
                {{ $articles[$i]->published_at }}
            </td>
            <td class="center aligned">
                <div class="four wide column">
                    <div class="flex-center">
                        <button class="circular ui blue icon button" title="Voir l'aperçu de l'article" onclick="window.open('{{ route('article.show', $articles[$i]->article_url) }}')">
                            <i class="icon eye"></i>
                        </button>
                        <!-- Formulaire de suppression -->
                        <form action="{{ route('admin.articles.destroy', $articles[$i]->id) }}" method="post" >
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="circular ui red icon button" title="Supprimer l'article" value="Supprimer cet article ?" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">
                                <i class="icon remove"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </td>
    </tr>
    @endfor
@endcomponent

@component('components.tables.table_admin', ['headers' => ["Titre de l'article", "Chapô", "Catégorie", "Auteur(s)", "Date d'écriture", "Date de publication", "Actions"]])
    <tr class="line">
        <td>
            <a href="{{ route('admin.articles.edit', $article->id) }}" title="Modifier l'article">{{ $article->name }}</a>
        </td>
        <td>
            {{ $article->intro }}
        </td>
        <td>
            {{ $article->category->name }}
        </td>
        <td>
            @foreach($article->users as $autor)
                {{ $autor->username }}
            @endforeach
        </td>
        <td>
            {{ $article->created_at }}
        </td>
        <td>
            {{ $article->published_at }}
        </td>
        <td class="center aligned">
            <div class="four wide column">
                <div class="flex-center">
                    <button class="circular ui blue icon button" title="Voir l'aperçu de l'article" onclick="window.open('{{ route('article.show', $article->article_url) }}')">
                        <i class="icon eye"></i>
                    </button>
                    <!-- Formulaire de suppression -->
                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="post" >
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
@endcomponent
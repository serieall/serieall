@extends('layouts.admin')

@section('pageTitle', 'Admin - Articles')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Articles
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="adminTitre">
                    Articles
                    <span class="sub header">
                        Liste de tous les articles présents sur Série-All
                    </span>
                </h1>
            </div>
            <div class="ui height wide column">
                <div class="ui height wide column">
                    <form action="{{ route('admin.articles.create') }}">
                        <button class="ui right floated green button">
                            <i class="ui add icon"></i>
                            Ajouter un nouvel article
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <table id="tableAdmin" class="ui sortable selectable celled table">
            <thead>
            <tr>
                <th>Titre de l'article</th>
                <th>Chapô</th>
                <th>Catégorie</th>
                <th>Auteur</th>
                <th>Date d'écriture</th>
                <th>Date de publication</th>
                <th>Actions</th>
            </tr>
            </thead>
            @foreach($articles as $article)
                <tr class="line">
                    <td>
                        <a href="{{ route('admin.articles.edit', $article->id) }}">{{ $article->name }}</a>
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
                            <!-- Formulaire de suppression -->
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="post" >
                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="DELETE">

                                <button class="circular ui red icon button" value="Supprimer cet article ?" onclick="return confirm('Voulez-vous vraiment supprimer cet article ?')">
                                    <i class="icon remove"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $('#tableAdmin').DataTable( {
            "order": [[ 0, "asc" ]],
            "language": {
                "lengthMenu": "Afficher _MENU_ enregistrements par page",
                "zeroRecords": "Aucun enregistrement trouvé",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun enregistrement trouvé",
                "infoFiltered": "(filtré sur _MAX_ enregistrements)",
                "sSearch" : "",
                "oPaginate": {
                    "sFirst":    	"Début",
                    "sPrevious": 	"Précédent",
                    "sNext":     	"Suivant",
                    "sLast":     	"Fin"
                }
            }} );
    </script>
@endsection


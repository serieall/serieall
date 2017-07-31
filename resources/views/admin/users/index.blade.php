@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Utilisateurs
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="admin-titre">
                    Utilisateurs
                    <span class="sub header">
                    Liste de tous les utilisateurs de Série-All
                </span>
                </h1>
            </div>
            <div class="ui height wide column">
                <form action="{{ route('admin.users.create') }}">
                    <button class="ui right floated green button">
                        <i class="ui add icon"></i>
                        Ajouter un nouvel utilisateur
                    </button>
                </form>
            </div>
        </div>

        <table id="tableAdmin" class="ui sortable selectable celled table">
            <thead>
            <tr>
                <th>Nom d'utilisateur</th>
                <th>Rôle</th>
                <th>Créé le</th>
                <th>Actions</th>
            </tr>
            </thead>
            @foreach($users as $user)
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
                            <!-- Formulaire de suppression -->
                            <form action="{{ route('admin.users.destroy', [$user->id]) }}" method="post" >
                                {{ csrf_field() }}

                                <input type="hidden" name="_method" value="DELETE">

                                <button class="circular ui red icon button" value="Supprimer cet utilisateur ?" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                                    <i class="icon remove"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
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


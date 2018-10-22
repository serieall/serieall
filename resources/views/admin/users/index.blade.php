@extends('layouts.admin')

@section('pageTitle', 'Admin - Utilisateurs')

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
                <h1 class="ui header" id="adminTitre">
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
                            @if($user->suspended == 0)
                                <form action="{{ route('admin.users.ban', $user->id) }}" method="post">
                                    {{ csrf_field() }}

                                    <button class="circular ui red icon button" value="Bannir cet utilisateur ?" onclick="return confirm('Voulez-vous vraiment bannir cet utilisateur ?')">
                                        <i class="ui ban icon"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.users.ban', $user->id) }}" method="post">
                                    {{ csrf_field() }}

                                    <button class="circular ui green icon button" value="Autoriser cet utilisateur ?" onclick="return confirm('Voulez-vous vraiment autoriser cet utilisateur ?')">
                                        <i class="ui checkmark icon"></i>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@push('scripts')
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
@endpush


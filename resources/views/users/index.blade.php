@extends('layouts.app')

@section('pageTitle', 'Liste des membres')

@section('content')
    <div class="ui ten wide column">
        <div class="ui segment">
            <h1>Liste des membres</h1>

            <table id="member_list" class="ui sortable selectable celled table">
                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Rôle</th>
                        <th>Membre depuis le</th>
                    </tr>
                </thead>
                @foreach($users as $user)
                    <tr class="line">
                        <td>
                            <img class="ui avatar image" src="{{ Gravatar::src($user->email) }}" alt="Avatar de {{$user->username}}">
                            <a href="{{route('user.profile', $user->user_url)}}">{{ $user->username }}</a>
                        </td>
                        <td>
                            {!! roleUser($user->role) !!}
                        </td>
                        <td>
                            {!! formatDate('full', $user->created_at) !!}
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('#member_list').DataTable( {
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
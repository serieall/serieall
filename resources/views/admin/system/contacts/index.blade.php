@extends('layouts.admin')

@section('pageTitle', 'Admin - Contacts')

@section('breadcrumbs')
    <a href="{{ route('admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <a href="{{ route('admin.system') }}" class="section">
        Système
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Contacts
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="admin-titre">
                    Logs
                    <span class="sub header">
                        Liste de toutes les demandes de contact
                    </span>
                </h1>
            </div>
        </div>

        <table id="tableAdmin" class="ui sortable selectable celled table">
            <thead>
            <tr>
                <th>Objet</th>
                <th>Email</th>
                <th>Date</th>
            </tr>
            </thead>
            @foreach($contacts as $contact)
                <tr>
                    <td><a href="{{ route('admin.contacts.view', $contact->id) }}">{{ $contact->objet }}</a></td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->created_at }}</td>
                </tr>
            @endforeach
        </table>
    </div>

    <script>
        $('#tableAdmin').DataTable( {
            "order": [[ 4, "desc" ]],
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
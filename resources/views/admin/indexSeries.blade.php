@extends('layouts.admin')

@section('breadcrumbs')
    <li>
        <a href="{{ url('/admin') }}">
            Administration
        </a>
    </li>
    <li>
        Séries
    </li>
@endsection

@section('content')
    <div>
        <h1 id="content-h1-admin" class="txtcenter">Liste des séries</h1>

        <div class="grid-2">
            <table id="table-show-admin">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Chaines</th>
                        <th>Nationalités</th>
                        <th>Nombre de saisons</th>
                        <th>Nombre d'épisodes</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                @foreach($shows as $show)
                    <tr>
                        <td>
                            {{ $show->name }}
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
                        <td class="txtcenter">
                            {{ $show->seasons_count }}
                        </td>
                        <td class="txtcenter">
                            {{ $show->episodes_count }}
                        </td>
                        <td class="actions txtcenter">
                            <a href="#"><i class="fa fa-pencil fa-2x"></i></a>
                            <a href="#"><i class="fa fa-trash fa-2x"></i></a>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('#table-show-admin').DataTable( {
            "order": [[ 0, "asc" ]],
            "language": {
                "lengthMenu": "Afficher _MENU_ enregistrements par page",
                "zeroRecords": "Aucun enregistrement trouvé",
                "info": "Page _PAGE_ sur _PAGES_",
                "infoEmpty": "Aucun enregistrement trouvé",
                "infoFiltered": "(filtré sur _MAX_ enregistrements)",
                "sSearch" : "Recherche",
                "oPaginate": {
                    "sFirst":    	"Début",
                    "sPrevious": 	"Précédent",
                    "sNext":     	"Suivant",
                    "sLast":     	"Fin"
            }
        }} );
    </script>
@endsection
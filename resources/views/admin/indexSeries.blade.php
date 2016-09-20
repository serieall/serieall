@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ url('/admin') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Séries
    </div>
@endsection

@section('content')
    <div>
        <h1 class="ui header">
            Séries
            <div class="sub header">
                Liste de toutes les séries présentes sur Série-All
            </div>
        </h1>

        <div class="ui animated fade button" tabindex="0">
            <div class="visible content"><i class="plus icon"></i></div>
            <div class="hidden content">
                Ajouter une nouvelle série
            </div>
        </div>

        <table id="table-show-admin" class="ui sortable selectable celled table">
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
                    <td class="center aligned">
                        {{ $show->seasons_count }}
                    </td>
                    <td class="center aligned">
                        {{ $show->episodes_count }}
                    </td>
                    <td class="center aligned">
                        <a href="#" id="action">
                            <i class="big icons">
                                <i class="big thin circle icon"></i>
                                <i class="edit icon"></i>
                            </i>
                        </a>
                        <a href="#" id="action">
                            <i class="big icons">
                                <i class="big thin circle icon"></i>
                                <i class="trash icon"></i>
                            </i>
                        </a>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('scripts')
        $('#table-show-admin').DataTable( {
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
@endsection
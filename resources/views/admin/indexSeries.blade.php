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
    <div class="ui right floated green animated fade button" tabindex="0" id="add-serie">
        <div class="visible content">Ajouter une nouvelle série</div>
        <div class="hidden content">
            <i class="plus icon"></i>
        </div>
    </div>

    <div class="ui modal">
        <i class="close icon"></i>
        <div class="header">
            Profile Picture
        </div>
        <div class="image content">
            <div class="ui medium image">
                <img src="/images/avatar/large/chris.jpg">
            </div>
            <div class="description">
                <div class="ui header">We've auto-chosen a profile image for you.</div>
                <p>We've grabbed the following image from the <a href="https://www.gravatar.com" target="_blank">gravatar</a> image associated with your registered e-mail address.</p>
                <p>Is it okay to use this photo?</p>
            </div>
        </div>
        <div class="actions">
            <div class="ui black deny button">
                Nope
            </div>
            <div class="ui positive right labeled icon button">
                Yep, that's me
                <i class="checkmark icon"></i>
            </div>
        </div>
    </div>

    <div>
        <h1 class="ui header" id="admin-titre">
            Séries
            <div class="sub header">
                Liste de toutes les séries présentes sur Série-All
            </div>
        </h1>

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

        $('.ui.modal')
        .modal()
        ;
@endsection
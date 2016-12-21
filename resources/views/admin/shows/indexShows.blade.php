@extends('layouts.admin')

@section('breadcrumbs')
    <a href="{{ route('adminIndex') }}" class="section">
        Administration
    </a>
    <i class="right angle icon divider"></i>
    <div class="active section">
        Séries
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="admin-titre">
                    Séries
                    <div class="sub header">
                        Liste de toutes les séries présentes sur Série-All
                    </div>
                </h1>
            </div>
            <div class="ui height wide column">
                <div class="ui right floated green fade dropdown button">
                    <span class="text">Ajouter une nouvelle série</span>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                        <a class="item" href={{ route('adminShow.create') }}><i class="cloud download icon"></i> Création via The TVDB</a>
                        <a class="item" href={{ route('adminShow.createManually') }}><i class="signup icon"></i> Création manuelle</a>
                    </div>
                </div>
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
                        <div class="ui centered grid">
                            <div class="four wide column">
                                <!-- Formulaire d'édition -->
                                <form action="{{ route('adminShow.edit', $show->id) }}" method="get" >

                                    <button class="circular ui blue icon button" type="submit">
                                        <i class="icon edit"></i>
                                    </button>
                                </form>
                            </div>

                            <div class="four wide column">
                                <!-- Formulaire de suppression -->
                                <form action="{{ route('adminShow.destroy', $show->id) }}" method="post" >
                                    {{ csrf_field() }}

                                    <input type="hidden" name="_method" value="DELETE">

                                    <button class="circular ui red icon button" type="submit" value="Supprimer cette série ?" onclick="return confirm('Voulez-vous vraiment supprimer cette série ?')">
                                        <i class="icon remove"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="ui basic modal">
        <div class="ui two column middle aligned very relaxed stackable grid">
            <div class="center aligned column">
                <a href={{ route('adminShow.create') }}>
                    <div class="ui big teal labeled icon button">
                        <i class="cloud download icon"></i>
                        Création via TheTVDB
                    </div>
                </a>
            </div>
            <div class="ui vertical divider">
                Ou
            </div>
            <div class="center aligned column">
                <a href={{ route('adminShow.createManually') }}>
                    <div class="ui big green labeled icon button">
                        <i class="signup icon"></i>
                        Création manuelle
                    </div>
                </a>
            </div>
        </div>
    </div>

        <script>
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

            $('#add-serie')
                    .on('click', function() {
                        $('.ui.modal')
                                .modal({
                                    inverted: true
                                })
                                .modal('show')
                        ;
                    })
            ;
        </script>
@endsection


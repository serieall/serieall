@extends('layouts.admin')

@section('pageTitle', 'Admin - Slogans')

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
        Slogans
    </div>
@endsection

@section('content')
    <div>
        <div class="ui grid">
            <div class="ui height wide column">
                <h1 class="ui header" id="adminTitre">
                    Slogans
                    <span class="sub header">
                        Liste de tous les slogans de Série-All
                    </span>
                </h1>
            </div>
        </div>

        <table id="tableAdmin" class="ui sortable selectable celled table">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Source</th>
                    <th>Créé le</th>
                    <th>Action</th>
                </tr>
            </thead>
            @foreach($slogans as $slogan)
                <tr>
                    <td><a href="{{ route('admin.slogans.edit', $slogan->id) }}">{{ $slogan->message }}</a></td>
                    <td>{{ $slogan->source }}</td>
                    <td>{{ $slogan->created_at }}</td>
                    <td class="center aligned">
                        <!-- Formulaire de suppression -->
                        <form action="" method="post" >
                            {{ csrf_field() }}

                            <input type="hidden" name="_method" value="DELETE">

                            <button class="circular ui red icon button" value="Supprimer ce slogan ?" onclick="return confirm('Voulez-vous vraiment supprimer ce slogan ?')">
                                <i class="icon remove"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $('#tableAdmin').DataTable( {
            "order": [[ 1, "desc" ]],
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


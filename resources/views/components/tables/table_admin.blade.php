<table id="tableAdmin" class="ui sortable selectable celled table">
    <thead>
    <tr>
        @foreach($headers as $header)
            <th>{{$header}}</th>
        @endforeach
    </tr>
    </thead>
    {{ $slot }}
</table>

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
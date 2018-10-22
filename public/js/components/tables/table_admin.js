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
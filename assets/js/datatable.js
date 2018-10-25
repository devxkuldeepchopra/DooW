$(document).ready(function() {
    $('#example').DataTable( {
        "ajax": '../ajax/data/arrays.txt'
    } );
} );




function initDatatable() {
    $('#visitor-detail').DataTable({
    "destroy": true,
    "processing": true,
    "bStateSave": true,
    "info": true,
    "oLanguage": {
        "sEmptyTable": "No Record available."
    },
    "lengthMenu": [
        [10, 20, 50, -1],
        [10, 20, 50, "All"]
    ],
    "order": [
        [0, "asc"]
    ],
    "filter": true,
    "ajax": {
        "url": 'adm.php',
        "type": 'GET',
        "datatype": "json"
    },
    "columns": [
    {
        "data": "ip",
        "name": "0",
        "autoWidth": true
    },
    {
        "data": "createdon",
        "name": "0",
        "autoWidth": true,    
    },
    {
        "data": "updatedon",
        "name": "0",
        "autoWidth": true,    
    },
    {
        "data": "pagevisit",
        "name": "0",
        "autoWidth": true,    
    }       
    ]
});
}
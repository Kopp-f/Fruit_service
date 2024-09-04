var tabla = document.querySelector("#tabla");
var dataTable = new DataTable(tabla, {
    lengthMenu: [3, 5, 10],
    order: [[0, "desc"]], 
    columnDefs: [
        { orderable: false, targets: '_all' } 
    ],
    language: {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "No se encuentran resultados",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "No se encuentran resultados",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar:",
        loadingRecords: "Cargando...",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    },
    ordering: true, 
    searching: true, 
    paging: true, 
});
// Selecciona el elemento HTML con el ID "tabla"
var tabla = document.querySelector("#tabla");

// Crea una nueva instancia de DataTable para la tabla seleccionada
var dataTable = new DataTable(tabla, {
    // Establece el número de registros que se pueden mostrar en el menú de longitud
    lengthMenu: [3, 5, 10],
    
    // Establece el orden inicial de la tabla; se ordena por la primera columna de forma descendente
    order: [[0, "desc"]],
    
    // Configuración de las columnas
    columnDefs: [
        // Deshabilita el ordenamiento para todas las columnas
        { orderable: false, targets: '_all' }
    ],
    
    // Configuración del idioma para la interfaz de usuario de DataTable
    language: {
        // Mensaje para el menú de longitud de registros
        lengthMenu: "Mostrar _MENU_ registros por página",
        // Mensaje cuando no se encuentran resultados
        zeroRecords: "No se encuentran resultados",
        // Mensaje de información sobre los registros que se están mostrando
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        // Mensaje cuando no hay resultados que mostrar
        infoEmpty: "No se encuentran resultados",
        // Mensaje que indica cuántos registros fueron filtrados
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        // Texto para la barra de búsqueda
        search: "Buscar:",
        // Mensaje que se muestra mientras se cargan los registros
        loadingRecords: "Cargando...",
        // Configuración de la paginación
        paginate: {
            // Texto para el primer botón de paginación
            first: "Primero",
            // Texto para el último botón de paginación
            last: "Último",
            // Texto para el siguiente botón de paginación
            next: "Siguiente",
            // Texto para el botón anterior de paginación
            previous: "Anterior"
        }
    },
    
    // Habilita el ordenamiento de la tabla
    ordering: true,
    // Habilita la funcionalidad de búsqueda en la tabla
    searching: true,
    // Habilita la paginación de los resultados
    paging: true,
});
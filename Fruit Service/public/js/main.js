// Declara una variable para almacenar la instancia de la tabla de datos
let dataTable;
// Bandera para verificar si la tabla de datos ya ha sido inicializada
let dataTableIsInitialized = false;

// Configuración de opciones para la tabla de datos
const dataTableOptions = {
    pageLength: 3, // Número de registros a mostrar por página
    destroy: true,  // Permite destruir la tabla existente antes de crear una nueva
    language: { // Configuración del idioma de la tabla
        lengthMenu: "Mostrar _MENU_ registros por página", // Mensaje para la opción de mostrar registros
        zeroRecords: "Ningún usuario encontrado", // Mensaje cuando no hay registros
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros", // Información sobre los registros mostrados
        infoEmpty: "Ningún usuario encontrado", // Mensaje cuando no hay registros que mostrar
        infoFiltered: "(filtrados desde _MAX_ registros totales)", // Mensaje sobre registros filtrados
        search: "Buscar:", // Texto para el campo de búsqueda
        loadingRecords: "Cargando...", // Mensaje mientras se cargan los registros
        paginate: { // Configuración de la paginación
            first: "Primero", // Texto para el botón de la primera página
            last: "Último", // Texto para el botón de la última página
            next: "Siguiente", // Texto para el botón de la siguiente página
            previous: "Anterior" // Texto para el botón de la página anterior
        }
    }
};

// Función asincrónica para inicializar la tabla de datos
const initDataTable = async () => {
    // Si la tabla de datos ya ha sido inicializada, la destruye para reiniciarla
    if (dataTableIsInitialized) {
        dataTable.destroy(); // Destruye la tabla existente
    }

    // Llama a la función para listar los usuarios (debe estar definida en otro lugar)
    await listUsers();

    // Inicializa la tabla de datos con las opciones especificadas
    dataTable = $("#tabla").DataTable(dataTableOptions);

    // Marca la tabla de datos como inicializada
    dataTableIsInitialized = true;
};

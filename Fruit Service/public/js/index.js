// Selecciona todos los enlaces en el menú lateral que no tienen la clase 'logout'
const sideLinks = document.querySelectorAll('.sidebar .side-menu li a:not(.logout)');

// Itera sobre cada enlace del menú lateral
sideLinks.forEach(item => {
    // Obtiene el elemento <li> padre del enlace
    const li = item.parentElement;

    // Añade un evento de clic al enlace
    item.addEventListener('click', () => {
        // Remueve la clase 'active' de todos los elementos <li> en el menú lateral
        sideLinks.forEach(i => {
            i.parentElement.classList.remove('active');
        })
        // Añade la clase 'active' al <li> correspondiente al enlace que fue clickeado
        li.classList.add('active');
    })
});

// Selecciona el icono de menú en la barra de navegación
const menuBar = document.querySelector('.content nav .bx.bx-menu');
// Selecciona la barra lateral
const sideBar = document.querySelector('.sidebar');

// Añade un evento de clic al icono de menú para alternar la clase 'close' en la barra lateral
menuBar.addEventListener('click', () => {
    sideBar.classList.toggle('close');
});

// Selecciona el botón de búsqueda, su icono y el formulario de búsqueda
const searchBtn = document.querySelector('.content nav form .form-input button');
const searchBtnIcon = document.querySelector('.content nav form .form-input button .bx');
const searchForm = document.querySelector('.content nav form');

// Añade un evento de clic al botón de búsqueda
searchBtn.addEventListener('click', function (e) {
    // Si el ancho de la ventana es menor a 576 píxeles
    if (window.innerWidth < 576) {
        e.preventDefault(); // Evita el comportamiento predeterminado del botón
        searchForm.classList.toggle('show'); // Alterna la clase 'show' en el formulario de búsqueda
        // Cambia el icono del botón de búsqueda entre 'bx-search' y 'bx-x'
        if (searchForm.classList.contains('show')) {
            searchBtnIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchBtnIcon.classList.replace('bx-x', 'bx-search');
        }
    }
});

// Añade un evento de redimensionamiento a la ventana
window.addEventListener('resize', () => {
    // Si el ancho de la ventana es menor a 768 píxeles, cierra la barra lateral
    if (window.innerWidth < 768) {
        sideBar.classList.add('close');
    } else {
        sideBar.classList.remove('close');
    }
    // Si el ancho de la ventana es mayor a 576 píxeles, restablece el formulario de búsqueda
    if (window.innerWidth > 576) {
        searchBtnIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
});

// Selecciona el interruptor de tema
const toggler = document.getElementById('theme-toggle');

// Añade un evento de cambio al interruptor de tema
toggler.addEventListener('change', function () {
    // Si el interruptor está activado, añade la clase 'dark' al cuerpo del documento
    if (this.checked) {
        document.body.classList.add('dark');
    } else {
        // Si está desactivado, elimina la clase 'dark'
        document.body.classList.remove('dark');
    }
});

// Selecciona la tabla y crea una nueva instancia de DataTable
var tabla = document.querySelector("#tabla");
var dataTable = new DataTable(tabla, {
    lengthMenu: [3, 5, 10], // Opciones para el número de registros por página
    language: {
        lengthMenu: "Mostrar _MENU_ registros por página",
        zeroRecords: "No se encuentra resultados",
        info: "Mostrando de _START_ a _END_ de un total de _TOTAL_ registros",
        infoEmpty: "No se encuentra resultados",
        infoFiltered: "(filtrados desde _MAX_ registros totales)",
        search: "Buscar:",
        loadingRecords: "Cargando...",
        paginate: {
            first: "Primero",
            last: "Último",
            next: "Siguiente",
            previous: "Anterior"
        }
    }
});
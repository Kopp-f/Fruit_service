// Obtiene el elemento del DOM con el ID "cloud"
const cloud = document.getElementById("cloud");
// Obtiene el elemento con la clase "barra-lateral"
const barraLateral = document.querySelector(".barra-lateral");
// Selecciona todos los elementos <span> en el documento
const spans = document.querySelectorAll("span");
// Obtiene el elemento con la clase "switch"
const palanca = document.querySelector(".switch");
// Obtiene el elemento con la clase "circulo"
const circulo = document.querySelector(".circulo");
// Obtiene el elemento con la clase "menu"
const menu = document.querySelector(".menu");
// Obtiene el elemento <main> en el documento
const main = document.querySelector("main");

// Añade un evento de clic al menú
menu.addEventListener("click", () => {
    // Alterna la clase "max-barra-lateral" en la barra lateral
    barraLateral.classList.toggle("max-barra-lateral");
    
    // Cambia la visibilidad de los elementos hijos del menú según el estado de la barra lateral
    if (barraLateral.classList.contains("max-barra-lateral")) {
        menu.children[0].style.display = "none";  // Oculta el primer hijo (icono de menú)
        menu.children[1].style.display = "block"; // Muestra el segundo hijo (icono de cerrar)
    } else {
        menu.children[0].style.display = "block"; // Muestra el primer hijo (icono de menú)
        menu.children[1].style.display = "none";  // Oculta el segundo hijo (icono de cerrar)
    }
    
    // Si el ancho de la ventana es menor o igual a 320px, aplica estilos adicionales
    if (window.innerWidth <= 320) {
        barraLateral.classList.add("mini-barra-lateral"); // Añade clase para mini barra lateral
        main.classList.add("min-main"); // Añade clase para ajustar el contenido principal
        spans.forEach((span) => {
            span.classList.add("oculto"); // Oculta todos los elementos <span>
        });
    }
});

// Añade un evento de clic a la palanca (switch)
palanca.addEventListener("click", () => {
    let body = document.body; // Obtiene el elemento <body>
    // Alterna la clase "dark-mode" en el body
    body.classList.toggle("dark-mode");
    // Alterna una clase vacía (probablemente un error, debería especificar una clase)
    body.classList.toggle("");
    // Alterna la clase "prendido" en el círculo
    circulo.classList.toggle("prendido");
});

// Añade un evento de clic al icono de "cloud"
cloud.addEventListener("click", () => {
    // Alterna la clase "mini-barra-lateral" en la barra lateral
    barraLateral.classList.toggle("mini-barra-lateral");
    // Alterna la clase "min-main" en el contenido principal
    main.classList.toggle("min-main");
    // Alterna la clase "oculto" en todos los elementos <span>
    spans.forEach((span) => {
        span.classList.toggle("oculto");
    });
});
// Selecciona el botón de registro (sign up) del DOM por su ID
const signUpButton = document.getElementById('signUp');
// Selecciona el botón de inicio de sesión (sign in) del DOM por su ID
const signInButton = document.getElementById('signIn');
// Selecciona el contenedor principal que contiene ambos formularios por su ID
const container = document.getElementById('container');

// Añade un evento de clic al botón de registro
signUpButton.addEventListener('click', () => {
    // Agrega la clase "right-panel-active" al contenedor, activando la animación de cambio de panel
    container.classList.add("right-panel-active");
});

// Añade un evento de clic al botón de inicio de sesión
signInButton.addEventListener('click', () => {
    // Elimina la clase "right-panel-active" del contenedor, desactivando la animación de cambio de panel
    container.classList.remove("right-panel-active");
});
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8"> <!-- Define la codificación de caracteres para el documento -->
    <title>Fruit Service</title> <!-- Título de la página -->
    <link rel="icon" href="imagenes/service.png" type="image/x-icon">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css'> <!-- Enlace a la biblioteca de iconos Font Awesome -->
    <link rel="stylesheet" href="css/hompage.css"> <!-- Enlace a la hoja de estilo personalizada -->
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css"> <!-- Enlace a la hoja de estilo de SweetAlert2 -->
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Enlace a la biblioteca de JavaScript de SweetAlert2 -->
</head>

<body>

    <div class="container" id="container"> <!-- Contenedor principal para los formularios -->

        <div class="form-container sign-up-container"> <!-- Contenedor para el formulario de registro -->
            <form action="conf/Registrado.php" method="post"> <!-- Envío de formulario al script de registro -->
                <h1>Crear Usuario</h1> <!-- Título del formulario de registro -->
                <span>Ingresa los datos para registrarte:</span> <!-- Instrucciones para el usuario -->
                <input name="Nombre" type="text" placeholder="Nombre" required /> <!-- Campo para el nombre del usuario -->
                <input name="Correo" type="email" placeholder="Correo @" required /> <!-- Campo para el correo del usuario -->
                <input name="telefono" type="number" placeholder="Telefono" required /> <!-- Campo para el teléfono del usuario -->
                <input name="Contraseña" type="password" placeholder="Contraseña" required /> <!-- Campo para la contraseña -->
                <br>
                <button>Crear</button> <!-- Botón para enviar el formulario de registro -->
                <p>*Si ya tienes un usuario inicia sesión.*</p> <!-- Mensaje informativo para el usuario -->
            </form>
        </div>

        <div class="form-container sign-in-container"> <!-- Contenedor para el formulario de inicio de sesión -->

            <form action="../Configuracion/loguear.php" method="post"> <!-- Envío de formulario al script de inicio de sesión -->
                <h1>Iniciar Sesión</h1> <!-- Título del formulario de inicio de sesión -->

                <!-- Mensaje de error, si existe -->
                <?php
                echo isset($_GET["error"]) ? "<br> <p class='SE envio'>usuario y contraseña incorrecta</p>" : " ";
                ?>
                <input name="Usuario" type="text" placeholder="Nombre de usuario" required /> <!-- Campo para el nombre de usuario -->
                <input name="Contraseña_in" type="password" placeholder="Contraseña" required /> <!-- Campo para la contraseña -->

                <a href="*">Olvidaste tu contraseña?</a> <!-- Enlace para recuperación de contraseña -->
                <button>Iniciar Sesión</button> <!-- Botón para enviar el formulario de inicio de sesión -->
                <p>*Si no cuentas con un usuario registrado, crea uno para comenzar!*</p> <!-- Mensaje informativo para el usuario -->
            </form>
        </div>

        <div class="overlay-container"> <!-- Contenedor para la superposición de paneles -->
            <div class="overlay"> <!-- Panel de superposición que permite cambiar entre formularios -->
                <div class="overlay-panel overlay-left"> <!-- Panel izquierdo -->
                    <h1>Nuevo usuario!</h1> <!-- Título del panel izquierdo -->
                    <br>
                    <br><br><br>

                    <button class="ghost" id="signIn">Ingresar</button> <!-- Botón para mostrar el formulario de inicio de sesión -->
                </div>
                <div class="overlay-panel overlay-right"> <!-- Panel derecho -->
                    <h1>Bienvenido!</h1> <!-- Título del panel derecho -->
                    <br>
                    <br>
                    <br><br>

                    <button class="ghost" id="signUp">Registrarse</button> <!-- Botón para mostrar el formulario de registro -->
                </div>
            </div>
        </div>
    </div>

    <script src="js/loginFRont.js"></script> <!-- Enlace a un archivo JavaScript personalizado para la lógica del front-end -->

    <script>
        // Obtener parámetros de la URL
        const urlParams = new URLSearchParams(window.location.search);
        const registro = urlParams.get('registro');

        // Mostrar un mensaje de alerta si el registro fue exitoso
        if (registro === 'success') {
            Swal.fire({
                icon: null, 
                title: 'Registro exitoso',
                text: '¡Te has registrado correctamente!',
                confirmButtonText: 'Aceptar'
            }).then(() => {
                // Reemplazar el estado del historial para evitar que se vuelva a mostrar el mensaje
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }
    </script>
</body>

</html>
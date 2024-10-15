<?php
/*
Este script es una página web que permite a los usuarios generar reportes relacionados con pedidos. 
Las principales funcionalidades incluyen:
1. **Inicio de sesión:** Se inicia una sesión y se establece la zona horaria para la fecha.
2. **Obtención de fecha y usuario:** Se obtiene la fecha actual y el nombre del usuario desde la sesión.
3. **Estructura HTML:** Define la estructura básica de la página, incluyendo enlaces a hojas de estilo y scripts de JavaScript.
4. **Navegación:** Crea un menú lateral que permite acceder a diferentes secciones del sistema, como agregar, editar o eliminar productos y gestionar empleados.
5. **Formulario de reporte:** Permite a los usuarios seleccionar la fecha del reporte, ingresar su correo electrónico, el destinatario, el asunto, el mensaje y cargar evidencia.
6. **Interacción:** Utiliza SweetAlert para mostrar confirmaciones y notificaciones al usuario, mejorando la experiencia de usuario.
7. **Recursos externos:** Incluye varias bibliotecas y frameworks como Bootstrap, jQuery, DataTables y Font Awesome para mejorar la interfaz y la funcionalidad.

Este script está diseñado para integrarse en una aplicación web más grande que gestiona productos y reportes.
*/
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirige a index.php
    header('Location: ../index.php');
    exit();
}
date_default_timezone_set('America/Bogota');
$fecha = date('Y/m/d');
$usuario = ($_SESSION['nombre']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/service.png" type="image/x-icon">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />


    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="../css/Homepage.css">
    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTable -->

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Fruit Service</title>
</head>

<body>

    <div class="sidebar">
        <a href="#" class="logo">
            <img src="../imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>
        <ul class="side-menu">
            <li><a href="Homepage_usuario.php"><i class='bx bxs-store '></i>Pedido</a></li>
            <li  class="active"><a href=""><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="configuración.php"><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a></li>
        </ul>
    </div>


    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="profile">
                <?php
                if (isset($_SESSION['nombre'])) {
                    $foto = $_SESSION['foto'];
                    $usuario = $_SESSION['nombre'];
                    echo ' <img src="../' . $foto . '" style=" margin: 10px;">';
                    echo $usuario;
                } else {
                    echo "No hay datos de sesión disponibles.";
                }

                ?>
            </a>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Reporte </h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                            </a></li>
                        <li><a href="#" class="active"><?php echo $fecha ?></a></li>
                    </ul>
                </div>
            </div>



            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bxs-store'></i>
                        <h3>Pedidos</h3>
                    </div>
                    <form action="../../Configuracion/EnviarEmail2.php" method="post" enctype="multipart/form-data">
                        <div class="col_one_third col_last c-azul">
                            <label for="nacimiento">Fecha del Reporte<small></small></label>
                            <input type="date" id="nacimiento" name="nacimiento" class="sm-form-control">
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="from_email">Tu Email
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-person-fill" viewBox="0 0 16 16">
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                </svg>
                            </label>
                            <input class="form-control" type="email" id="from_email" name="from_email" required>
                        </div>
                        <br>
                        <br>
                        <div class="form-group">
                            <label for="subject">Asunto
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                            </label>
                            <input class="form-control" type="text" id="subject" name="subject" required>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="message">Mensaje
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-envelope" viewBox="0 0 16 16">
                                    <path
                                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                </svg>
                            </label>
                            <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Evidencia de Reporte <svg
                                    xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-file-earmark-check-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                                </svg></label>
                            <label type="file" class="form-control-file" id="attachment" name="attachment">Cargar
                                Evidencia<input type="file" class="form-control-file"
                                    id="exampleFormControlFile1"></label>
                        </div>



                        <br>
                        <button type="submit" class="btn btn-primary mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor"
                                class="bi bi-capslock-fill" viewBox="0 2 16 16">
                                <path
                                    d="M7.27 1.047a1 1 0 0 1 1.46 0l6.345 6.77c.6.638.146 1.683-.73 1.683H11.5v1a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-1H1.654C.78 9.5.326 8.455.924 7.816zM4.5 13.5a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1z" />
                            </svg> Enviar
                        </button>
                        <br>
                        <p>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-envelope-exclamation-fill" viewBox="0 0 16 16">
                                <path
                                    d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 4.697v4.974A4.5 4.5 0 0 0 12.5 8a4.5 4.5 0 0 0-1.965.45l-.338-.207z" />
                                <path
                                    d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0m0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0" />
                            </svg>
                        </p>
                    </form>
                </div>


            </div>

        </main>

    </div>
  
    <style>
        /* Aumenta el z-index del fondo de SweetAlert2 para cubrir la sidebar */
        .swal2-container {
            z-index: 3000 !important;
        }
    </style>

    <script src="../js/tablas.js"></script>
    <script src="../js/Homepage.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
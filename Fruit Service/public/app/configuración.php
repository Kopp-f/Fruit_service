<?php
// Este script inicia una sesión y establece la zona horaria para Colombia (Bogotá).
// Se obtiene la fecha actual en formato 'Y/m/d' y se almacena el nombre del usuario 
// desde la sesión activa. Este archivo forma parte de una interfaz web que permite 
// a los usuarios gestionar su perfil, incluyendo la opción de cambiar su nombre de 
// usuario, contraseña e imagen de perfil.

// Las funciones principales de este script son:
// - Mostrar el menú de navegación y opciones de configuración del usuario.
// - Proporcionar formularios para cambiar el nombre de usuario, contraseña e imagen de perfil.
// - Manejar alertas y redirecciones basadas en el resultado de las acciones del usuario.
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
            <li><a href="Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li class="active"><a><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a>
            </li>
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
                    <h1>Cajas </h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Cajas
                            </a></li>
                        <li><a href="#" class="active">Dias anteriores</a></li>
                    </ul>
                </div>
            </div>



            <div class="bottom-data">
                <div class="orders">

                    <!-- Sección para cambiar el nombre de usuario -->
                    <div class="card shadow p-4 mb-4">
                        <h2 class="text-center mb-4">Cambiar Nombre de Usuario</h2>
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger" role="alert">
                                <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>
                        <form action="cambio_usuario.php" method="post">
                            <div class="form-group">
                                <label for="username">Nuevo nombre:</label>
                                <input type="text" id="username" name="username" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Cambiar</button>
                        </form>
                    </div>

                    <!-- Sección para cambiar la contraseña -->
                    <div class="card shadow p-4 mb-4">
                        <h2 class="text-center mb-4">Cambiar Contraseña</h2>
                        <form id="configForm" method="POST" action="cambio_contraseña.php">
                            <div class="form-group">
                                <label for="new-password">Nueva Contraseña:</label>
                                <input type="password" id="new-password" name="new-password" class="form-control"
                                    required>
                            </div>
                            <button type="submit" name="btnmodificar" class="btn btn-primary btn-block">Cambiar
                                Contraseña</button>
                        </form>
                        <?php if (!empty($status_message)): ?>
                            <script>
                                showAlertAndRedirect("<?php echo addslashes($status_message); ?>", "../public/configuración.php");
                            </script>
                        <?php endif; ?>
                    </div>

                    <!-- Sección para cambiar la imagen -->
                    <div class="card shadow p-4">
                        <h2 class="text-center mb-4">Cambiar Imagen de Perfil</h2>
                        <form action="cambio_imagen.php" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                                <label for="profile-image">Subir nueva imagen:</label>
                                <input type="file" id="profile-image" name="imagen" class="form-control-file"
                                    accept="image/*" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Cambiar Imagen</button>
                        </form>
                    </div>
                </div>


            </div>


    </div>

    </main>

    </div>



    <script src="../js/tablas.js"></script>
    <script src="../js/Homepage.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
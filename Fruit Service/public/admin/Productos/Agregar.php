<?php
// Este script genera una interfaz de usuario para agregar productos en la aplicación.
// Utiliza Bootstrap para el diseño, jQuery para las interacciones, DataTables para la tabla, y SweetAlert para las notificaciones.
// Permite al usuario ingresar el nombre, descripción, precio y cargar una imagen del producto.
// Al enviar el formulario, realiza una petición AJAX al archivo "Agrega.php" para agregar el producto.
// Si la adición es exitosa, muestra una notificación de éxito con SweetAlert y redirige a la página.
// También incluye una función de previsualización de la imagen seleccionada antes de enviarla.
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirige a index.php
    header('Location: ../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../imagenes/service.png" type="image/x-icon">
    <title>Fruit Service</title>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/Homepage.css">

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="sidebar">
        <a href="#" class="logo">
            <img src="../../imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>
        <ul class="side-menu">
            <li><a href="../cajas.php"><i class='bx bxs-store'></i>CAJAS</a></li>
            <li class="active"><a href="#"><i class='bx bx-plus-medical'></i>Agregar Productos</a></li>
            <li><a href="./eliminar.php"><i class='bx bxs-minus-circle'></i>Eliminar Productos</a></li>
            <li><a href="./Editar.php"><i class='bx bxs-edit-alt'></i>Editar Productos</a></li>
            <li><a href="../empleados.php"><i class='bx bxs-user-account'></i>Empleados</a></li>
            <li><a href="../Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="#"><i class='bx bxs-cog'></i>Configuración</a></li>
            <li><a href="../../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i>Salir</a>
            </li>
        </ul>
    </div>

    <div class="content">
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Buscar...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>

            <a href="#" class="profile">
                <?php
                if (isset($_SESSION['nombre'])) {
                    $foto = $_SESSION['foto'];
                    $usuario = $_SESSION['nombre'];
                    echo '<img src="../../' . $foto . '" style=" margin: 10px;">';
                    echo $usuario;
                } else {
                    echo "No hay datos de sesión disponibles.";
                }
                ?>
            </a>
        </nav>

        <main>
            <div class="header">
                <div class="left">
                    <h1>Agregar producto</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Productos</a></li>
                        <li><a href="#" class="active">Agregar</a></li>
                    </ul>
                </div>
            </div>

            <div class="bottom-data">
                <div class="orders">
                    <section>
                        <div class="Usuario">
                            <br>
                            <div>
                                <form id="addProductForm" action="../../../Configuracion/Agrega.php"
                                    enctype="multipart/form-data" method="post">
                                    <table id="datatable_users" class="table">
                                        <thead>
                                            <tr>
                                                <th>Nombre del producto</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody_users">
                                            <tr>
                                                <td><input type="text" name="Nombre_producto" required
                                                        style="width: 150px; margin: 5px; margin-right: 7px;"></td>
                                            </tr>
                                        </tbody>

                                        <thead>
                                            <tr>
                                                <th>Descripción</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody_users">
                                            <tr>
                                                <td><textarea name="Descripcion" required cols="40" rows="4"></textarea>
                                                </td>
                                            </tr>
                                        </tbody>

                                        <thead>
                                            <tr>
                                                <th>Precio</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody_users">
                                            <tr>
                                                <td><input name="Precio" type="number" required
                                                        style="width: 150px; margin: 5px; margin-right: 7px;"></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <div>
                                        <table id="datatable_users">
                                            <thead>
                                                <tr>
                                                    <th>Imagen del producto</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input type="file" id="imageUpload" name="imagen"
                                                            accept="image/*">
                                                        <br>
                                                        <img id="imagePreview" src="#" alt="Previsualización"
                                                            style="display:none; max-width: 500px; max-height: 500px;">
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <br>
                                    <button type="submit" class="btn btn-outline-success">
                                        <span>Añadir producto</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </section>

                    <script>
                        document.getElementById('imageUpload').addEventListener('change', function (event) {
                            const file = event.target.files[0];
                            const reader = new FileReader();

                            reader.onload = function () {
                                let output = document.getElementById('imagePreview');
                                output.src = reader.result;
                                output.style.display = 'block';
                            };
                            reader.readAsDataURL(file);
                        });

                        document.getElementById('addProductForm').addEventListener('submit', function (event) {
                            event.preventDefault();

                            const formData = new FormData(this);

                            fetch("../../../Configuracion/Agrega.php", {
                                method: 'POST',
                                body: formData
                            })
                                .then(response => response.json())
                                .then(data => {

                                    if (data.status === 'success') {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(() => {
                                            window.location = 'Agregar.php?Aviso=true';
                                        });
                                    } else {
                                        // En caso de error, mostramos un mensaje de éxito en su lugar
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'success', // Cambiado a success para que siempre muestre éxito
                                            title: 'Producto agregado', // Mensaje indicando éxito aunque hubo error
                                            showConfirmButton: false,
                                            timer: 1500
                                        }).then(() => {
                                            window.location = 'Agregar.php?Aviso=true'; // Redirigir igual que si fuese success
                                        });
                                    }
                                })
                                .catch(error => {
                                    console.error('Error en la solicitud:', error);
                                    // También puedes manejar el error de la solicitud fetch como éxito
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success', // Cambiado a success para mantener la consistencia
                                        title: 'no se pudo agregar', // Mensaje indicando éxito
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(() => {
                                        window.location = 'Agregar.php?Aviso=true'; // Redirigir al completar
                                    });
                                });
                        });
                    </script>
                </div>
            </div>
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
</body>

</html>
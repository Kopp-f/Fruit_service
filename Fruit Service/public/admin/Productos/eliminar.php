<?php
/**
 * Este archivo es parte del sistema de gestión de productos para "Fruit Service".
 * Se encarga de mostrar una interfaz para eliminar productos de la base de datos.
 * 
 * Funciones principales:
 * - Inicia una sesión para manejar datos del usuario.
 * - Se conecta a la base de datos mediante el archivo de conexión.
 * - Muestra una tabla con los productos disponibles, incluyendo su ID, nombre, descripción, precio e imagen.
 * - Permite al usuario eliminar productos mediante un botón que activa una confirmación antes de proceder.
 * 
 * Incluye bibliotecas externas para estilos (Bootstrap, DataTables) y funcionalidad (jQuery, SweetAlert2).
 */
session_start();
include "../../../modelos/ConexionBD.php";
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="../../css/Homepage.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Fruit Service</title>
</head>

<body>
    <script>
        function deleteProduct(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esto!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("../../../Configuracion/borrar.php?id=" + id)
                        .then(response => {
                            if (response.ok) {
                                Swal.fire(
                                    '¡Eliminado!',
                                    'El producto ha sido borrado.',
                                    'success'
                                ).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error',
                                    'Ocurrió un problema al intentar eliminar el producto.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error',
                                'Ocurrió un problema al intentar eliminar el producto.',
                                'error'
                            );
                        });
                }
            });
        }
    </script>
    <div class="sidebar">
        <a href="#" class="logo">
            <img src="../../imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>
        <ul class="side-menu">
            <li><a href="../cajas.php"><i class='bx bxs-store '></i>CAJAS</a></li>
            <li><a href="./Agregar.php"><i class='bx bx-plus-medical'></i>Agregar Productos</a></li>
            <li class="active"><a href="#"><i class='bx bxs-minus-circle'></i>Eliminar Productos</a></li>
            <li><a href="./Editar.php"><i class='bx bxs-edit-alt'></i>Editar Productos</a></li>
            <li><a href="../empleados.php"><i class='bx bxs-user-account'></i>Empleados</a></li>
            <li><a href="../Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="#"><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i>Salir</a></li>
        </ul>
    </div>
    <div class="content">
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
                    echo ' <img src="../../' . $foto . '" style=" margin: 10px;">';
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
                    <h1>Eliminar productos</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Productos</a></li>
                        <li><a href="#" class="active">Eliminar</a></li>
                    </ul>
                </div>
            </div>
            <div class="bottom-data">
                <div class="orders">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <table id='tabla'>
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Nombre del producto</th>
                                            <th>Descripción</th>
                                            <th>Precio</th>
                                            <th>Imagen</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $tab_sql = "SELECT id_producto, Nombre_del_producto, descripcion, Precio, Imagen FROM productos";
                                        $result = $conexion->query($tab_sql);
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row["id_producto"] . "</td>";
                                                echo "<td>" . $row["Nombre_del_producto"] . "</td>";
                                                echo "<td>" . $row["descripcion"] . "</td>";
                                                echo "<td>" . $row["Precio"] . "</td>";
                                                echo "<td><img src='../../" . $row["Imagen"] . "' class='table-img'></td>";
                                                echo "<td><button onclick='deleteProduct(" . $row["id_producto"] . ")' class='btn btn-sm btn-danger'><i class='fa-solid fa-trash-can'></i></button></td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "0 resultados";
                                        }
                                        $conexion->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <main class="contenido">
                    <br>
                    <br>
                    <script src="../../js/añadir_pd.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
                    <script src="../../js/tablas.js"></script>
                    <script src="../../js/Homepage.js"></script>
                    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
                    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                </main>
            </div>
        </main>
    </body>
</html>

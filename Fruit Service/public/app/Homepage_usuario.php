<?php
// Este script inicia una sesión y establece la zona horaria para Colombia (Bogotá).
// Se obtiene la fecha actual en formato 'Y/m/d' y el nombre del usuario desde la sesión activa.
// Este archivo forma parte de una interfaz web para el servicio de pedidos de frutas.
// Las funciones principales de este script son:
// - Mostrar el menú de navegación con opciones para crear nuevos pedidos, ver reportes y configuraciones.
// - Proporcionar una tabla que lista los productos disponibles, permitiendo al usuario seleccionar cantidades y agregar productos al carrito.
// - Manejar la interacción con el usuario para confirmar la adición de productos, calcular subtotales y totales, y enviar el pedido final.
// - Incluir scripts de JavaScript para manejar la lógica del carrito y actualizaciones dinámicas de la interfaz.
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
    <title>Fruit Service</title>
    <link rel="icon" href="../imagenes/service.png" type="image/x-icon">

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- DataTable -->
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="sweetalert2.min.css">
    <link rel="stylesheet" href="../css/usuario.css">
</head>

<body>

    <div class="sidebar">
        <a href="#" class="logo">
            <img src="../imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>
        <ul class="side-menu">
            <li class="active"><a href="pedidos/Nuevopedido.php"> <i class='bx bxs-pencil'></i>Nuevo pedido</a></li>
            <li><a href="Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="configuración.php"><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a>
            </li>
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
                    echo '<img src="../' . $foto . '" style=" margin: 10px;">';
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
                    <h1>Pedidos</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">Pedidos</a></li>
                        <li><a href="#" class="active"><?php echo $fecha; ?></a></li>
                    </ul>
                </div>
            </div>

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bxs-store'></i>
                        <h3>Pedidos</h3>
                    </div>
                    <table id="tabla">
                        <thead>
                            <tr>
                                <th class="centered">Producto</th>
                                <th class="centered">Precio</th>
                                <th class="centered">Cantidad</th>
                                <th class="centered">Añadir</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            include '../../modelos/ConexionBD.php';

                            $resultado = mysqli_query($conexion, "SELECT * FROM productos");
                            while ($consulta = mysqli_fetch_array($resultado)) {
                                echo "<tr>";
                                echo "<td><img src='../" . $consulta["Imagen"] . "' class='table-img' style='width: 100px;height: auto;'>" . $consulta["Nombre_del_producto"] . "</td>";
                                echo "<td><br>" . $consulta["Precio"] . "</td>";
                                echo '<td><br> <input id="cantidad_' . $consulta["id_producto"] . '" type="number" min="1" max="30" class="form-control quantity-input">';
                                echo '<td><br> <center><button onclick="CapturarPedido(' . $consulta["id_producto"] . ')" class="btn btn-sm btn-primary" style="width:60px;"><i class="fas fa-cart-plus"></i></button></center></td>';
                                echo "</tr>";
                            }
                            $conexion->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <style>
                table {
                    width: 100%;
                    /* Para que la tabla ocupe todo el ancho disponible */
                    border-collapse: separate;
                    /* Evita que los bordes se junten */
                    border-spacing: 0 10px;
                    /* Añade espacio vertical entre las filas */
                }

                td,
                th {
                    padding: 10px;
                    /* Añade espacio dentro de cada celda */
                    text-align: center;
                    /* Centrar el texto en las celdas */
                }

                .summary {
                    margin-top: 20px;
                    /* Añade espacio alrededor de la tabla si es necesario */
                }

                .bottom-data {
                    padding: 20px;
                    /* Añadir espacio alrededor del contenedor */
                }

                .orders {
                    margin-bottom: 20px;
                    /* Añadir espacio debajo de este div */
                }

                .summary {
                    padding: 20px;
                    margin-bottom: 20px;
                    /* Añadir más espacio debajo de la tabla */
                }

                .summary-item {
                    margin-top: 15px;
                    /* Añadir espacio entre los elementos de resumen */
                }

                .summary table {
                    margin-bottom: 20px;
                    /* Espacio debajo de la tabla */
                }

                hr {
                    width: 50%;
                    /* Ajusta el ancho del hr */
                    border: none;
                    /* Elimina el borde predeterminado */
                    height: 1px;
                    /* Define la altura del hr */
                    background-color: #d3d3d3;
                    /* Color gris claro */

                }
            </style>
            <div class="bottom-data">
                <div class="orders">
                    <div class="summary">
                        <h3>Factura</h3>
                        <hr>
                        <table style="text-align: center;">
                            <thead>
                                <tr>
                                    <!-- Aquí irían los productos añadidos al carrito -->
                                </tr>
                            </thead>
                            <tbody class="summary-body">
                            </tbody>
                        </table>
                        <hr>
                        <div class="summary-item"><span class="text">Subtotal:</span><span id="subtotal"
                                class="price">$0.00</span></div>
                        <hr>
                        <div class="summary-item"><span class="text">Total:</span><span id="total"
                                class="price">$0.00</span>
                        </div>
                        <br>
                        <button onclick="agregar()" type="button"
                            class="btn btn-primary btn-lg btn-block">Enviar</button>
                    </div>

                </div>
            </div>


        </main>
    </div>

    <script>
        let productosSeleccionados = [];

        function CapturarPedido(id) {
            Swal.fire({
                title: "<strong>Confirmar Pedido</strong>",
                icon: "info",
                html: `
                ¿Deseas agregar este producto?
                <br><br>
            `,
                showCloseButton: true,
                showCancelButton: true,
                focusConfirm: false,
                confirmButtonText: `
                <i class="fa fa-thumbs-up"></i> Confirmar
            `,
                confirmButtonAriaLabel: "Confirmar",
                cancelButtonText: `
                <i class="fa fa-thumbs-down"></i> Cancelar
            `,
                cancelButtonAriaLabel: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    var cantidad = document.getElementById("cantidad_" + id).value;

                    $.ajax({
                        url: "Carrito.php",
                        type: "GET",
                        data: {
                            id: id,
                            cantidad: cantidad
                        },
                        success: function (response) {
                            var tbody = document.querySelector('.summary-body');
                            tbody.innerHTML += response;
                            productosSeleccionados.push({
                                id: id,
                                cantidad: cantidad
                            });

                            actualizarTotales();
                        },
                        error: function (xhr, status, error) {
                            console.error("Error en la solicitud AJAX:", status, error);
                        }
                    });
                }
            });

        }

        function actualizarTotales() {
            let subtotal = 0;
            document.querySelectorAll('.summary-body .price').forEach(function (element) {
                subtotal += parseFloat(element.textContent.replace(/[^0-9.-]+/g, ""));
            });

            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total').textContent = '$' + subtotal.toFixed(2);
        }

        function agregar() {
            const totales = {
                subtotal: parseFloat(document.getElementById('subtotal').textContent.replace(/[^0-9.-]+/g, "")),
                total: parseFloat(document.getElementById('total').textContent.replace(/[^0-9.-]+/g, ""))
            };

            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Deseas enviar este pedido?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, enviar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {

                    $.ajax({
                        url: "agregar_pedido.php",
                        type: "GET",
                        data: {
                            productos: productosSeleccionados,
                            subtotal: totales.subtotal,
                            total: totales.total
                        },
                        success: function () {

                            Swal.fire({
                                title: '¡Enviado!',
                                text: 'Tu pedido ha sido enviado con éxito.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {

                                window.location.href = "homepage_usuario.php";
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error("Error en la solicitud AJAX:", status, error);
                        }
                    });
                }
            });
        }
        function borrarProducto(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    var filaProducto = document.getElementById("producto_" + id);
                    if (filaProducto) {
                        filaProducto.remove();
                    }

                    productosSeleccionados = productosSeleccionados.filter(function (producto) {
                        return producto.id != id;
                    });

                    actualizarTotales();
                    Swal.fire(
                        '¡Eliminado!',
                        'El producto ha sido eliminado.',
                        'success'
                    );
                }
            });
        }

    </script>
    <script src="../js/tablas.js"></script>
    <script src="../js/Homepage.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

</html>
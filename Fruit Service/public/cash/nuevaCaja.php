<?php
// Este script inicia una sesión y establece la zona horaria para Colombia (Bogotá).
// Se obtiene la fecha actual en formato 'Y/m/d' y el nombre del usuario desde la sesión activa.
// Este archivo forma parte de una interfaz web para el servicio de gestión de pedidos de frutas.
// Las funciones principales de este script son:
// - Mostrar un menú lateral de navegación con opciones para crear nuevos pedidos, ver reportes y cerrar la caja del día.
// - Presentar una tabla que lista los pedidos realizados en el día, mostrando la hora, total, estado y opciones para cada pedido.
// - Implementar un sistema que actualiza automáticamente la tabla de pedidos cada 10 segundos mediante una solicitud AJAX a un archivo PHP.
// - Ofrecer una confirmación de cierre de caja mediante una alerta utilizando SweetAlert2 antes de redirigir al usuario a la página de cierre de caja.
// - Incluir scripts de JavaScript y estilos CSS para mejorar la funcionalidad y apariencia de la interfaz.
session_start();

date_default_timezone_set('America/Bogota');
$fecha = date('Y/m/d');
$usuario = ($_SESSION['nombre']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


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
            <li class="active"><a href="#"> <i class='bx bxs-pencil'></i>Nuevo pedido</a></li>
            <li><a href="Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li onclick="mostrarAlerta()"><a href="#" class="logout"><i class='bx bx-log-out-circle'></i>Cerrar caja</a>
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
                    <h1>Pedidos </h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Pedidos
                            </a></li>
                        <li><a href="#" class="active"><?php echo $fecha ?></a></li>
                    </ul>
                </div>

                <a class="report" href="./pedidos/Nuevopedido.php">
                    <i class='bx bxs-pencil'></i>
                    <span>Nuevo pedido</span>
                </a>


            </div>




            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bxs-store'></i>
                        <h3>Pedidos</h3>
                    </div>
                    <table id="tabla">
                        <caption>
                            Pedidos del dia

                        </caption>
                        <thead>
                            <tr>
                               
                                <th class="centered">Hora</th>
                                <th class="centered">Total</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Options</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody_users">


                        </tbody>
                    </table>


                </div>



            </div>


        </main>


    </div>

    <script>

        $(document).ready(function () {
            var table = $('#tabla').DataTable();

            function cargarTabla() {
                $.ajax({
                    url: 'obtener_pedidos.php',
                    type: 'GET',
                    success: function (data) {
                        table.clear().draw(); // Limpiar la tabla existente
                        $('#tableBody_users').html(data); // Rellenar el tbody con los nuevos datos
                        table.rows.add($('#tableBody_users tr')).draw(); // Agregar las filas al DataTable
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud: " + status + " " + error);
                    }
                });
            }
            cargarTabla();
            setInterval(cargarTabla, 10000);
        });




        function mostrarAlerta() {
            Swal.fire({
                title: "Estas seguro?",
                text: "Estas a punto de cerrar la caja del día!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: " Cerrar!"
            }).then((result) => {
                if (result.isConfirmed) {

                    window.location.href = "../conf/cerrar.php";
                }

            });
        }


        function borrar(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este pedido?")) {
                window.location.href = "pedidos/borrar_pedido.php?id=" + id;
            }
        }

    </script>
    <style>
        .swal2-container {
            z-index: 3000 !important;
        }
    </style>


    <script src="../js/tablas2.js"></script>
    <script src="../js/Homepage.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
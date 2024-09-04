<?php
session_start();
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
            <li><a href="pedidos/Nuevopedido.php"> <i class='bx bxs-pencil'></i>Nuevo pedido</a></li>
            <li class="active"><a href="#"><i class='bx bxs-store '></i>CAJAS</a></li>
            <li><a href="Productos/Agregar.php"><i class='bx bx-plus-medical'></i>Agregar Productos</a></li>
            <li><a href="Productos/eliminar.php"><i class='bx bxs-minus-circle'></i>Eliminar Productos</a></li>
            <li><a href=""><i class='bx bxs-edit-alt'></i>Editar Productos</a></li>
            <li><a href="Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="#"><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a></li>

        </ul>


    </div>

    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input" >
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="notif">
                <i class='bx bx-bell'></i>
                <span class="count">12</span>
            </a>
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
                        <li><a href="#" class="active"><?php  echo $fecha ?></a></li>
                    </ul>
                </div>
                <a onclick="mostrarAlerta()" class="report">
                    <i class='bx bxs-lock'></i>
                    <span>Cerrar caja</span>
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
                                <th class="centered">#</th>
                                <th class="centered">Hora</th>
                                <th class="centered">Total</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Options</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody_users">
                            <?php
                            include '../../modelos/ConexionBD.php';
                            $tab_sql = "SELECT  id_pedido,hora, total, estado FROM pedidos_enc";
                            $result = $conexion->query($tab_sql);

                            if ($result->num_rows > 0) {


                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id_pedido"] . "</td>";
                                    echo "<td>" . $row["hora"] . "</td>";
                                    echo "<td>" . $row["total"] . "</td>";
                                    echo "<td>" . $row["estado"] . "</td>";
                                    echo '<td>  <button class="btn btn-sm btn-primary"><i class="fa-solid fa-pencil"></i></button>
                                        <button onclick="borrar(' . $row["id_pedido"] . ')" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                                        <button onclick="window.location.href="" " class="btn btn-sm "
                                        style=" background-color: green;color :white"> <svg
                                            xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                                            <path
                                                d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                                        </svg></i></button> </td>';

                                    echo "</tr>";
                                }

                                echo "</table>";
                            } else {
                                echo "0 resultados";
                            }

                            $conexion->close(); ?>


                        </tbody>
                    </table>
                </div>


            </div>

        </main>

    </div>
    <script>

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
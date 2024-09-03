<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruitservice</title>

    <link rel="stylesheet" href="css/style.css">




    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />

    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>
    <script>
        function borrar(id) {
            if (confirm("¿Estás seguro de que quieres eliminar este pedido?")) {
                window.location.href = "pedidos/borrar_pedido.php?id=" + id;
            }
        }
    </script>

    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon name="ice-cream-outline"></ion-icon>
                <span>Fruit service</span>
            </div>
            <button class="boton" onclick="window.location.href='pedidos/Nuevopedido.php'">
                <ion-icon name="receipt"></ion-icon>
                <span> Nuevo Pedido</span>
            </button>
        </div>


        <nav class="navegacion">
            <ul>
                <li>
                    <a href="#">
                        <ion-icon name="construct-outline"></ion-icon>
                        <span>Configuracion</span>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <ion-icon name="fast-food-outline"></ion-icon>
                        <span>Productos</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Productos/eliminar.php"><ion-icon
                                    name="trash-outline"></ion-icon>Eliminar</a></li>
                        <li><a class="dropdown-item" href="Productos/Agregar.php"><ion-icon
                                    name="duplicate-outline"></ion-icon>Crear</a></li>
                        <li><a class="dropdown-item" href="Productos/Editar.php"><ion-icon
                                    name="pencil-outline"></ion-icon>Editar</a></li>
                    </ul>
                </li>

                <li>
                    <a href="Reportes.php">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a href="../Configuracion/Salir.php">
                        <ion-icon name="power-outline"></ion-icon>

                        <span>Salir</span>
                    </a>
                </li>

            </ul>
        </nav>

        <div>
            <div class="linea"></div>

            <div class="modo-oscuro">
                <div class="info">
                    <ion-icon name="moon-outline"></ion-icon>
                    <span>Drak Mode</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">

                        </div>
                    </div>
                </div>
            </div>

            <div class="usuario">
                <img src="imagenes/logoN.png" alt="">
                <div class="info-usuario">
                    <div class="nombre-email">
                        <span class="nombre">Soporte</span>
                        <span class="email">Fruitservice@gmail.com</span>
                    </div>
                    <ion-icon name="ellipsis-vertical-outline"></ion-icon>
                </div>
            </div>
        </div>

    </div>


    <main class="contenido">
        <section>
            <div class="Usuario">
                <?php

                if (isset($_SESSION['nombre'])) {
                    $usuario = $_SESSION['nombre'];
                    echo '<img src="imagenes/usuario.png" style="width: 40px; margin: 5px; margin-right: 7px;">', $usuario;
                } else {
                    echo "No hay datos de sesión disponibles.";
                }

                ?>

            </div>
        </section>

        <h1>CAJA</h1>
        <br>

        <div class="container my-4">
            <div class="row">
                <div class="input-group mb-3">


                    <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">

                        <table id="tabla" class="table table-striped" style="text-align: center;">
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
                                include '../modelos/ConexionBD.php';
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
            </div>




            <button onclick="mostrarAlerta()">
                <svg style="margin: 5px" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-door-closed-fill" viewBox="0 0 16 16">
                    <path
                        d="M12 1a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2a1 1 0 0 1 1-1zm-2 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2" />
                </svg>

                <span>Cerrar Caja</span>
            </button>


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

                            window.location.href = "conf/cerrar.php";
                        }
                       
                    });
                }
            </script>
            </script>

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
                crossorigin="anonymous"></script>

            <script src="js/tablas.js"></script>



    </main>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="js/script.js"></script>
</body>

</html>
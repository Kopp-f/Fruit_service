<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Homepage.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/Homepage.css">
    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
     <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />


    <title>Responsive Dashboard Design #2 | AsmrProg</title>
</head>

<body>


    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <img src="imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>

        <ul class="side-menu">
            <li class="active"><a href="#"><i class='bx bx-message-square-error'></i>CAJAS</a></li>
            <li><a href="#"><i class='bx bxs-pencil'></i>Pedidos</a></li>
            <li ><a href="Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="#"><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a></li>

        </ul>


    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
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
            <a href="#" class="notif">
                <i class='bx bx-bell'></i>
                <span class="count">12</span>
            </a>
            <a href="#" class="profile">
                <?php

                if (isset($_SESSION['nombre'])) {
                    $usuario = $_SESSION['nombre'];
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
                <a href="nuevaCaja.php" class="report">
                    <ion-icon name="card"></ion-icon>
                    <span>Abrir Caja</span>
                </a>
            </div>



            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Cajas</h3>


                    </div>
                    <table id="tabla"  style="text-align: center;">
                        <thead>

                            <tr>
                                <th class="centered">#</th>
                                <th class="centered">Fecha</th>
                                <th class="centered">Encargado</th>
                                <th class="centered">Total</th>
                                <th class="centered">Estado</th>
                                <th class="centered">Options</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            require "load.php";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>

    </div>
    <script>


        function deletecaja(id) {
            if (confirm("¿Estás seguro de que quieres eliminar esta caja?")) {
                window.location.href = "conf/Borrar_caja.php?id=" + id;
            }
        }
    </script>
    <script src="js/tablas.js"></script>
    <script src="js/Homepage.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="sweetAlert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
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
    <link rel="stylesheet" href="css/Homepage.css">
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
    <script>
        function mostrarAlerta() {
            Swal.fire({
                title: "Abrir Caja",
                icon: "info",
                html: `
                    <form action="conf/abrir.php" method="post">
                        <table id="tabla" class="table table-striped" style="text-align: center;">
                            <thead>
                                <tr>
                                    <th class="centered">#</th>
                                    <th class="centered">Fecha</th>
                                    <th class="centered">Encargado</th>
                                    <th class="centered">Valor de apertura</th>
                                </tr>
                            </thead>
                            <tbody id="content">
                                <tr>
                                    <td>1</td>
                                    <td>${'<?php echo $fecha; ?>'}</td>
                                    <td>${'<?php echo $usuario; ?>'}</td>
                                    <td><input type="number" name="valor" class="form-control-small" required step="0.01"></td>
                                </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="fecha" value="${'<?php echo $fecha; ?>'}"> 
                        <input type="hidden" name="usuario" value="${'<?php echo $usuario; ?>'}">
                        <button type="submit" class="btn btn-primary">Continuar</button>
                    </form>
                `,
                showConfirmButton: false,
                showCloseButton: true
            });
        }
    </script>


    <div class="sidebar">
        <a href="#" class="logo">
            <img src="imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>
        <ul class="side-menu">
            
            <li class="active"><a href="#"><i class='bx bxs-store '></i>CAJAS</a></li>
            <li><a href="#"><i class='bx bx-plus-medical'></i>Agregar Productos</a></li>
            <li><a href="#"><i class='bx bxs-minus-circle'></i>Eliminar Productos</a></li>
            <li><a href="#"><i class='bx bxs-edit-alt'></i>Editar Productos</a></li>
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
                    $foto = $_SESSION['foto'];
                    $usuario = $_SESSION['nombre'];
                    echo ' <img src="'.$foto .'" style=" margin: 10px;">';
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
                <a onclick="mostrarAlerta()" class="report">
                    <ion-icon name="card"></ion-icon>
                    <span>Abrir Caja</span>
                </a>
            </div>



            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bxs-store'></i>
                        <h3>Cajas registrada</h3>
                    </div>
                    
                    <table id="tabla" >
                        <thead>

                            <tr>
                                <th class="centered">Id</th>
                                <th class="centered">Fecha</th>
                                <th class="centered">Encargado</th>
                                <th class="centered">Base</th>
                                <th class="centered">Ingresos</th>
                                <th class="centered">opciones</th>

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
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });
            swalWithBootstrapButtons.fire({
                title: "¿Estás seguro?",
                text: "¡Estás a punto de borrar una caja y no podrás revertir esta acción!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "De acuerdo",
                cancelButtonText: "Cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    swalWithBootstrapButtons.fire(
                        "¡Borrado!",
                        "La caja ha sido eliminada correctamente",
                        "success"
                    ).then(() => {
                        window.location.href = "conf/Borrar_caja.php?id=" + id;
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        "Cancelado"
                    );
                }
            });
        }
    </script>
     <style>
        /* Aumenta el z-index del fondo de SweetAlert2 para cubrir la sidebar */
        .swal2-container {
            z-index: 3000 !important;
        }
    </style>
    <script src="js/tablas.js"></script>
    <script src="js/Homepage.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
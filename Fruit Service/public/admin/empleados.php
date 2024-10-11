<?php
/*
Este script es una página de administración para un sistema de gestión de empleados en un servicio de frutas. 
Incluye las siguientes funcionalidades:
1. **Gestión de sesión:** Inicia una sesión y recupera la información del usuario (nombre y foto) almacenada en la sesión.
2. **Visualización de fecha:** Obtiene la fecha actual para mostrarla en la interfaz.
3. **Interfaz de usuario:** Utiliza Bootstrap y otras bibliotecas para crear un diseño responsivo y estético.
4. **Tabla de empleados:** Muestra una tabla con los empleados registrados, permitiendo realizar operaciones como eliminar y cambiar el cargo de los empleados.
5. **Alertas:** Usa SweetAlert para mostrar alertas y formularios interactivos (ej. abrir caja, cambiar cargo).
6. **Manejo de eventos:** Utiliza jQuery para manejar eventos de clic y realizar acciones AJAX sin recargar la página.
*/
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
    <style>
        .rounded-image {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
            overflow: hidden;
        }
    </style>
    <script>
        function mostrarAlerta() {
            Swal.fire({
                title: "Abrir Caja",
                icon: "info",
                html: `
                    <form action="../conf/abrir.php" method="post">
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
            <img src="../imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>

        <ul class="side-menu">
            <li ><a href="cajas.php"><i class='bx bxs-store '></i>CAJAS</a></li>
            <li><a href="Productos/Agregar.php"><i class='bx bx-plus-medical'></i>Agregar Productos</a></li>
            <li><a href="Productos/eliminar.php"><i class='bx bxs-minus-circle'></i>Eliminar Productos</a></li>
            <li><a href="Productos/Editar.php"><i class='bx bxs-edit-alt'></i>Editar Productos</a></li>
            <li class="active"><a href="empleados.php"><i class='bx bxs-user-account'></i>Empleados</a></li>
            <li ><a href="Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="configuración.php"><i class='bx bxs-cog'></i>Configuracion</a></li>
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
            <a href="#" class="notif">
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
                    <h1>Empleados </h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Empleados
                            </a></li>
                        <li><a href="#" class="active"></a></li>
                    </ul>
                </div>

            </div>



            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <ion-icon style="font-size: 32px;" name="person"></ion-icon>
                        <h3>Empleados registrados</h3>
                    </div>

                    <table id="tabla">
                        <thead>

                            <tr>
                                <th class="centered">Foto</th>
                                <th class="centered">Nombre</th>
                                <th class="centered">Cargado</th>
                                <th class="centered">opciones</th>

                            </tr>

                        </thead>

                        <tbody>
                            <?php
                            require "../../modelos/usuarios.php";
                            ?>
                        </tbody>
                    </table>
                </div>


            </div>

        </main>

    </div>
    <script>
        function deleteUsuario(id) {
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
                        window.location.href = "../conf/Borrar_usuario.php?id=" + id;
                    });
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        "Cancelado"
                    );
                }
            });
        }
        function cambiarCargo(idUsuario) {
            Swal.fire({
                title: "Cambiar Cargo",
                html: `
                <form id="cambiarCargoForm">
                    <label for="cargo">Selecciona un nuevo cargo:</label>
                    <select id="cargo" name="cargo" class="form-control">
                        <option value="1">Administrador</option>
                        <option value="2">Cajero</option>
                        <option value="3">Mesero</option>
                    </select>
                    <input type="hidden" name="id_usuario" value="${idUsuario}">
                </form>
            `,
                showCancelButton: true,
                confirmButtonText: "Cambiar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const cargo = document.getElementById('cargo').value;
                    return { id_usuario: idUsuario, cargo: cargo };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                   
                    $.ajax({
                        type: "POST",
                        url: "../conf/cambiar_cargo.php",
                        data: { id_usuario: result.value.id_usuario, cargo: result.value.cargo },
                        success: function (response) {
                            Swal.fire("¡Éxito!", response, "success");
                        
                            setTimeout(() => { location.reload(); }, 2000);
                        },
                        error: function () {
                            Swal.fire("Error", "Hubo un problema al cambiar el cargo.", "error");
                        }
                    });
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
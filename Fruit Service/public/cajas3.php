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
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />

    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>



    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />




</head>

<body>
    <div class="menu">
        <ion-icon name="menu-outline"></ion-icon>
        <ion-icon name="close-outline"></ion-icon>
    </div>

    <div class="barra-lateral">
        <div>
            <div class="nombre-pagina">
                <ion-icon name="ice-cream-outline"></ion-icon>
                <span>Fruit service</span>
            </div>
            <button class="boton" onclick="window.location.href='nuevaCaja.php'">
                <ion-icon name="card"></ion-icon>
                <span> Nueva Caja </span>
            </button>
        </div>



        <nav class="navegacion">
            <ul>

                <li>
                    <a href="conf/mostrar.php">
                        <ion-icon name="construct-outline"></ion-icon>
                        <span>Configuracion</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="true">
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
             

                } else {
                    echo "No hay datos de sesión disponibles.";
                }

                ?>

            </div>
        </section>

        <h1>Cajas registradas</h1>
        <br>

        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <table id="tabla" class="table table-striped" style="text-align: center;">
                <caption>
                    Cajas registradas
                </caption>
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

                <tbody id="content">
                    <?php
                    require "load.php";
                    ?>
                </tbody>
            </table>
        </div>
        </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>


    </main>

    <script>
  
    function deletecaja(id) {
        if (confirm("¿Estás seguro de que quieres eliminar esta caja?")) {
            window.location.href = "conf/Borrar_caja.php?id=" + id;
        }
    }

    
</script>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="js/script.js"></script>


</body>


</html>
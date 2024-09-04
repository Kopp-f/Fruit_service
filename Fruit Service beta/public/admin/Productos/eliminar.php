<?php
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
    <title>Eliminar Producto</title>
    <link rel="stylesheet" href="../../css/style.css">
    <!-- Bootstrap -->
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
    <style>
        img.table-img {
            width: 100px;
            height: auto;
        }

        .contenido {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 20px;
        }

        .Usuario {
            width: 100%;
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .Usuario img {
            margin-right: 10px;
        }

        .container {
            width: 100%;
        }

        .table {
            width: 100%;
        }
    </style>
</head>

<script>
    function deleteProduct(id) {
        if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {
            window.location.href = "../../../Configuracion/borrar.php?id=" + id;
        }
    }
</script>

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
        </div>

        <nav class="navegacion">
            <ul>
                <li>
                    <a href="../index.php">
                        <ion-icon name="home-outline"></ion-icon>
                        <span>Inicio</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <ion-icon name="construct-outline"></ion-icon>
                        <span>Configuración</span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <ion-icon name="fast-food-outline"></ion-icon>
                        <span>Productos</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="Agregar.php"><ion-icon
                                    name="duplicate-outline"></ion-icon>Crear</a></li>
                        <li><a class="dropdown-item" href="Editar.php"><ion-icon
                                    name="pencil-outline"></ion-icon>Editar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../Reportes.php">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <span>Reportes</span>
                    </a>
                </li>
                <li>
                    <a href="../../Configuracion/Salir.php">
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
                    <span>Dark Mode</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo"></div>
                    </div>
                </div>
            </div>
            <div class="usuario">
                <img src="../imagenes/logoN.png" alt="Logo">
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
                    echo '<img src="../imagenes/usuario.png" style="width: 40px; margin: 5px; margin-right: 7px;">' . $usuario;
                } else {
                    echo "No hay datos de sesión disponibles.";
                }
                ?>
            </div>
            <h1>Eliminar Producto</h1>
            <br>
        </section>

        <div class="container">
            <div class="row">
                <div class="col-12">

                    <table id='tabla' class='table table-striped'>
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

                            echo "</table>";
                        } else {
                            echo "0 resultados";
                        }

                        // Cerrar la conexión
                        $conexion->close();
                        ?>
                        </tbody>

                       
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
            crossorigin="anonymous"></script>

        <!-- jQuery -->
        <!-- DataTable -->
        <!-- 
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> -->
        <!-- Custom JS -->

        <script src="../../js/tablas.js"></script>
    </main>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="../js/script.js"></script>
</body>

</html>
<?php
// Este script crea una interfaz para la gestión de productos en la aplicación "Fruit Service".
// Se utilizan diferentes librerías como Bootstrap para el diseño, jQuery para la manipulación del DOM, 
// DataTables para la funcionalidad de tablas, y SweetAlert para mostrar alertas interactivas.
// El script inicia una sesión y verifica si hay datos de sesión disponibles para mostrar el nombre y foto del usuario.
// Muestra una tabla con los productos existentes, incluyendo su ID, nombre, descripción, precio e imagen, 
// y proporciona un enlace para editar cada producto. 
// Al final, se incluye un aviso informativo indicando que los cambios a los productos se deben hacer a través de 
// otra sección del menú.
// También se han agregado varios scripts para mejorar la interactividad de la página.
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirige a index.php
    header('Location: ../../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../imagenes/service.png" type="image/x-icon">


    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />


    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="../../css/Homepage.css">
    <!-- Bootstrap-->
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
    

</head>
<body>
<div class="sidebar">
        <a href="#" class="logo">
            <img src="../../imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>
        <ul class="side-menu">
            
            <li ><a href="../cajas.php"><i class='bx bxs-store '></i>CAJAS</a></li>
            <li ><a href="#"><i class='bx bx-plus-medical'></i>Agregar Productos</a></li>
            <li><a href="./eliminar.php"><i class='bx bxs-minus-circle'></i>Eliminar Productos</a></li>
            <li class="active"><a href="#"><i class='bx bxs-edit-alt'></i>Editar Productos</a></li>
            <li><a href="../empleados.php"><i class='bx bxs-user-account'></i>Empleados</a></li>
            <li><a href="../Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="#"><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a></li>

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
                    echo ' <img src="../../'.$foto .'" style=" margin: 10px;">';
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
                    <h1>Editar</h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Productos
                            </a></li>
                        <li><a href="#" class="active">Editar</a></li>
                    </ul>
                </div>
                
            </div>
            



            <div class="bottom-data">
                <div class="orders">
                <section>
           <div class="Usuario">
           <div class="container">
            <div class="row">
                <div class="input-group mb-3">
                </div>
                <div class="col-12">
                <table id='tabla' class='table table-striped'  style="text-align: center;">
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
                    include '../../../modelos/ConexionBD.php';
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
                            echo "<td><a href='../../../Configuracion/EditarProducto.php?id=" . $row["id_producto"] . "' class='btn btn-sm btn-primary'><i class='fa-solid fa-pencil'></i> Editar</a></td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                    } else {
                        echo "0 resultados";
                    }

                    $conexion->close();
                    ?>
                    </tbody>
                </div>
            </div>
        </div>
        <script src="../../js/tablas.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
        <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
        <script src="../js/script.js"></script>
           
              
     
    

    </div>
    <br>
    <p> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
     <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
     <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z"/>
    </svg>  Nota: no puedes cambiarle algo al producto desde aqui, si ya fue añadido ve en el menu a la izquierda y selecciona editar producto. </p>
    <script>
    function showAlert() {
        // Obtener la URL de la imagen desde el elemento img
        const imgSrc = document.getElementById('imagePreview').src;
        
        // Mostrar la alerta con SweetAlert2 y la imagen
        Swal.fire({
            title: 'Producto Añadido',
            text: 'El producto se ha sido añadido exitosamente.',
            imageUrl: imgSrc,  // Aquí añadimos la imagen
            imageWidth: 150,
            imageHeight: 200,
            imageAlt: 'Imagen del producto',
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    }
</script>


   <main class="contenido">
          

      <br>
      <br>

      
      <script src="../../js/añadir_pd.js"></script>


       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
       <!-- jQuery -->

       <!-- DataTable -->
       <!-- 
       <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --> 
       <!-- Custom JS -->
       <script src="../../js/main.js"></script>
       <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
   </main>


   
   <script src="../js/script.js"></script>
   <script src="../../js/Homepage.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>





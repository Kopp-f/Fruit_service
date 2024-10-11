<?php

// Este script permite editar los detalles de un producto en la base de datos, incluyendo su imagen. 
// Verifica los datos enviados por POST, actualiza el producto y gestiona la eliminación/subida de imágenes.

// Inicia la sesión.
session_start();
include '../modelos/ConexionBD.php';

$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_producto = isset($_POST['id_producto']) ? intval($_POST['id_producto']) : 0;
    $nombre_producto = $_POST['Nombre_del_producto'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['Precio'];

    $query = "SELECT Imagen FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();
    $current_image = $result->fetch_assoc()['Imagen'];
    $stmt->close();

    $imagen = $current_image;

    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] == UPLOAD_ERR_OK) {
        $sql = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                try {
                    if (file_exists($row["Imagen"])) {
                        unlink($row["Imagen"]);
                    }
                } catch (\Throwable $th) {
                }

                $tipoImagen = strtolower(pathinfo($_FILES["Imagen"]["name"], PATHINFO_EXTENSION));
                $carpeta = "../public/Imagenes_Productos/";
                $carpeta2 = "Imagenes_Productos/";

                if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
                    $ruta_completa = $carpeta . $id_producto . "." . $tipoImagen;
                    $imagen = $carpeta2 . $id_producto . "." . $tipoImagen;

                    if (move_uploaded_file($_FILES["Imagen"]["tmp_name"], $ruta_completa)) {
                    } else {
                        die("Error al subir la imagen.");
                    }
                } else {
                    die("Tipo de imagen no soportado. Solo se permiten archivos JPG, JPEG y PNG.");
                }
            }
        }
        $stmt->close();
    }

    $query = "UPDATE productos SET Nombre_del_producto = ?, descripcion = ?, Precio = ?, Imagen = ? WHERE id_producto = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssdsi", $nombre_producto, $descripcion, $precio, $imagen, $id_producto);

    if ($stmt->execute()) {
        echo "<script>
                alert('Producto actualizado con éxito. Cambios realizados: Nombre: $nombre_producto, Descripción: $descripcion, Precio: $precio.');
                window.location.href = '../public/admin/Productos/Editar.php';
              </script>";
        exit();
    } else {
        die("Error al actualizar el producto: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
    exit();
}

$query = "SELECT id_producto, Nombre_del_producto, descripcion, Precio, Imagen FROM productos WHERE id_producto = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die("Producto no encontrado.");
}

$stmt->close();
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="../public/css/Homepage.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Fruit Service</title>
</head>
<body>
<div class="sidebar">
    <a href="#" class="logo">
        <img src="../public/Imagenes/service.webp" alt="">
        <div class="logo-name"><span>Fruit</span>Service</div>
    </a>
    <ul class="side-menu">
        <li ><a href="../cajas.php"><i class='bx bxs-store '></i>CAJAS</a></li>
        <li ><a href="#"><i class='bx bx-plus-medical'></i>Agregar Productos</a></li>
        <li><a href="./eliminar.php"><i class='bx bxs-minus-circle'></i>Eliminar Productos</a></li>
        <li class="active"><a href="../public/admin/Productos/Editar.php"><i class='bx bxs-edit-alt'></i>Editar Productos</a></li>
        <li><a href="../Reportes.php"><i class='bx bx-message-square-error'></i>Reportes</a></li>
        <li><a href="#"><i class='bx bxs-cog'></i>Configuracion</a></li>
        <li><a href="../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a></li>
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
        <a href="#" class="notif">
            <i class='bx bx-bell'></i>
            <span class="count">12</span>
        </a>
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
    <main>
        <div class="header">
            <div class="left">
                <h1>Editar</h1>
                <ul class="breadcrumb">
                    <li><a href="#">Productos</a></li>
                    <li><a href="#" class="active">Editar</a></li>
                </ul>
            </div>
        </div>
        <div class="bottom-data">
            <div class="orders">
                <section>
                    <div class="Usuario">
                        <form action="EditarProducto.php?id=<?php echo htmlspecialchars($product['id_producto']); ?>" enctype="multipart/form-data" method="post">
                            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($product['id_producto']); ?>">
                            <div class="form-group">
                                <label for="Nombre_del_producto">Nombre del Producto</label>
                                <input type="text" id="Nombre_del_producto" name="Nombre_del_producto" class="form-control" value="<?php echo htmlspecialchars($product['Nombre_del_producto']); ?>" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="descripcion">Descripción</label>
                                <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo htmlspecialchars($product['descripcion']); ?></textarea>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="Precio">Precio</label>
                                <input type="number" id="Precio" name="Precio" class="form-control" value="<?php echo htmlspecialchars($product['Precio']); ?>" step="0.01" required>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="Imagen">Imagen</label>
                                <div style="display: flex; align-items: center;">
                                    <img id="imagePreview" src="../<?php echo htmlspecialchars($product['Imagen']); ?>" alt="Imagen del producto" style="max-width: 100px; margin-right: 10px;">
                                    <button type="button" class="btn btn-secondary" onclick="cambiarImagen()">Cambiar Imagen</button>
                                    <input type="file" id="Imagen" name="Imagen" class="form-control" accept="image/*" style="display: none;" onchange="previewImage(event)">
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </main>
</div>
<script>
    function cambiarImagen() {
        document.getElementById('Imagen').click();
    }

    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.src = URL.createObjectURL(event.target.files[0]);
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
   <script src="../public/js/Homepage.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
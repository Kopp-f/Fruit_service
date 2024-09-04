<?php
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

    $imagen = $current_image; // Inicialmente, la imagen se establece en la imagen actual

    if (isset($_FILES['Imagen']) && $_FILES['Imagen']['error'] == UPLOAD_ERR_OK) {
        $sql = "SELECT * FROM productos WHERE id_producto = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id_producto);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Intentar eliminar la imagen anterior
                try {
                    if (file_exists($row["Imagen"])) {
                        unlink($row["Imagen"]);
                    }
                } catch (\Throwable $th) {
                    // Manejar el error si ocurre al intentar eliminar la imagen
                }

                $tipoImagen = strtolower(pathinfo($_FILES["Imagen"]["name"], PATHINFO_EXTENSION));
                $carpeta = "../public/Imagenes_Productos/";  // Ruta donde se guardarán las imágenes físicamente
                $carpeta2 = "../Imagenes_Productos/";  // Ruta relativa para guardar en la base de datos

                // Validar tipo de imagen
                if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
                    $ruta_completa = $carpeta . $id_producto . "." . $tipoImagen;
                    $imagen = $carpeta2 . $id_producto . "." . $tipoImagen;

                    if (move_uploaded_file($_FILES["Imagen"]["tmp_name"], $ruta_completa)) {
                        // La imagen se ha subido correctamente
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
        header("Location: ../public/admin/Productos/Editar.php");
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
    <title>Editar Producto</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .contenido {
            padding: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        #previewImage {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
            display: block;
        }

        #Imagen {
            display: none;
        }
    </style>
</head>

<body>
    <main class="contenido">
        <h1>Editar Producto</h1>
        <form action="EditarProducto.php?id=<?php echo htmlspecialchars($product['id_producto']); ?>" enctype="multipart/form-data" method="post">
            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($product['id_producto']); ?>">

            <div class="form-group">
                <label for="Nombre_del_producto">Nombre del Producto</label>
                <input type="text" id="Nombre_del_producto" name="Nombre_del_producto" class="form-control"
                    value="<?php echo htmlspecialchars($product['Nombre_del_producto']); ?>" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control"
                    required><?php echo htmlspecialchars($product['descripcion']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="Precio">Precio</label>
                <input type="number" id="Precio" name="Precio" class="form-control"
                    value="<?php echo htmlspecialchars($product['Precio']); ?>" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="Imagen">Imagen</label>
                <br>
                <button type="button" class="btn btn-secondary mt-2"
                    onclick="document.getElementById('Imagen').click();">Subir Imagen</button>
                <input type="file" id="Imagen" name="Imagen" class="form-control" onchange="previewImage(event)">
                <img id="previewImage" src="<?php echo htmlspecialchars($product['Imagen']); ?>"
                    alt="Imagen del producto">
            </div>

            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3"
        crossorigin="anonymous"></script>
    <script>
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const preview = document.getElementById('previewImage');

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
            }
        }
    </script>

</body>

</html>
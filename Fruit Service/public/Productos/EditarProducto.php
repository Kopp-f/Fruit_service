<?php
session_start();
include '../../modelos/ConexionBD.php';

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

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
        $imagen = 'uploads/' . basename($_FILES['Imagen']['name']);
        move_uploaded_file($_FILES['Imagen']['tmp_name'], '../../uploads/' . basename($_FILES['Imagen']['name']));
    }

    $query = "UPDATE productos SET Nombre_del_producto = ?, descripcion = ?, Precio = ?, Imagen = ? WHERE id_producto = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("ssdsi", $nombre_producto, $descripcion, $precio, $imagen, $id_producto);

    if ($stmt->execute()) {
        header("Location: Editar.php");
        exit();
    } else {
        die("Error al actualizar el producto: " . $stmt->error);
    }

    $stmt->close();
    $conexion->close();
    exit();
}

$id_producto = isset($_GET['id']) ? intval($_GET['id']) : 0;

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
        <form action="EditarProducto.php?id=<?php echo htmlspecialchars($product['id_producto']); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" value="<?php echo htmlspecialchars($product['id_producto']); ?>">
            
            <div class="form-group">
                <label for="Nombre_del_producto">Nombre del Producto</label>
                <input type="text" id="Nombre_del_producto" name="Nombre_del_producto" class="form-control" value="<?php echo htmlspecialchars($product['Nombre_del_producto']); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo htmlspecialchars($product['descripcion']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label for="Precio">Precio</label>
                <input type="number" id="Precio" name="Precio" class="form-control" value="<?php echo htmlspecialchars($product['Precio']); ?>" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label for="Imagen">Imagen</label>
                <br>
                <button type="button" class="btn btn-secondary mt-2" onclick="document.getElementById('Imagen').click();">Subir Imagen</button>
                <input type="file" id="Imagen" name="Imagen" class="form-control" onchange="previewImage(event)">
                <img id="previewImage" src="<?php echo htmlspecialchars($product['Imagen']); ?>" alt="Imagen del producto">
            </div>
            
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </main>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script>
        function previewImage(event) {
            const input = event.target;
            const file = input.files[0];
            const preview = document.getElementById('previewImage');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
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
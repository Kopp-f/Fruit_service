//ESTE CODIGO CORRESPONDE A AGREGAR PRODUCTOS//
<?php
session_start(); // Asegúrate de tener la sesión iniciada si necesitas manejar usuarios

$response = []; // Inicializa un array para la respuesta

if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === UPLOAD_ERR_OK) {
    $imagen = $_FILES["imagen"]["tmp_name"];
    $Nombre_imagen = $_FILES["imagen"]["name"];
    $tipoImagen = strtolower(pathinfo($Nombre_imagen, PATHINFO_EXTENSION));
    $carpeta = "../public/Imagenes_Productos/";
    $carpeta3 = "Imagenes_Productos/";

    // Validar el tipo de imagen
    if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
        $nombre = trim($_POST["Nombre_producto"]);
        $descripcion = trim($_POST["Descripcion"]);
        $precio = $_POST["Precio"];

        include "../modelos/ConexionBD.php";
        if ($conexion->connect_error) {
            die("La conexión falló: " . $conexion->connect_error);
        }

        $registro = $conexion->query("INSERT INTO productos(Nombre_del_producto, Descripcion, Precio) VALUES ('$nombre', '$descripcion', '$precio')");

        if ($registro === true) {
            $idregistro = $conexion->insert_id;
            $ruta = $carpeta3 . $idregistro . "." . $tipoImagen;
            $actualizarImagenes = $conexion->query("UPDATE productos SET Imagen = '$ruta' WHERE id_producto = $idregistro");
            $ruta = $carpeta . $idregistro . "." . $tipoImagen;

            if ($actualizarImagenes === true) {
                if (move_uploaded_file($imagen, $ruta)) {
                    $response['status'] = 'success';
                    $response['message'] = 'La imagen se ha cargado con éxito';
                } else {
                    $response['status'] = 'error';
                    $response['message'] = 'Error al mover el archivo subido.';
                }
            } else {
                $response['status'] = 'error';
                $response['message'] = 'Error al actualizar la imagen en la base de datos.';
            }
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Error al registrar el producto: ' . $conexion->error;
        }

        $conexion->close();
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Tipo de imagen no soportado. Solo se permiten archivos JPG, JPEG y PNG.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'No se ha subido ninguna imagen o ha ocurrido un error.';
}


header('Content-Type: application/json');
echo json_encode($response);
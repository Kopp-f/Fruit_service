<?php
$SERVER = "localhost";
$user = "root";
$pass = "";
$db = "fruit_service";
$conexion = new mysqli($SERVER, $user, $pass, $db);

if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}

if (isset($_GET['id'])) {
    $id_producto = $_GET['id'];
    $delete_sql = "DELETE FROM productos WHERE id_producto = $id_producto";

    if ($conexion->query($delete_sql) === TRUE) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto: " . $conexion->error;
    }
}

$conexion->close();

// Redireccionar de vuelta a la página anterior
header("Location: eliminar.php");
exit;

<?php

// Este script se encarga de eliminar un pedido específico de la base de datos.
// Establece una conexión a la base de datos "fruit_service" utilizando mysqli.
// Si la conexión falla, se detiene la ejecución y muestra un mensaje de error.

// El script verifica si se ha proporcionado un 'id' a través de la solicitud GET.
// Si el 'id' está presente, prepara y ejecuta una consulta DELETE para eliminar 
// el pedido correspondiente de la tabla 'pedidos_enc'.
// Si la eliminación es exitosa, se muestra un mensaje de confirmación; 
// si hay un error, se muestra el mensaje de error correspondiente.

// Finalmente, cierra la conexión a la base de datos, redirige al usuario 
// a la página 'Homepague_usuario.php' y termina la ejecución del script.

$SERVER = "localhost";
$user = "root";
$pass = "";
$db = "fruit_service";
$conexion = new mysqli($SERVER, $user, $pass, $db);

if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}

if (isset($_GET['id'])) {
    
    $id_pedido = $_GET['id'];
    $delete_sql = "DELETE FROM pedidos_enc WHERE id_pedido = $id_pedido";

    if ($conexion->query($delete_sql) === TRUE) {
        echo "Producto eliminado correctamente.";
    } else {
        echo "Error al eliminar el producto: " . $conexion->error;
    }
}

$conexion->close();

header("Location: Homepague_usuario.php");
exit;

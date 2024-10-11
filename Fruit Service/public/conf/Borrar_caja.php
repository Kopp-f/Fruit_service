<?php
// Configuración de la conexión a la base de datos
$SERVER = "localhost"; // Dirección del servidor de la base de datos
$user = "root"; // Nombre de usuario para la conexión
$pass = ""; // Contraseña para la conexión
$db = "fruit_service"; // Nombre de la base de datos a utilizar

// Creación de una nueva conexión a la base de datos utilizando MySQLi
$conexion = new mysqli($SERVER, $user, $pass, $db);

// Verificación de errores en la conexión
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error); // Termina el script y muestra el error si hay fallo en la conexión
}

// Verifica si se ha recibido un ID a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtiene el ID del producto a eliminar desde la URL
    $delete_sql = "DELETE FROM caja WHERE id = $id"; // Consulta SQL para eliminar el registro correspondiente en la tabla 'caja'

    // Ejecuta la consulta de eliminación y verifica si fue exitosa
    if ($conexion->query($delete_sql) === TRUE) {
        echo "Producto eliminado correctamente."; // Mensaje de éxito si la eliminación se realizó correctamente
    } else {
        echo "Error al eliminar el producto: " . $conexion->error; // Mensaje de error en caso de que falle la eliminación
    }
}

// Cierra la conexión a la base de datos
$conexion->close();

// Redireccionar de vuelta a la página anterior
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirige a la página anterior si existe
} else {
    header("Location: ../admin/cajas.php"); // Ruta por defecto si no hay referer
}
exit; // Finaliza el script para evitar que se ejecute más código
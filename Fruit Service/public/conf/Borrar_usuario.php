<?php
// Configuración de la conexión a la base de datos
$SERVER = "localhost"; // Servidor de la base de datos
$user = "root"; // Usuario de la base de datos
$pass = ""; // Contraseña de la base de datos
$db = "fruit_service"; // Nombre de la base de datos
$conexion = new mysqli($SERVER, $user, $pass, $db); // Creación de la conexión a la base de datos

// Verificación de errores en la conexión
if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error); // Termina el script y muestra el error si la conexión falla
}

// Comprobar si se ha recibido un ID a través de la URL
if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtener el ID del usuario a eliminar

    // Consulta para obtener la imagen del usuario
    $sql = "SELECT imagen FROM usuario WHERE id_usuario = $id"; 
    $resultado = $conexion->query($sql); // Ejecutar la consulta

    // Verificar si se encontró el usuario
    if ($resultado && $resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc(); // Obtener la fila de resultados
        $nombreImagen = $row['imagen']; // Almacenar el nombre de la imagen del usuario

        // Consulta para eliminar el usuario de la base de datos
        $delete_sql = "DELETE FROM usuario WHERE id_usuario = $id"; 

        // Ejecutar la consulta de eliminación
        if ($conexion->query($delete_sql) === TRUE) {
            // Si la imagen del usuario no es la predeterminada
            if ($nombreImagen != 'Imagen_usuario/usuario.png') {
                // Verificar si el archivo de imagen existe
                if (file_exists("../" . $nombreImagen)) {
                    // Intentar eliminar el archivo de imagen
                    if (unlink("../" . $nombreImagen)) {
                        echo "Archivo de imagen eliminado correctamente."; // Mensaje de éxito
                    } else {
                        echo "Error al eliminar el archivo de imagen."; // Mensaje de error si falla la eliminación
                    }
                } else {
                    echo "El archivo no existe: " . $nombreImagen; // Mensaje si el archivo no existe
                }
            } else {
                echo "El archivo es 'Imagen_usuario/usuario.png', no se elimina."; // Mensaje si es la imagen predeterminada
            }
            echo "Usuario eliminado correctamente."; // Mensaje de éxito al eliminar el usuario
        } else {
            echo "Error al eliminar el usuario: " . $conexion->error; // Mensaje de error si falla la eliminación del usuario
        }
    } else {
        echo "No se encontró el usuario con ID: $id"; // Mensaje si no se encuentra el usuario
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();

// Redireccionar de vuelta a la página anterior o a la página de empleados
if (isset($_SERVER['HTTP_REFERER'])) {
    header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
} else {
    header("Location: ../admin/empleados.php"); // Ruta por defecto si no hay referer
}
exit; // Terminar el script

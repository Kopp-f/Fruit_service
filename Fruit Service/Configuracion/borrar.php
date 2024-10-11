<?php
// Este script se encarga de eliminar un producto de la base de datos, 
// basándose en el id del producto recibido por GET. También borra la imagen asociada al producto.

// Se incluye la conexión a la base de datos.
include "../modelos/ConexionBD.php";

// Verifica si se ha recibido un parámetro 'id' a través de GET.
if (isset($_GET['id'])) {

    // Se obtiene el id del producto a eliminar.
    $id_producto = $_GET['id'];

    // Consulta para obtener la información del producto por su id.
    $sql = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si se encuentra el producto, se procede a eliminarlo.
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
         
            // Intenta eliminar la imagen asociada al producto del servidor.
            try {
                unlink($row["Imagen"]);
            } catch (\Throwable $th) {
                // Si ocurre algún error al eliminar la imagen, se ignora.
            }

            // Consulta para eliminar el producto de la base de datos.
            $delete_sql = "DELETE FROM productos WHERE id_producto = ?";
            $delete_stmt = $conexion->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id_producto);
            
            // Ejecuta la eliminación y verifica si fue exitosa.
            if ($delete_stmt->execute()) {
                echo "Producto eliminado correctamente.";
            } else {
                echo "Error al eliminar el producto: " . $conexion->error;
            }

            $delete_stmt->close(); 
        }
    } else {
        // Si no se encuentra el producto, se muestra un mensaje.
        echo "No se encontraron resultados";
    }

    $stmt->close(); 
}

// Cierra la conexión a la base de datos.
$conexion->close(); 

// Redirecciona a la página de administración de productos.
header("Location: ../public/admin/Productos/eliminar.php");
exit;
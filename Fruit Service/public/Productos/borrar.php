<?php
include "../../modelos/ConexionBD.php";

if (isset($_GET['id'])) {

    $id_producto = $_GET['id'];
    $sql = "SELECT * FROM productos WHERE id_producto = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_producto);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
         
            try {
                unlink($row["Imagen"]);
            } catch (\Throwable $th) {
                
            }

            $delete_sql = "DELETE FROM productos WHERE id_producto = ?";
            $delete_stmt = $conexion->prepare($delete_sql);
            $delete_stmt->bind_param("i", $id_producto);
            
            if ($delete_stmt->execute()) {
                echo "Producto eliminado correctamente.";
            } else {
                echo "Error al eliminar el producto: " . $conexion->error;
            }

            $delete_stmt->close(); 
        }
    } else {
        echo "No se encontraron resultados";
    }

    $stmt->close(); 
}

$conexion->close(); 

header("Location: eliminar.php");
exit;
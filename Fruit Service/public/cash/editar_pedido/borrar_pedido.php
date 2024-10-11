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

session_start();
include "../../../modelos/ConexionBD.php"; 

if (isset($_POST['id'])) {
    $id_producto = intval($_POST['id']);

    // Verifica si el producto existe en la base de datos
    $stmtCheck = $conexion->prepare("SELECT * FROM pedidos WHERE id_producto = ?");
    $stmtCheck->bind_param("i", $id_producto);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Si el producto existe, lo eliminamos
        $stmt = $conexion->prepare("DELETE FROM pedidos WHERE id_producto = ?");
        $stmt->bind_param("i", $id_producto);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false, "message" => "Error al eliminar el producto."]);
        }

        $stmt->close();
    } else {
        // Si no existe, retornamos un mensaje
        echo json_encode(["success" => false, "message" => "El producto no existe en la base de datos."]);
    }

    $stmtCheck->close();
} else {
    echo json_encode(["success" => false, "message" => "ID no especificado."]);
}

$conexion->close();
<?php
// Este script se encarga de registrar un nuevo pedido en el sistema.
// Recibe datos de productos, subtotal y total a través de una solicitud GET.
// Utiliza una conexión a la base de datos para insertar los detalles del pedido
// en dos tablas: 'pedidos_enc' para la información general del pedido y 
// 'pedidos' para cada producto incluido en ese pedido.

// Variables:
// - $productos: Array que contiene los productos que se están pidiendo.
// - $subtotal: El subtotal del pedido (no utilizado directamente en la inserción).
// - $total: El total del pedido que se insertará en la base de datos.
// - $horaActual: La hora actual en formato 12 horas, para registrar la hora del pedido.
// - $estado: Variable booleana que indica el estado del pedido, en este caso inicializada como falso (0).

// El script primero prepara y ejecuta una consulta para insertar el pedido en 
// la tabla 'pedidos_enc'. Si la inserción es exitosa, obtiene el ID del último 
// pedido insertado y luego recorre el array de productos para insertar cada uno 
// en la tabla 'pedidos' vinculándolos al ID del pedido correspondiente.
// Finalmente, se cierra la conexión a la base de datos.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include "../../../modelos/ConexionBD.php";

    $id = $_POST['id'];
    $productos = json_decode($_POST['productos'], true);
    $subtotal = $_POST['subtotal'];
    $total = $_POST['total'];
    date_default_timezone_set('America/Bogota');
    $horaActual = date("H:i:s");
    $estado = false;
    

    $nuevo = "UPDATE pedidos_enc SET hora = ?, total = ?, estado = ? WHERE id_pedido = ?";
    if ($stmt = $conexion->prepare($nuevo)) {
        $stmt->bind_param("ssii", $horaActual, $total, $estado, $id);
        if (!$stmt->execute()) {
            echo "Error al actualizar el pedido: " . $stmt->error;  
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de actualización: " . $conexion->error;
    }
    

    $sql = "INSERT INTO pedidos (id_pedido, id_producto, hora, total, cantidad, estado) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = $conexion->prepare($sql)) {
        foreach ($productos as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];

            $query_precio = "SELECT Precio FROM productos WHERE id_producto = ?";
            if ($stmt_precio = $conexion->prepare($query_precio)) {
                $stmt_precio->bind_param("i", $id_producto);
                $stmt_precio->execute();
                $stmt_precio->bind_result($precio_unitario);
                $stmt_precio->fetch();
                $stmt_precio->close();
            } else {
                echo "Error al preparar la consulta de precio: " . $conexion->error;
                continue;
            }

            $total_producto = $precio_unitario;

            $stmt->bind_param("isssis", $id, $id_producto, $horaActual, $total_producto, $cantidad, $estado);
            
            if (!$stmt->execute()) {
                echo "Error al insertar el producto con ID $id_producto: " . $stmt->error;
            }
        }
        $stmt->close();
    } else {
        echo "Error al preparar la consulta de inserción: " . $conexion->error;
    }

    $conexion->close();
} else {
    echo "Método de solicitud no válido.";
}

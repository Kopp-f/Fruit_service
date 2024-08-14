<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    include "../../modelos/ConexionBD.php";

    $productos = $_GET['productos'];
    $subtotal = $_GET['subtotal'];
    $total = $_GET['total'];
    $horaActual = date("h:i:s A");
    $estado = false;

    
    $nuevo = "INSERT INTO pedidos_enc (hora, total, estado)
              VALUES ('$horaActual', '$total', '$estado')";

    if ($conexion->query($nuevo) === true) {
     
        $ultimoID = $conexion->insert_id;

        foreach ($productos as $producto) {
            $id_producto = $producto['id'];
            $cantidad = $producto['cantidad'];

            $sql = "INSERT INTO pedidos (id_pedido, id_producto, hora, total, Cantidad, estado)
                    VALUES ('$ultimoID', '$id_producto', '$horaActual', '$total', '$cantidad', '$estado')";

            if ($conexion->query($sql) !== true) {
                echo "Error al registrar el producto con ID $id_producto: " . $conexion->error;
                break;
            }
        }

      
        $conexion->close();
    } else {
        echo "Error al insertar el pedido: " . $conexion->error;
    }
}

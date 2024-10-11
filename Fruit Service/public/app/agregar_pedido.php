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

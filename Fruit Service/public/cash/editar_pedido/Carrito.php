<?php
// Este script se utiliza para recuperar la información de un producto específico 
// y calcular el total según la cantidad solicitada
session_start();
include "../../../modelos/ConexionBD.php"; 

if (isset($_GET['id'])) {
    $id_pedido = intval($_GET['id']); 
   
    $stmt = $conexion->prepare("SELECT id_producto, cantidad FROM pedidos WHERE id_pedido = ?");
    $stmt->bind_param("i", $id_pedido);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $producto_id = intval($row['id_producto']);
            $cantidad = intval($row['cantidad']);
            
           
            $stmtProducto = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
            $stmtProducto->bind_param("i", $producto_id);
            $stmtProducto->execute();
            $resultProducto = $stmtProducto->get_result();

            if ($resultProducto->num_rows > 0) {
                $productoInfo = $resultProducto->fetch_assoc();
                $precio = floatval($productoInfo['Precio']);
                
              
                $total = $precio * $cantidad;

               
                $html = '<tr id="producto_' . $producto_id . '">
                    <td>' . $productoInfo["Nombre_del_producto"] . '</td>
                    <td>' . $cantidad . '</td> <!-- Mostramos la cantidad -->
                    <td class="price">' . number_format($total, 2) . '</td>
                    <td><button onclick="borrarProducto(' . $producto_id . ')" class="btn btn-danger" style="background-color: red; font-size: 13px; margin: 3px; text-align: center; color: white;">
                        <i class="fa-solid fa-trash-can"></i></button></td>
                </tr>';

                echo $html; 
            }
        }
    } else {
        echo "<tr><td colspan='4'>0 resultados</td></tr>"; 
    }
    $conexion->close();
} else {
    echo "No se ha especificado un ID de pedido.";
}


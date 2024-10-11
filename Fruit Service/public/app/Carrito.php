<?php
// Este script se utiliza para recuperar la información de un producto específico 
// y calcular el total según la cantidad solicitada. 

// Incluye el archivo de conexión a la base de datos.
include "../../modelos/ConexionBD.php";

// Verifica si se han recibido los parámetros 'id' y 'cantidad' a través de la solicitud GET.
if (isset($_GET['id']) && isset($_GET['cantidad'])) {
    // Convierte los parámetros a enteros para su procesamiento.
    $id = intval($_GET['id']);
    $cantidad = intval($_GET['cantidad']);

    // Verifica que ambos valores sean positivos.
    if ($id > 0 && $cantidad > 0) {
        // Prepara una consulta SQL para seleccionar el producto basado en el ID.
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Si se encuentra el producto, calcula el total y genera una fila HTML.
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $precio = $row['Precio'];
            $total = $precio * $cantidad;
            $producto_id = $row["id_producto"];

            // Genera el HTML para mostrar la información del producto y un botón para eliminarlo.
            $html = '<tr id="producto_' . $producto_id . '">
                <td>' . $row["Nombre_del_producto"] . '</td>
                <td class="price">' . number_format($total, 2) . '</td>
                <td><button onclick="borrarProducto(' . $producto_id . ')" class="btn btn-danger" style="background-color: red; font-size: 13px; margin: 3px; text-align: center; color: white;">
                    <i class="fa-solid fa-trash-can"></i></button></td>
            </tr>';

            // Devuelve la fila HTML generada.
            echo $html;
        } else {
            // Si no se encuentra el producto, muestra un mensaje de "0 resultados".
            echo "<tr><td colspan='3'>0 resultados</td></tr>";
        }
    }
    // Cierra la conexión a la base de datos y termina la ejecución del script.
    $conexion->close();
    exit;
}

<?php
// Este archivo se encarga de agregar productos a una lista en función de su ID y cantidad, utilizando una conexión a la base de datos.
// Primero, se incluye el archivo de conexión a la base de datos. 
// Si se reciben los parámetros 'id' y 'cantidad' a través de la URL, se convierten en enteros.
// A continuación, se verifica que ambos valores sean positivos y se realiza una consulta a la base de datos 
// para obtener la información del producto correspondiente al ID proporcionado.
// Si se encuentra el producto, se calcula el precio total multiplicando el precio del producto por la cantidad especificada.
// Luego, se genera una fila HTML con el nombre del producto, el precio total formateado y un botón para eliminar el producto de la lista.
// Si no se encuentra el producto, se devuelve una fila que indica que no hay resultados.
// Finalmente, se cierra la conexión a la base de datos y se termina la ejecución del script.
include "../../../modelos/ConexionBD.php";

if (isset($_GET['id']) && isset($_GET['cantidad'])) {
    $id = intval($_GET['id']);
    $cantidad = intval($_GET['cantidad']);

    if ($id > 0 && $cantidad > 0) {
        
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $precio = $row['Precio'];
            $total = $precio * $cantidad;
            $producto_id = $row["id_producto"];

            $html = '<tr id="producto_' . $producto_id . '">
                <td>' . $row["Nombre_del_producto"] . '</td>
                <td class="price">' . number_format($total, 2) . '</td>
                <td><button onclick="borrarProducto(' . $producto_id . ')" class="btn btn-danger" style="background-color: red; font-size: 13px; margin: 3px; text-align: center; color: white;">
                    <i class="fa-solid fa-trash-can"></i></button></td>
            </tr>';

            echo $html;
        } else {
            echo "<tr><td colspan='3'>0 resultados</td></tr>";
        }
    }
    $conexion->close();
    exit;
}

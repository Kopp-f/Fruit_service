<?php
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

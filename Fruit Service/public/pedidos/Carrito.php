<?php
include "../../modelos/ConexionBD.php";

$id = $_GET['id']; 
$cantidad = $_GET['cantidad'];

if ($id != null && $cantidad != null) {

    $can = intval($cantidad);
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id_producto = ?");
    $stmt->bind_param("i", $id); 
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $html = '';
        while ($row = $result->fetch_assoc()) {
            $resuktado = $row["Precio"] * $can;
            $html .= '<tr>
                        <td>' . $row["Nombre_del_producto"] . '</td>
                        <td class="price">' . $resuktado . '</td>
                        <td><button class="btn btn-danger"
                                style="background-color: red; font-size: 13px; margin: 3px; text-align: center; color: white;">
                                <i class="fa-solid fa-trash-can"></i></button></td>
                    </tr>';
        }
        echo $html;
    } else {
        echo "<tr><td colspan='3'>0 resultados</td></tr>";
    }
    $conexion->close();
    exit;
}

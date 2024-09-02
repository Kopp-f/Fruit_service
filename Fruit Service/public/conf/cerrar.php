<?php
require '../../modelos/ConexionBD.php';

$tab = "SELECT SUM(total) AS total_pedido FROM pedidos_enc";
$sql = $conexion->query($tab);

if ($sql) {
    $resultado = $sql->fetch_assoc();
    $tot_pedido = $resultado['total_pedido'];

    $abrir = "SELECT id_abrir, encargado, fecha, valor_apertura FROM abrir_caja ORDER BY id_abrir DESC LIMIT 1";
    $consulta = $conexion->query($abrir);

    if ($consulta) {
        $columna = $consulta->fetch_assoc();
        $id = $columna['id_abrir'];
        $fecha = $columna['fecha'];
        $encargado = $columna['encargado'];
        $valor = $columna['valor_apertura'];

        $ingresos = $tot_pedido - $valor;

        $guardar = "INSERT INTO caja (id_abrir, Fecha, encargado, valor_apertura, Ingresos) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($guardar);
        $stmt->bind_param('isssd', $id, $fecha, $encargado, $valor, $ingresos);

        if ($stmt->execute()) {
            $vaciar_pedidos = "DELETE FROM pedidos_enc";
            if ($conexion->query($vaciar_pedidos) === TRUE) {
                header("Location: ../cajas.php");
                exit();
            } else {
                echo "Error al vaciar la tabla pedidos_enc: " . $conexion->error;
            }
        } else {
            echo "Error al guardar los datos: " . $stmt->error;
        }
    } else {
        echo "Error al obtener el último id y encargado: " . $conexion->error;
    }
} else {
    echo "Error al obtener la suma total: " . $conexion->error;
}

$conexion->close();

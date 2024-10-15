<?php
// Inclusión del archivo que contiene la conexión a la base de datos
require '../../modelos/ConexionBD.php';

// Consulta para obtener la suma total de todos los pedidos
$tab = "SELECT SUM(total) AS total_pedido FROM pedidos_enc";
$sql = $conexion->query($tab); // Ejecutar la consulta

// Verificar si la consulta se realizó correctamente
if ($sql) {
    $resultado = $sql->fetch_assoc(); // Obtener el resultado de la consulta
    $tot_pedido = $resultado['total_pedido']; // Almacenar el total de pedidos

    // Consulta para obtener el último registro de apertura de caja
    $abrir = "SELECT id_abrir, encargado, fecha, valor_apertura FROM abrir_caja ORDER BY id_abrir DESC LIMIT 1";
    $consulta = $conexion->query($abrir); // Ejecutar la consulta

    // Verificar si la consulta se realizó correctamente
    if ($consulta) {
        $columna = $consulta->fetch_assoc(); // Obtener el resultado de la consulta
        $id = $columna['id_abrir']; // ID del último registro de apertura
        $fecha = $columna['fecha']; // Fecha de apertura
        $encargado = $columna['encargado']; // Encargado de la apertura
        $valor = $columna['valor_apertura']; // Valor de apertura

        // Calcular los ingresos restando el valor de apertura del total de pedidos
        $ingresos = $tot_pedido - $valor;

        // Consulta para guardar los datos en la tabla 'caja'
        $guardar = "INSERT INTO caja (id_abrir, Fecha, encargado, valor_apertura, Ingresos) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($guardar); // Preparar la consulta
        $stmt->bind_param('isssd', $id, $fecha, $encargado, $valor, $ingresos); // Vincular los parámetros a la consulta

        // Ejecutar la consulta y verificar si se realizó correctamente
        if ($stmt->execute()) {
            // Si se guardan los datos correctamente, vaciar la tabla 'pedidos_enc'
            $vaciar_pedidos = "DELETE FROM pedidos_enc"; 
            if ($conexion->query($vaciar_pedidos) === TRUE) {
                header("Location: ../cash/cajas.php"); // Redirigir a la página de cajas
                exit(); // Salir para evitar que se ejecute más código
            } else {
                echo "Error al vaciar la tabla pedidos_enc: " . $conexion->error; // Mensaje de error si falla la operación
            }
        } else {
            echo "Error al guardar los datos: " . $stmt->error; // Mensaje de error si no se guardan los datos
        }
    } else {
        echo "Error al obtener el último id y encargado: " . $conexion->error; // Mensaje de error si falla la consulta
    }
} else {
    echo "Error al obtener la suma total: " . $conexion->error; // Mensaje de error si falla la consulta
}

// Cerrar la conexión a la base de datos
$conexion->close();

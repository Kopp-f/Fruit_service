<?php
/*
Este script se encarga de obtener información sobre los pedidos desde la base de datos y devolverla en formato JSON. 
Las principales funcionalidades son:
1. **Inicio de sesión:** Inicia la sesión para permitir el acceso a los datos.
2. **Conexión a la base de datos:** Incluye un archivo de conexión a la base de datos para establecer una conexión.
3. **Consulta de pedidos:** Realiza una consulta SQL para obtener el ID y el total de cada pedido de la tabla `pedidos_enc`.
4. **Cálculo de totales:** Acumula el total de los pedidos y cuenta la cantidad de pedidos registrados.
5. **Salida en formato JSON:** Devuelve los resultados en un formato JSON que incluye todos los pedidos, el total acumulado de los pedidos y la cantidad total de pedidos.
*/

session_start(); // Inicia la sesión
include "../../modelos/ConexionBD.php"; // Incluye el archivo de conexión a la base de datos

$query = "SELECT id_pedido, total FROM pedidos_enc"; // Consulta SQL para obtener ID y total de pedidos
$stmt = $conexion->prepare($query); // Prepara la consulta
$stmt->execute(); // Ejecuta la consulta
$result = $stmt->get_result(); // Obtiene el resultado de la consulta

$productos = []; // Inicializa un array para almacenar los pedidos
$total_pedidos = 0; // Inicializa el total acumulado de pedidos
$cantidad_pedidos = 0; // Inicializa la cantidad de pedidos

while ($row = $result->fetch_assoc()) { // Itera sobre cada fila del resultado
    $productos[] = ['id_pedido' => $row['id_pedido'], 'total' => $row['total']]; // Agrega el pedido al array
    $total_pedidos += $row['total']; // Acumula el total de los pedidos
    $cantidad_pedidos++; // Incrementa el contador de pedidos
}

// Devuelve el resultado en formato JSON
echo json_encode([
    'pedidos' => $productos, // Lista de pedidos
    'total_pedidos' => $total_pedidos, // Total acumulado de los pedidos
    'cantidad_pedidos' => $cantidad_pedidos // Cantidad total de pedidos
]);
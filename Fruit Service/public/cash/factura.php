<?php
// Este script se encarga de generar y mostrar la factura de un pedido específico en el sistema de gestión de pedidos.
// Se inicia una sesión para acceder a la información del usuario y se establece la zona horaria para Colombia (Bogotá).
// La fecha actual se obtiene en formato 'Y/m/d' y se recupera el nombre del usuario desde la sesión activa.
// Se incluye el archivo de conexión a la base de datos para realizar consultas.

// El ID del pedido se obtiene a través de la URL (GET request) y se convierte a un entero.
// Luego, se consulta la base de datos para obtener los detalles del pedido utilizando una sentencia preparada.
// Si no se encuentra el pedido, se muestra un mensaje de error y se detiene la ejecución.

// Si se encuentra el pedido, se obtiene el total del mismo y se define un estilo básico para la factura en HTML.
// A continuación, se estructura la página con un título que incluye el número de pedido, la fecha y el total a pagar.
// También se genera una tabla que mostrará los productos asociados al pedido.

// Se realizan consultas adicionales a la base de datos para obtener los productos de este pedido y sus detalles.
// Si se encuentran productos, se muestran en la tabla; de lo contrario, se indica que no hay productos asociados.
// Finalmente, se incluye un botón para permitir al usuario imprimir la factura generada.
session_start();

date_default_timezone_set('America/Bogota');
$fecha = date('Y/m/d');
$usuario = ($_SESSION['nombre']);
include '../../modelos/ConexionBD.php';

$id_pedido = intval($_GET['id']);

// Obtener detalles del pedido
$stmt = $conexion->prepare("SELECT * FROM pedidos_enc WHERE id_pedido = ?");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

// Comprobar si hay un resultado
if (!$row) {
    die("Error: No se encontró el pedido.");
}


$total = isset($row['total']) ? $row['total'] : 'Total no disponible';

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            border: 1px solid #ccc;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

<h1>Factura #<?php echo $row['id_pedido']; ?></h1>
<p>Fecha: <?php echo $fecha; ?></p>
<p>Total: <?php echo $total; ?></p>

<table>
    <thead>
        <tr>
            <th>Nombre del Producto</th>
            <th>Cantidad</th>
            <th>Precio</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Obtener los productos asociados al pedido
        $stmt = $conexion->prepare("SELECT id_producto, cantidad FROM pedidos WHERE id_pedido = ?");
        $stmt->bind_param("i", $id_pedido);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verificar si hay productos
        if ($result->num_rows > 0) {
            while ($rowPedido = $result->fetch_assoc()) {
                $producto_id = intval($rowPedido['id_producto']);
                $cantidad = intval($rowPedido['cantidad']);
                
                // Obtener los detalles del producto
                $stmtProducto = $conexion->prepare("SELECT Nombre_del_producto, precio FROM productos WHERE id_producto = ?");
                $stmtProducto->bind_param("i", $producto_id);
                $stmtProducto->execute();
                $resultProducto = $stmtProducto->get_result();
                
                // Mostrar los detalles de cada producto
                if ($producto = $resultProducto->fetch_assoc()) {
                    $nombre = $producto['Nombre_del_producto']; // Usar 'Nombre_del_producto'
                    $precio = isset($producto['precio']) ? $producto['precio'] : 'Precio no disponible';
                    
                    echo "<tr>
                            <td>{$nombre}</td>
                            <td>{$cantidad}</td>
                            <td>{$precio}</td>
                          </tr>";
                }
            }
        } else {
            echo "<tr><td colspan='3'>No se encontraron productos para este pedido.</td></tr>";
        }
        ?>
    </tbody>
</table>

<button onclick="window.print()">Imprimir Factura</button>

</body>
</html>
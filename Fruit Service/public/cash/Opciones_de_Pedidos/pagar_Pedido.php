<?php
/*
 * Este script PHP maneja el proceso de facturación de un pedido en un sistema de ventas.
 * 
 * 1. Inicia una sesión y establece una conexión con la base de datos.
 * 2. Verifica si se ha recibido un ID de pedido a través de la solicitud GET.
 * 3. Si el ID es válido, consulta la base de datos para obtener los productos y sus cantidades asociados con ese pedido.
 * 4. Calcula el total de la compra basado en los precios de los productos.
 * 5. Genera una interfaz HTML que muestra una tabla con los productos, la cantidad de cada uno y el total de la compra.
 * 6. Presenta un formulario que permite al usuario seleccionar un método de pago (efectivo o transferencia) y, si elige efectivo, ingresar el monto entregado.
 * 7. Calcula el cambio a devolver al usuario si el pago se realiza en efectivo.
 * 8. Envia la información del pago a otro script (actualizarEstado.php) para actualizar el estado del pedido en la base de datos.
 */
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirige a index.php
    header('Location: ../index.php');
    exit();
}
include "../../../modelos/ConexionBD.php";

if (isset($_GET['id'])) {
    $id_pedido = intval($_GET['id']);
    $stmt = $conexion->prepare("SELECT id_producto, cantidad FROM pedidos WHERE id_pedido = ?");
    $stmt->bind_param("i", $id_pedido);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificamos si hay productos para ese pedido
    if ($result->num_rows > 0) {
        $productos = []; // Array para guardar productos del pedido
        $total_compra = 0; // Variable para calcular el total de la compra

        // Recorremos los productos del pedido
        while ($row = $result->fetch_assoc()) {
            $producto_id = intval($row['id_producto']);
            $cantidad = intval($row['cantidad']);

            // Consulta para obtener la información del producto
            $stmtProducto = $conexion->prepare("SELECT Nombre_del_producto, Precio FROM productos WHERE id_producto = ?");
            $stmtProducto->bind_param("i", $producto_id);
            $stmtProducto->execute();
            $resultProducto = $stmtProducto->get_result();

            // Si se encontró el producto, calculamos el total
            if ($resultProducto->num_rows > 0) {
                $productoInfo = $resultProducto->fetch_assoc();
                $nombre_producto = $productoInfo['Nombre_del_producto'];
                $precio = floatval($productoInfo['Precio']);

                // Calculamos el total para cada producto
                $total = $precio * $cantidad;
                $total_compra += $total; // Sumar al total de la compra

                // Guardamos los detalles del producto en el array
                $productos[] = [
                    'producto' => $nombre_producto,
                    'cantidad' => $cantidad,
                    'total' => $total
                ];
            }
        }
    } else {
        $mensaje = "No se encontraron productos para este pedido.";
    }
} else {
    $mensaje = "No se ha recibido un ID de pedido válido.";
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruitservice</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" crossorigin="anonymous">
</head>

<body>
    <br>
    <center>
        <h1>Facturación</h1>
    </center>

    <div class="container my-4">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <table id="datatable_users" class="table table-striped" style="text-align: center;">
                    <caption>Productos del Pedido</caption>
                    <thead>
                        <tr>
                            <th class="centered">Producto</th>
                            <th class="centered">Cantidad</th>
                            <th class="centered">Total</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody_users">
                        <?php if (!empty($productos)): ?>
                            <?php foreach ($productos as $producto): ?>
                                <tr>
                                    <td><?php echo $producto['producto']; ?></td>
                                    <td><?php echo $producto['cantidad']; ?></td>
                                    <td><?php echo number_format($producto['total'], 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">
                                    <?php echo isset($mensaje) ? $mensaje : "No se encontraron productos en el pedido."; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="alert alert-info" role="alert">
                    <strong>Total de la compra: </strong> $<?php echo number_format($total_compra, 2); ?>
                </div>

                <form id="pagoForm" method="POST" action="actualizarEstado.php?id=<?php echo $id_pedido; ?>" onsubmit="return calcularCambio();">
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" name="metodo_pago" value="efectivo" required>
                        </div> Efectivo
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="radio" name="metodo_pago" value="transferencia" required>
                        </div> Transferencia
                    </div>

                    <div class="mb-3" id="efectivoInput" style="display:none;">
                        <label for="monto_entregado" class="form-label">Monto Entregado:</label>
                        <input type="number" class="form-control" id="monto_entregado" placeholder="Ingrese monto" min="0" oninput="calcularCambio()">
                    </div>

                    <div class="alert alert-warning" role="alert" id="cambio" style="display:none;">
                        <strong>Cambio a devolver: </strong> $<span id="cambioMonto">0.00</span>
                    </div>

                    <button type="submit" class="btn btn-sm btn-success">Confirmar Pago</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Mostrar el input solo si se selecciona Efectivo
        const efectivoRadio = document.querySelector('input[name="metodo_pago"][value="efectivo"]');
        const efectivoInput = document.getElementById('efectivoInput');

        efectivoRadio.addEventListener('change', function() {
            efectivoInput.style.display = 'block';
        });

        const transferenciaRadio = document.querySelector('input[name="metodo_pago"][value="transferencia"]');
        transferenciaRadio.addEventListener('change', function() {
            efectivoInput.style.display = 'none';
            document.getElementById('monto_entregado').value = ''; // Limpiar el input
            document.getElementById('cambio').style.display = 'none'; // Ocultar cambio
        });

        function calcularCambio() {
            const totalCompra = <?php echo $total_compra; ?>; // Total de la compra
            const montoEntregado = parseFloat(document.getElementById('monto_entregado').value) || 0;
            const cambioMonto = montoEntregado - totalCompra;

            const cambioDisplay = document.getElementById('cambio');
            const cambioMontoDisplay = document.getElementById('cambioMonto');

            if (document.querySelector('input[name="metodo_pago"]:checked').value === "efectivo") {
                cambioMontoDisplay.innerText = cambioMonto.toFixed(2);
                cambioDisplay.style.display = 'block';
            } else {
                cambioDisplay.style.display = 'none'; // Ocultar si no es efectivo
            }

            return true; // Permitir que el formulario se envíe
        }
    </script>
</body>

</html>
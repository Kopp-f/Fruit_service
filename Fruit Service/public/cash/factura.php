<?php
// Iniciar sesión
session_start();
// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Si no ha iniciado sesión, redirige a index.php
    header('Location: ../index.php');
    exit();
}

// Definir zona horaria y fecha actual
date_default_timezone_set('America/Bogota');
$fecha = date('Y/m/d');
$usuario = ($_SESSION['nombre']);

// Incluir conexión a la base de datos
include '../../modelos/ConexionBD.php';

$id_pedido = intval($_GET['id']);

// Obtener detalles del pedido
$stmt = $conexion->prepare("SELECT * FROM pedidos_enc WHERE id_pedido = ?");
$stmt->bind_param("i", $id_pedido);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Error: No se encontró el pedido.");
}

$total = isset($row['total']) ? $row['total'] : 'Total no disponible';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Factura - Fruit Service</title>
    <link rel="icon" href="../imagenes/service.png" type="image/x-icon">
    <link href="../../../css/bootstrap.css" rel="stylesheet" />
    <style>
        @import url(https://fonts.googleapis.com/css?family=Bree+Serif|Roboto:400,500);
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        h1, h4 {
            font-family: 'Bree Serif', serif;
            color: #333;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .panel-heading, .panel-body {
            background-color: #eaeaea;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
            color: #6a0dad; /* Morado suave */
        }
        .panel-heading a, .panel-body a {
            color: #6a0dad; /* Morado suave */
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        table th {
            background-color: #f7f7f7;
        }
        table tbody tr:nth-child(odd) {
            background-color: #f9f9f9;
        }
        .panel-info h6 {
            font-size: 12px;
            color: #6a0dad; /* Morado suave */
        }
        .row {
            margin: 0;
        }
        .qr-img {
            text-align: center;
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #6a0dad;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #581c87;
        }
        .logo-container {
            display: flex;
			position: relative;
            justify-content: space-between;
        }
        .logo-text {
            font-size: 50px;
        }
        .logo-text .fruit {
            color: #000;
            font-weight: bold;
        }
        .logo-text .service {
            color: #6a0dad;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row logo-container">
		
       <div class="logo-text" style="display: flex; align-items: center; justify-content: center;">
    <img src="../Imagenes/service.webp" style="width: 100px; margin-right: 10px;" class="logo-img">
    <span class="fruit" style="margin-left: 5px;">Fruit</span>
    <span class="service">Service</span>
</div>
        <div class="col-xs-6 text-right">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Tienda: <a href="#">Fruit_service</a></h4>
                    <h4>Atendido por: <a href="#"><?php echo $usuario ; ?></a></h4>
                </div>
                <div class="panel-body">
                    <h4>FACTURA: <a href="#"><?php echo $id_pedido  ?></a></h4>
                </div>
            </div>
        </div>
    </div>

    <hr />
    <h1>FACTURA</h1>

    <div class="row">
        <div class="col-xs-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4>Sasaima Cundinamarca, <a href="#"><?php echo date('d'); ?></a> de <a href="#"><?php echo date('F'); ?></a> de <a href="#"><?php echo date('Y'); ?></a></h4>
                </div>
                
            </div>
        </div>
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Cantidad</th>
                <th>Concepto</th>
                <th>Precio unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $stmt = $conexion->prepare("SELECT id_producto, cantidad FROM pedidos WHERE id_pedido = ?");
            $stmt->bind_param("i", $id_pedido);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($rowPedido = $result->fetch_assoc()) {
                    $producto_id = intval($rowPedido['id_producto']);
                    $cantidad = intval($rowPedido['cantidad']);

                    $stmtProducto = $conexion->prepare("SELECT Nombre_del_producto, precio FROM productos WHERE id_producto = ?");
                    $stmtProducto->bind_param("i", $producto_id);
                    $stmtProducto->execute();
                    $resultProducto = $stmtProducto->get_result();

                    if ($producto = $resultProducto->fetch_assoc()) {
                        $nombre = $producto['Nombre_del_producto'];
                        $precio = $producto['precio'];

                        echo "<tr>
                                <td>{$cantidad}</td>
                                <td>{$nombre}</td>
                                <td class='text-right'>{$precio}</td>
                                <td class='text-right'>" . ($precio * $cantidad) . "</td>
                              </tr>";
                    }
                }
            } else {
                echo "<tr><td colspan='4'>No se encontraron productos para este pedido.</td></tr>";
            }
            ?>
            <tr>
                <td colspan="3" style="text-align: right;">Total</td>
                <td class="text-right"><a href="#"><?php echo $total; ?></a></td>
            </tr>
        
        </tbody>
    </table>

    <div class="row">
        <div class="col-xs-4 qr-img">
            
        </div>
        <div class="col-xs-8 text-right">
            <div class="panel panel-info">
                <h6>"LA ALTERACIÓN, FALSIFICACIÓN O COMERCIALIZACIÓN ILEGAL DE ESTE DOCUMENTO ESTÁ PENADO POR LA LEY"</h6>
            </div>
        </div>
		<h6>"Gracias por su compra"</h6>
    </div>

    <button onclick="window.print()">Imprimir Factura</button>
</div>
</body>
</html>

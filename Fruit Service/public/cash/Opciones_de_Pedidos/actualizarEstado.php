<?php
// Iniciar la sesión
session_start();
// Incluir el archivo de conexión a la base de datos
include '../../../modelos/ConexionBD.php';

// Verificar si se ha recibido un ID de pedido y un método de pago a través de la solicitud GET y POST
if (isset($_GET['id']) && isset($_POST['metodo_pago'])) {
    // Obtener el ID del pedido y convertirlo a un entero
    $id_pedido = intval($_GET['id']);
    // Obtener el método de pago, que puede ser 'efectivo' o 'transferencia'
    $metodo_pago = $_POST['metodo_pago'];

    // Actualizar la columna transferencia en la base de datos según el método de pago
    if ($metodo_pago == 'transferencia') {
        // Preparar la consulta para actualizar el estado y marcar transferencia como 1
        $stmt = $conexion->prepare("UPDATE pedidos_enc SET estado = 1, transferencia = 1 WHERE id_pedido = ?");
        $stmt->bind_param("i", $id_pedido); // Asociar el ID del pedido a la consulta
    } else {
        // Si el método de pago es efectivo, solo actualizamos el estado y marcamos transferencia como 0
        $stmt = $conexion->prepare("UPDATE pedidos_enc SET estado = 1, transferencia = 0 WHERE id_pedido = ?");
        $stmt->bind_param("i", $id_pedido); // Asociar el ID del pedido a la consulta
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        // Si la ejecución es exitosa, redirigir a nuevaCaja.php
        header("Location: ../nuevaCaja.php");
        exit(); // Asegurarse de que no se ejecute más código después de redirigir
    } else {
        // Manejo de errores en caso de que la actualización falle
        echo "<script>
                alert('No se pudo actualizar el pedido.'); // Mostrar mensaje de error
                window.location.href = '../nuevaCaja.php'; // Redirigir en caso de error
              </script>";
    }

    // Cerrar la declaración preparada
    $stmt->close();
} else {
    // Si no se reciben los parámetros necesarios, mostrar un mensaje de error
    echo "<script>
            alert('No se ha recibido un ID de pedido válido o método de pago.'); // Mensaje de alerta
            window.location.href = '../nuevaCaja.php'; // Redirigir en caso de error
          </script>";
}

// Cerrar la conexión a la base de datos
$conexion->close();
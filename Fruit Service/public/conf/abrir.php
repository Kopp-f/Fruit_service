<?php
// Requiere el archivo de conexión a la base de datos
require '../../modelos/ConexionBD.php';

// Verifica si la solicitud se ha hecho mediante el método POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtiene los datos enviados desde el formulario
    $fecha = $_POST['fecha']; // Fecha de apertura de la caja
    $encargado = $_POST['usuario']; // Usuario encargado de abrir la caja
    $valor_apertura = $_POST['valor']; // Valor de apertura de la caja

    // Prepara la consulta SQL para insertar los datos en la tabla 'abrir_caja'
    $sql = "INSERT INTO abrir_caja (fecha, encargado, valor_apertura) VALUES ('$fecha', '$encargado', '$valor_apertura')";

    // Ejecuta la consulta y verifica si fue exitosa
    if ($conexion->query($sql) === TRUE) {
        // Si la inserción fue exitosa, redirige a la página 'nuevaCaja.php'
        header("location: ../cash/nuevaCaja.php");
    } else {
        // Si hubo un error al ejecutar la consulta, muestra un mensaje de error usando SweetAlert
        echo "<script>Swal.fire('Error', '" . $conexion->error . "', 'error');</script>";
    }

    // Cierra la conexión a la base de datos
    $conexion->close();
}

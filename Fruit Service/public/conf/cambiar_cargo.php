<?php
// Inclusión del archivo que contiene la conexión a la base de datos
include "../../modelos/ConexionBD.php";

// Verificación de que se han recibido los datos necesarios a través de un formulario
if (isset($_POST['id_usuario']) && isset($_POST['cargo'])) {
    $id_usuario = $_POST['id_usuario']; // Obtener el ID del usuario del formulario
    $nuevo_cargo = $_POST['cargo']; // Obtener el nuevo cargo del formulario

    // Consulta SQL para actualizar el cargo del usuario en la base de datos
    $sql = "UPDATE usuario SET cargo_id = ? WHERE id_usuario = ?"; 
    $stmt = $conexion->prepare($sql); // Preparar la consulta para evitar inyecciones SQL
    $stmt->bind_param("ii", $nuevo_cargo, $id_usuario); // Vincular los parámetros a la consulta

    // Ejecutar la consulta y verificar si se realizó correctamente
    if ($stmt->execute()) {
        echo "Cargo actualizado correctamente."; // Mensaje de éxito si se actualiza correctamente
    } else {
        echo "Error al actualizar el cargo: " . $conexion->error; // Mensaje de error si falla la actualización
    }

    $stmt->close(); // Cerrar la declaración preparada
}

// Cerrar la conexión a la base de datos
$conexion->close();

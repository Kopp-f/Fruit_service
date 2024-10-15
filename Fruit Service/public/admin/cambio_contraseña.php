<?php
/**
 * Este archivo se encarga de permitir a los usuarios modificar su contraseña en 
 * el sistema. Antes de realizar cualquier operación, verifica que el usuario 
 * esté autenticado. Si no lo está, redirige a la página de inicio de sesión.
 *
 * Funciones principales:
 * - Inicia una sesión y se conecta a la base de datos.
 * - Comprueba si el usuario ha iniciado sesión; de lo contrario, redirige.
 * - Procesa la solicitud de cambio de contraseña si se envía el formulario.
 * - Valida que el campo de nueva contraseña no esté vacío.
 * - Encripta la nueva contraseña utilizando el algoritmo SHA-512.
 * - Actualiza la contraseña en la base de datos si la nueva contraseña es válida.
 * - Proporciona mensajes de estado sobre el resultado del intento de actualización.
 */
session_start();
include "../../modelos/ConexionBD.php"; 

// Verificar si el usuario está en sesión
if (!isset($_SESSION['nombre'])) {
    header("Location: ../public/index.php?error=not_logged_in");
    exit();
}


$status_message = "";

if (isset($_POST["btnmodificar"])) {
    $new_password = trim($_POST["new-password"]);

    // Verificar que el campo de nueva contraseña no esté vacío
    if (!empty($new_password)) {
        $usuario = $_SESSION['nombre'];
        $new_password_encrypted = hash('sha512', $new_password); // Encriptar la nueva contraseña

        // Consulta para actualizar la contraseña del usuario
        $update_query = "UPDATE usuario SET Contraseña = ? WHERE Nombre = ?";
        $update_stmt = $conexion->prepare($update_query);

        if (!$update_stmt) {
            die("Error en la preparación de la consulta de actualización: " . $conexion->error);
        }

        // Enlazar los parámetros (nueva contraseña encriptada y usuario)
        $update_stmt->bind_param("ss", $new_password_encrypted, $usuario);

        // Ejecutar la consulta de actualización
        if ($update_stmt->execute()) {
            if ($update_stmt->affected_rows > 0) {
                $status_message = "Contraseña actualizada exitosamente.";
                header("Location: ../public/admin/configuración.php");
            } else {
                $status_message = "No se realizaron cambios en la contraseña. Es posible que la nueva contraseña sea la misma que la anterior.";
            }
        } else {
            $status_message = "Error al ejecutar la actualización: " . $update_stmt->error;
        }

        $update_stmt->close();
    } else {
        $status_message = "Por favor, ingresa una nueva contraseña.";
    }

    $conexion->close();
}

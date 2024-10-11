<?php
/**
 * Este archivo gestiona el cambio del nombre de usuario en la aplicación. 
 * Inicia una sesión para acceder a la información del usuario actual.
 * 
 * Funciones principales:
 * - Procesa un formulario que permite al usuario cambiar su nombre.
 * - Verifica si se está enviando una solicitud POST.
 * - Comprueba si el nuevo nombre de usuario proporcionado no está vacío.
 * - Consulta la base de datos para verificar si el nuevo nombre de usuario ya existe.
 * - Si no existe, actualiza el nombre de usuario en la base de datos.
 * - Actualiza la sesión con el nuevo nombre de usuario y redirige a la configuración del usuario.
 * - Si el nuevo nombre de usuario ya está en uso o está vacío, se genera un mensaje de error.
 */

session_start();
include "../../modelos/ConexionBD.php";

$currentUsername = $_SESSION['nombre']; // Obtener el nombre de usuario actual de la sesión

// Procesar el formulario de cambio de nombre de usuario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username']);

    if (!empty($newUsername)) {
        // Verificar si el nuevo nombre de usuario ya existe en la base de datos
        $checkQuery = "SELECT COUNT(*) FROM usuario WHERE Nombre = ?";
        $checkStmt = $conexion->prepare($checkQuery);
        $checkStmt->bind_param("s", $newUsername);
        $checkStmt->execute();
        $checkStmt->bind_result($userCount);
        $checkStmt->fetch();
        $checkStmt->close();

        if ($userCount == 0) {
            // Actualizar el nombre de usuario
            $query = "UPDATE usuario SET Nombre = ? WHERE Nombre = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param("ss", $newUsername, $currentUsername);

            if ($stmt->execute()) {
                $_SESSION['nombre'] = $newUsername; // Actualizar el nombre de usuario en la sesión
                header("Location: ../public/admin/configuración.php");
                exit();
            } else {
                $error = "Error al actualizar el nombre de usuario.";
            }

            $stmt->close();
        } else {
            $error = "El nombre de usuario ya está en uso. Por favor, elige otro.";
        }
    } else {
        $error = "El nuevo nombre de usuario no puede estar vacío.";
    }
}

$conexion->close();


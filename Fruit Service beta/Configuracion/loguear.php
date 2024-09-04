<?php
session_start();
include "../modelos/ConexionBD.php";

$usuario = trim($_POST["Usuario"]);
$contraseña_ingreso = trim($_POST["Contraseña_in"]);
$contraseña_ingreso_encrip = hash('sha512', $contraseña_ingreso);

$q = "SELECT cargo_id FROM usuario WHERE Nombre = ? AND Contraseña = ?";
$stmt = $conexion->prepare($q);
$stmt->bind_param("ss", $usuario, $contraseña_ingreso_encrip);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($cargo_id);
    $stmt->fetch();

    $_SESSION['nombre'] = $usuario;

    // Consulta para obtener la imagen
    $sql = "SELECT imagen FROM usuario WHERE Nombre = ? LIMIT 1";
    $stmt_imagen = $conexion->prepare($sql);
    $stmt_imagen->bind_param("s", $usuario);
    $stmt_imagen->execute();
    $stmt_imagen->bind_result($imagen);
    $stmt_imagen->fetch();

    if ($imagen) {
        // Guardar la imagen en la sesión
        $_SESSION['foto'] = $imagen;

        if ($cargo_id == 1) {
            header("Location: ../public/admin/cajas.php");

        }elseif ($cargo_id == 2){
            header("Location: ../public/cash/Homepage_usuario.php");
            
        }elseif ($cargo_id == 3){
            header("Location: ../public/app/Homepage_usuario.php");
        }
        
        else {
            header("Location: ../public/app/Homepage_usuario.php");
        }
    } else {
        echo "No se encontraron resultados";
    }

    $stmt_imagen->close();
} else {
    header("Location: ../public/index.php?error=true");
}

$stmt->close();
$conexion->close();

<?php
session_start();
include "../modelos/ConexionBD.php";

$usuario = trim($_POST["Usuario"]);
$contraseña_ingreso = trim($_POST["Contraseña_in"]);
$contraseña_ingreso_encrip = hash('sha512', $contraseña_ingreso);

$q = "SELECT id_cargo FROM usuario WHERE Nombre = ? AND Contraseña = ?";
$stmt = $conexion->prepare($q);
$stmt->bind_param("ss", $usuario, $contraseña_ingreso_encrip);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($id_cargo);
    $stmt->fetch();
    
    $_SESSION['nombre'] = $usuario;

    if ($id_cargo == 1) {
        header("Location: ../public/cajas.php");
    } elseif ($id_cargo != 1) {
        header("Location: ../public/app/Homepage_usuario.php");
      
    }
} else {
    header("Location: ../public/index.php?error=true");
}

$stmt->close();
$conexion->close();

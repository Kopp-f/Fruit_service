<?php
session_start();

$nombre = trim($_POST["Nombre"]);
$correo = trim($_POST["Correo"]);
$telefono = trim($_POST["telefono"]);
$Contraseña = trim($_POST["Contraseña"]);
$contraseña_encrip = hash('sha512', $Contraseña); 
$rol = 1;

echo $nombre, $correo, $telefono, $Contraseña, "<br>";

include "../../modelos/ConexionBD.php";

$sql = "INSERT INTO usuario(Nombre, Correo, Telefono, Contraseña,imagen,cargo_id)
        VALUES ('$nombre', '$correo', '$telefono', '$contraseña_encrip','Imagen_usuario/usuario.png',$rol)"; 

if ($conexion->query($sql) === true) {
    echo "registrado"; 
} else {
    echo "NO SE registrado"; 
}

$conexion->close();


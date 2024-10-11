<?php
// Iniciar la sesión para almacenar información del usuario
session_start();

// Recoger y limpiar los datos del formulario
$nombre = trim($_POST["Nombre"]); // Nombre del usuario
$correo = trim($_POST["Correo"]); // Correo del usuario
$telefono = trim($_POST["telefono"]); // Teléfono del usuario
$Contraseña = trim($_POST["Contraseña"]); // Contraseña proporcionada por el usuario

// Encriptar la contraseña utilizando el algoritmo SHA-512
$contraseña_encrip = hash('sha512', $Contraseña); 

// Asignar un rol por defecto (3 en este caso)
$rol = 3;

// Incluir el archivo de conexión a la base de datos
include "../../modelos/ConexionBD.php";

// Consulta SQL para insertar el nuevo usuario en la tabla 'usuario'
$sql = "INSERT INTO usuario(Nombre, Correo, Telefono, Contraseña, imagen, cargo_id)
        VALUES ('$nombre', '$correo', '$telefono', '$contraseña_encrip', 'Imagen_usuario/usuario.png', $rol)"; 

// Ejecutar la consulta y verificar si se realizó correctamente
if ($conexion->query($sql) === true) {
    // Redirigir a la página de inicio con un mensaje de éxito
    header("Location: ../index.php?registro=success");
    exit(); // Salir para evitar que se ejecute más código
} else {
    // Redirigir a la página de inicio con un mensaje de error
    header("Location: ../index.php?registro=error");
    exit(); // Salir para evitar que se ejecute más código
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
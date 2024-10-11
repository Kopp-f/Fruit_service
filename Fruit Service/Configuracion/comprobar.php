<?php
// Este script se encarga de autenticar a un usuario verificando su nombre de usuario y contraseña.
// Si los datos coinciden, redirige al usuario a la página correspondiente.

// Se obtienen los datos del formulario y se eliminan los espacios en blanco innecesarios.
$usuario = trim($_POST["Usuario"]);
$Contraseña_ingreso = trim($_POST["Contraseña_in"]);

// Se incluye el archivo de conexión a la base de datos.
include "../modelos/ConexionBD.php";

// Consulta para verificar si existe un usuario con las credenciales ingresadas.
$q = "SELECT COUNT(*) as contar FROM usuario WHERE Nombre = '$usuario' and Contraseña = '$Contraseña_ingreso'";

// Se ejecuta la consulta en la base de datos.
$consulta = mysql_query($conexion, $q);

// Se obtiene el resultado de la consulta.
$array = mysqli_fetch_array($consulta);

// Si se encuentra un usuario con esas credenciales, se redirige a la página de cajas.
if ($array['contar'] >= 0) {
    header("../public/cajas.php");
} else {
    // Si las credenciales son incorrectas, se muestra un mensaje de error.
    echo "Datos incorrectos";
}

// Se cierra la conexión a la base de datos.
$conexion->close();
<?php
// Este script establece una conexión con una base de datos MySQL usando la clase `mysqli`. 
// Define los parámetros del servidor (host, usuario, contraseña, base de datos) y crea un objeto de conexión.
// La sección comentada puede ser usada para verificar si la conexión ha fallado, y en ese caso, detener la ejecución con un mensaje de error.
$SERVER = "localhost";
$user = "root";
$pass = "";
$db = "fruit_service";

$conexion = new mysqli($SERVER,$user,$pass,$db);

/* if ($conexion -> connect_errno){
    die("Location: Conexion fallida" . $connect_errno);
}
else{
    echo "Conectado";
}  */
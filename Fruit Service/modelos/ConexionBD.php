<?php
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
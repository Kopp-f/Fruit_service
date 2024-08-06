<?php
session_start();
include "../modelos/ConexionBD.php";

$usuario = trim($_POST["Usuario"]);
$Contraseña_ingreso = trim($_POST["Contraseña_in"]);
$q = "SELECT COUNT(*) as contar FROM usuario WHERE Nombre = '$usuario' and Contraseña = '$Contraseña_ingreso' ";

$consulta = mysqli_query($conexion, $q);

$array = mysqli_fetch_array($consulta);

if( $array['contar'] > 0){

    $_SESSION['nombre'] = $usuario;
    header("Location: ../public/cajas.php");
    

}
else{
    
    header("Location: ../public/index.php ?error=true");
}
 
 

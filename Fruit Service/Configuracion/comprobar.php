<?php

$usuario = trim($_POST["Usuario"]);
$Contraseña_ingreso = trim($_POST["Contraseña_in"]);

include "../modelos/ConexionBD.php";

$q = "SELECT COUNT(*)as contar FROM usuario WHERE Nombre = '$usuario' and Contraseña = '$Contraseña_ingreso' ";

$consulta = mysql_query($conexion,$q);

$array = mysqli_fetch_array($consulta);

if($array['contar'] >= 0){
    header("../public/cajas.php");

}else{
    echo "datos incorrectos";
}
 
 
$conexion->close();  
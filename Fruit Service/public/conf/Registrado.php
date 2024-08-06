<?php
    $nombre = trim($_POST["Nombre"]);
    $correo = trim($_POST["Correo"]);
    $telefono =trim($_POST["telefono"]);
    $Contraseña =trim($_POST["Contraseña"]);
    echo $nombre,$correo,$telefono,$Contraseña,"<br>";
    
    include "../../modelos/ConexionBD.php";

    $sql = "INSERT INTO usuario(Nombre,Correo,Telefono,Contraseña)
                VALUE('$nombre','$correo','$telefono','$Contraseña')";
    
    if ($conexion->query($sql) == true) {
        echo "resgitado";
    } else {
        echo "NO SE resgitado";
    }
    $conexion->close();  

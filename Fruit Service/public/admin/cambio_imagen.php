<?php
/**
 * Este archivo se encarga de manejar la subida de imágenes de perfil de usuario. 
 * Primero, inicia una sesión para acceder a la información del usuario. 
 * Luego, verifica si se ha enviado una imagen a través de un formulario.
 * 
 * Funciones principales:
 * - Comprueba si hay un archivo de imagen y si no hay errores en la carga.
 * - Verifica el tipo de archivo y permite solo imágenes en formatos JPG, JPEG y PNG.
 * - Conecta a la base de datos y actualiza la ruta de la imagen del usuario en la base de datos.
 * - Mueve la imagen del directorio temporal al directorio de imágenes del usuario.
 * - Redirige a la configuración del usuario tras una carga exitosa.
 * - Maneja errores en la carga de imágenes y en la actualización de la base de datos.
 */
session_start();


if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
    $imagen = $_FILES["imagen"]["tmp_name"]; 
    $Nombre_imagen = $_FILES["imagen"]["name"];
    $tipoImagen = strtolower(pathinfo($Nombre_imagen, PATHINFO_EXTENSION)); 

    $carpeta = "../Imagen_usuario/"; 
    $carpeta3 = "Imagen_usuario/"; 

    if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
        $usuario = $_SESSION['nombre']; 
        include "../../modelos/ConexionBD.php";
        if ($conexion->connect_error) {
            die("La conexión falló: " . $conexion->connect_error);
        }
        $ruta = $carpeta . $usuario . "." . $tipoImagen;
        $ruta_base = $carpeta3 . $usuario . "." . $tipoImagen;

        $actualizarImagen = $conexion->query("UPDATE usuario SET imagen = '$ruta_base' WHERE Nombre = '$usuario'");

        if ($actualizarImagen === true) {
            if (move_uploaded_file($imagen, $ruta)) {
             
                header("Location: ../public/admin/configuración.php");
                exit();
            } else {
                echo "Error al mover la imagen al servidor.";
            }
        } else {
            echo "Error al actualizar la ruta de la imagen en la base de datos.";
        }

        $conexion->close();
    } else {
        echo "Tipo de imagen no soportado. Solo se permiten archivos JPG, JPEG y PNG.";
    }
} else {
    echo "No se ha subido ningún archivo o hubo un error en la subida.";
}

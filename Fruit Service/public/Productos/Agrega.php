<?php
  $imagen = $_FILES["imagen"]["tmp_name"];
  $Nombre_imagen = $_FILES["imagen"]["name"];
  $tipoImagen = strtolower(pathinfo($Nombre_imagen, PATHINFO_EXTENSION));
  $carpeta = "../Imagenes_Productos/";
  if ($tipoImagen == "jpg" || $tipoImagen == "jpeg" || $tipoImagen == "png") {
      $nombre = trim($_POST["Nombre_producto"]);
      $descripcion = trim($_POST["Descripcion"]);
      $precio = $_POST["Precio"];

      include "../../modelos/ConexionBD.php";
      if ($conexion->connect_error) {
          die("La conexión falló: " . $conexion->connect_error);
      }
      $registro = $conexion->query("INSERT INTO productos(Nombre_del_producto, Descripcion, Precio) VALUES ('$nombre', '$descripcion', '$precio')");
      if ($registro === true) {
          $idregistro = $conexion->insert_id;
          $ruta = $carpeta . $idregistro . "." . $tipoImagen;
          $actualizarImagenes = $conexion->query("UPDATE productos SET Imagen = '$ruta' WHERE id_producto = $idregistro");
          if ($actualizarImagenes === true) {
              if (move_uploaded_file($imagen, $ruta)) {
                 
                header("Location: Agregar.php?Aviso=true");
              } else {
                 
              }
          } else {
             
          }
      } else {
          
      }

  
      $conexion->close();
  } else {
      echo "Tipo de imagen no soportado. Solo se permiten archivos JPG, JPEG y PNG.";
  }


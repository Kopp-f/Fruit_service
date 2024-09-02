<?php
require '../../modelos/ConexionBD.php';


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $fecha = $_POST['fecha'];
      $encargado = $_POST['usuario'];
      $valor_apertura = $_POST['valor'];
    
      $sql = "INSERT INTO abrir_caja (fecha, encargado, valor_apertura) VALUES ('$fecha', '$encargado', '$valor_apertura')";
    
      if ($conexion->query($sql) === TRUE) {
        header("location: ../nuevaCaja.php");
      } else {
        echo "<script>Swal.fire('Error', '" . $conexion->error . "', 'error');</script>";
      }
    
      $conexion->close();
    }
    
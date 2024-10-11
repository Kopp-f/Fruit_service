<?php
// Este script genera una tabla HTML con información de los usuarios obtenida de la base de datos.
// Consulta la tabla 'usuario' y permite aplicar un filtro si se proporciona un campo en la URL (en este caso, 'Fecha').
// La tabla muestra la imagen del usuario, nombre, cargo, y botones para editar el cargo o eliminar el usuario.
// Si no hay resultados, muestra un mensaje de "Sin resultados".
require 'ConexionBD.php';
$columns = ['id_usuario', 'Nombre', 'imagen', 'cargo_id'];
$table = "usuario"; 
$filtro = "";


if(isset($_GET['campo'])){
    $filtro = " WHERE Fecha = '" . $_GET['campo'] . "'"; // Ajusta el campo a filtrar según tus necesidades
}

$sql = "SELECT " . implode(", ", $columns) . " FROM $table" . $filtro;

$resultado = $conexion->query($sql);
$num_rows = $resultado->num_rows;
$html = "";

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td><img class="rounded-image" src="../' . $row['imagen'] . '" alt="Imagen de usuario" style="width:50px; height:50px;"></td>';
        $html .= '<td>' . $row['Nombre'] . '</td>';
        $html .= '<td>' . $row['cargo_id'] . '</td>'; 
        $html .= '<td>
                    <button class="btn btn-sm btn-primary"  onclick="cambiarCargo(' . $row["id_usuario"] . ')" "><i class="fa-solid fa-pencil"></i></button>
                    <button class="btn btn-sm btn-danger" onclick="deleteUsuario(' . $row["id_usuario"] . ')"><i class="fa-solid fa-trash-can"></i></button>
                  </td>';
        $html .= '</tr>';
    }
} else {
    $html .= '<tr>';
    $html .= '<td colspan="6">Sin resultados</td>'; // Ajusta el colspan según la cantidad de columnas
    $html .= '</tr>';
}

echo $html;
$conexion->close();

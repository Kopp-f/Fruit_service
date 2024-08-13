<?php
require '../modelos/ConexionBD.php';
$columns = ['id', 'Fecha', 'encargado', 'ingresos'];
$table = "caja";
$filtro = "";

if(isset($_GET['campo'])){

    $filtro =" WHERE Fecha = '".$_GET['campo']."'";
}
/* $campo = isset($_POST['campo']) ? $conn->real_escape_string($_POST['campo']) : null; */


$sql = "SELECT " . implode(", ",$columns) . "
FROM $table".$filtro;


$resultado = $conexion-> query($sql);
$num_rows = $resultado->num_rows;
$html = " ";

$resultado2 =[];

if ($num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        $resultado2 = $row;
        $html .= '<tr>';
        $html .=' <td>' . $row['id'] . '</td>';
        $html .= '<td>' . $row['Fecha'] . '</td>';
        $html .= ' <td>' . $row['encargado'] . '</td>';
        $html .= ' <td>' . $row['ingresos'] . '</td>';
        $html .= '<td><i class="fa-solid fa-check" style="color: green;"></i></td>';
        $html .= ' <td>
                                    <button class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" fill="currentColor" class="bi bi-printer-fill"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1" />
                                            <path
                                                d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1" />
                                        </svg></button> ';
        $html .= '<button class="btn btn-sm btn-danger" onclick="deletecaja(' . $row["id"] .')"><i class="fa-solid fa-trash-can"></i></button> </td>';
        $html .= '</tr>';
    }


} else {
    $html .= '<tr>';
    $html .= '<td colspan="7">Sin resultados</td>';
    $html .= '</tr>';
}

echo $html;
$conexion->close(); 

/* var_dump($html);
echo json_encode($resultado2);
 */


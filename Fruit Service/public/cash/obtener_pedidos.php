<?php
// Este script inicia una sesión y establece una conexión a la base de datos.
// Se consulta la tabla 'pedidos_enc' para obtener los pedidos existentes, incluyendo su ID, hora, total y estado.

// Ejecuta la consulta SQL para recuperar los pedidos.

session_start();
include '../../modelos/ConexionBD.php';

$tab_sql = "SELECT id_pedido, hora, total, estado FROM pedidos_enc";
$result = $conexion->query($tab_sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["hora"] . "</td>";
        echo "<td>" . $row["total"] . "</td>";

      
        if ($row['estado'] == 0) {
            echo "<td><span style='background-color: #D4AF37; color: white; border-radius: 5px; padding: 2px 8px;'>
                    <i class='fa fa-clock' style='color: white;'></i> Espera
                  </span></td>";
        } elseif ($row['estado'] == 1) {
            echo "<td><span style='background-color: green; color: white; border-radius: 5px; padding: 2px 8px;'>
                    <i class='fa fa-check' style='color: white;'></i> Cancelado
                  </span></td>";
        }

      
        echo '<td>';
        if ($row['estado'] == 0) {
           
            echo '<button class="btn btn-sm btn-primary" onclick="window.location.href=\'editar_pedido/pedido.php?id=' . $row["id_pedido"] . '\'">
                    <i class="fa-solid fa-pencil"></i>
                  </button>
                  <button onclick="borrar(' . $row["id_pedido"] . ')" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                  <button onclick="window.location.href=\'Opciones_de_Pedidos/pagar_Pedido.php?id=' . $row["id_pedido"] . '\'" class="btn btn-sm" style="background-color: green;color:white"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-credit-card-fill" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v1H0zm0 3v5a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7zm3 2h1a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1v-1a1 1 0 0 1 1-1" />
                    </svg>
                  </button>';
        } elseif ($row['estado'] == 1) {
           
            echo '<button class="btn btn-sm btn-primary" style="color:white" onclick="window.open(\'factura.php?id=' . $row["id_pedido"] . '\', \'_blank\')"">
                    <i class="fa-solid fa-print"></i> Imprimir</button>';
        }
        echo '</td>';
        
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='4'>0 resultados</td></tr>";
}

$conexion->close();

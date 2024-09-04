<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/Homepage.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/Homepage.css">
     <!--jquery-->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<!-- DataTable -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css">

<script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    
     
    <title>Responsive Dashboard Design #2 | AsmrProg</title>
</head>

<body>
    

    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <img src="../imagenes/service.webp" alt="">
            <div class="logo-name"><span>Fruit</span>Service</div>
        </a>
        
        <ul class="side-menu">
            <li><a href="#"><i class='bx bxs-pencil'></i>Pedidos</a></li>
            <li class="active"><a href="#"><i class='bx bx-message-square-error'></i>Reportes</a></li>
            <li><a href="#"><i class='bx bxs-cog'></i>Configuracion</a></li>
            <li><a href="../../Configuracion/Salir.php" class="logout"><i class='bx bx-log-out-circle'></i> Salir</a></li>
            
        </ul>
        
        
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label>
            <a href="#" class="notif">
                <i class='bx bx-bell'></i>
                <span class="count">12</span>
            </a>
            <a href="#" class="profile">
                <img src="../imagenes/logo.png">
            </a>
        </nav>

        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Nuevo pedido </h1>
                    <ul class="breadcrumb">
                        <li><a href="#">
                                Productos
                            </a></li>
                        <li><a href="#" class="active">Helados</a></li>
                    </ul>
                </div>
                <a href="#" class="report">
                    <i class='bx bx-cloud-download'></i>
                    <span>Download CSV</span>
                </a>
            </div>

            

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Tomar pedido</h3>
                        
                        
                    </div>
                    <table  id="tabla" >
                        <thead>
                            <tr>
                                <th class="centered">Producto</th>
                                <th class="centered"> Precio/</th>
                                <th class="centered"> Cantidad/</th>
                                <th class="centered"> Añadir </th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            
                                <?php

                                    include '../../modelos/ConexionBD.php';

                                    $resultado = mysqli_query($conexion, "SELECT * FROM productos");
                                            while ($consulta = mysqli_fetch_array($resultado)) {
                                                echo "<tr>";
                                                echo "<td><img src='../imagenes_Productos/" . $consulta["Imagen"] . "' class='table-img'  style='width: 100px;height: auto;'<br>" . $consulta["Nombre_del_producto"] . "</td>";
                                                
                                                echo "<td><br>" . $consulta["Precio"] . "</td>";
                                                echo '<td><br>  <input id="cantidad_' . $consulta["id_producto"] . '" type="number" min="1" max="30"
                                                     class="form-control quantity-input">';
                                                echo '<td><br> <center><button onclick="CapturarPedido(' . $consulta["id_producto"] . ') "  class="btn btn-sm btn-primary"
                                                            style="width:60px;"><svg xmlns="http://www.w3.org/2000/svg"
                                                                width="17" height="17" fill="currentColor"
                                                                class="bi bi-printer-fill" viewBox="0 0 16 16">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="17"
                                                                    height="17" fill="currentColor"
                                                                    class="bi bi-cart-plus-fill" viewBox="0 0 16 16">
                                                                    <path
                                                                        d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0M9 5.5V7h1.5a.5.5 0 0 1 0 1H9v1.5a.5.5 0 0 1-1 0V8H6.5a.5.5 0 0 1 0-1H8V5.5a.5.5 0 0 1 1 0" />
                                                                </svg>
                                                            </svg></button></center></td>';

                                                echo "</tr>";
                                     }
                                    ;
                                    $conexion->close(); ?>

                                    <!-- Php-->
                            </tbody>
                    </table>
                </div>

                <div class="bottom-data">
                    <div class="summary">
                            <h3>Factura</h3>
                            <div class="summary-item"><span class="text">Productos:</span>
                                <br>
                                <table style="text-align: center;">
                                    <thead>
                                        <tr>

                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>

                                </table>
                                <br>
                            </div>
                            <div class="summary-item"><span class="text">Subtotal</span>
                                <span id="subtotal" class="price">$0.00</span>
                            </div>
                            <div class="summary-item"><span class="text">Total</span>
                                 <span id="total" class="price">$0.00</span>
                            </div>
                            <br>
                            <br>
                            <br>
                            <button onclick="window.location.href='../nuevaCaja.php'" type="button"
                            class="btn btn-primary btn-lg btn-block">Enviar</button>
                         </div>
                 </div>

            </div>

        </main>

    </div>
    <script>


        function CapturarPedido(id) {
            if (confirm("¿Estás seguro de que quieres agregar este producto?")) {
                var cantidad = document.getElementById("cantidad_" + id).value;

                $.ajax({
                    url: "Carrito.php",
                    type: "GET",
                    data: { id: id, cantidad: cantidad },
                    success: function (response) {
                        var tbody = document.querySelector('.summary tbody');
                        tbody.innerHTML += response;
                        actualizarTotales();
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", status, error);
                    }
                });
            }
        }

        function actualizarTotales() {
            let subtotal = 0;
            let total = 0;

          
            document.querySelectorAll('.summary tbody .price').forEach(function (element) {
                subtotal += parseFloat(element.textContent.replace(/[^0-9.-]+/g, ""));
            });

           
            const impuesto = 0; // Ejemplo de impuesto fijo
            total = subtotal + impuesto;

         
            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total').textContent = '$' + total.toFixed(2);
        }
    </script>
    <script src="../js/tablas.js"></script>
    <script src="../js/Homepage.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="sweetAlert.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>
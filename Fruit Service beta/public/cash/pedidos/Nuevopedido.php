<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruitservice</title>
    <link rel="stylesheet" href="../../css/pagar.css">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <!--jquery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.css" />
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body>
    <main class="page">
        <section class="shopping-cart dark">
            <div class="container">
                <div class="block-heading">
                    <h2>Productos</h2>
                    <div class="input-group mb-3">

                    </div>
                    <div class="content">
                        <div class="row">
                            <div class="col-md-12 col-lg-8">
                                <div class="items">
                                    <div class="product">
                                        <table id="tabla" class="table table-striped" style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th class="centered">Producto</th>
                                                    <th class="centered">Descripcion</th>
                                                    <th class="centered">Precio</th>
                                                    <th class="centered">Cantidad</th>
                                                    <th class="centered">opciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                include "../../../modelos/ConexionBD.php";

                                                $resultado = mysqli_query($conexion, "SELECT * FROM productos");
                                                while ($consulta = mysqli_fetch_array($resultado)) {
                                                    echo "<tr>";
                                                    echo "<td><img src='../../" . $consulta["Imagen"] . "' class='table-img'  style='width: 100px;height: auto;'> <br>" . $consulta["Nombre_del_producto"] . "</td>";
                                                    echo "<td><br>" . $consulta["descripcion"] . "</td>";
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
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
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
                                    <button onclick="agregar()" type="button"
                                        class="btn btn-primary btn-lg btn-block">Enviar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <script>
        let productosSeleccionados = [];

        function CapturarPedido(id) {
            if (confirm("¿Estás seguro de que quieres agregar este producto?")) {
                var cantidad = document.getElementById("cantidad_" + id).value;

                $.ajax({
                    url: "Carrito.php",
                    type: "GET",
                    data: {
                        id: id,
                        cantidad: cantidad
                    },
                    success: function (response) {
                        var tbody = document.querySelector('.summary tbody');
                        tbody.innerHTML += response;
                        productosSeleccionados.push({
                            id: id,
                            cantidad: cantidad
                        });

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
            total = subtotal;
            document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
            document.getElementById('total').textContent = '$' + total.toFixed(2);
            return {
                subtotal: subtotal,
                total: total
            };
        }


        function borrarProducto(id) {
    if (confirm("¿Estás seguro de que quieres eliminar este producto?")) {

        var filaProducto = document.getElementById("producto_" + id);
        if (filaProducto) {
            filaProducto.remove();
        }
        productosSeleccionados = productosSeleccionados.filter(function (producto) {
            return producto.id != id;
        });
        actualizarTotales();
    }
}
        function agregar() {
            const totales = actualizarTotales();

            if (confirm("¿Estás seguro de enviar el pedido?")) {
                $.ajax({
                    url: "agregar_pedido.php",
                    type: "GET",
                    data: {
                        productos: productosSeleccionados,
                        subtotal: totales.subtotal,
                        total: totales.total
                    },
                    success: function (response) {
                        alert("¡Pedido enviado con éxito!");
                        window.location.href = "../nuevaCaja.php";
                    },
                    error: function (xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", status, error);
                    }
                });
            }
        }

    </script>

    </script>
    <script src="../../js/tablas.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
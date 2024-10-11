<?php
// Este archivo gestiona la página de pedidos, permitiendo la visualización de productos disponibles y la creación de pedidos.
// Se inicia la sesión y se incluye el archivo de conexión a la base de datos. 
// Si se recibe un ID de pedido a través de la URL, se consulta la base de datos para obtener los productos relacionados con ese pedido.
// Los productos se almacenan en un arreglo para su posterior procesamiento. 
// El archivo genera un HTML que muestra una lista de productos disponibles, junto con un resumen de los productos seleccionados, 
// sus precios y un botón para enviar el pedido. 
// Se utilizan varias bibliotecas para el diseño y la funcionalidad, incluyendo Bootstrap, jQuery, DataTables y SweetAlert para las alertas.
session_start();
include "../../../modelos/ConexionBD.php";
if (isset($_GET['id'])) {
    $id_pedido = intval($_GET['id']);
    $stmt = $conexion->prepare("SELECT id_producto, total FROM pedidos WHERE id_pedido = ?");
    $stmt->bind_param("i", $id_pedido);
    $stmt->execute();
    $result = $stmt->get_result();

    $productos = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $productos[] = [
                'id_producto' => $row['id_producto'],
                'total' => $row['total']
            ];
        }
    }
    $conexion->close();
    foreach ($productos as $producto) {
    }
} else {
    echo "No se ha especificado un ID de pedido.";
}






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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    

</head>

<body>
    <main class="page">
        <section class="shopping-cart dark">
            <div class="container">
                <div class="block-heading">
                    <h2>Productos</h2>
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
                                                    <th class="centered">Opciones</th>
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
                                                $conexion->close();
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-4">
                                <div class="summary">
                                    <h3>Factura</h3>
                                    <div class="summary-item">
                                        <span class="text">Productos:</span>
                                        <br>
                                        <table style="text-align: center;">
                                            <thead>
                                                <tr>
                                                    <th>Nombre del Producto</th>
                                                    <th>Subtotal</th>
                                                    <th>Eliminar</th>
                                                </tr>
                                            </thead>
                                            <tbody class="productos-carrito">
                                                <!-- Aquí se agregarán los productos -->
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
    </main>
    <script>
    let productosSeleccionados = [];

    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const idPedido = urlParams.get('id');

        if (idPedido) {
            $.ajax({
                url: "carrito.php",
                type: "GET",
                data: {
                    id: idPedido
                },
                success: function (response) {
                    var tbody = document.querySelector('.productos-carrito');
                    tbody.innerHTML += response;
                    actualizarTotales();
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema con la carga de productos.'
                    });
                }
            });
        }
    });

    function CapturarPedido(id) {
        Swal.fire({
            title: '¿Estás seguro de que quieres agregar este producto?',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                var cantidad = document.getElementById("cantidad_" + id).value;

                $.ajax({
                    url: "carrito2.php",
                    type: "GET",
                    data: {
                        id: id,
                        cantidad: cantidad
                    },
                    success: function (response) {
                        var tbody = document.querySelector('.productos-carrito');
                        tbody.innerHTML += response;
                        productosSeleccionados.push({
                            id: id,
                            cantidad: cantidad
                        });

                        actualizarTotales();
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema con la solicitud. Inténtalo de nuevo.'
                        });
                    }
                });
            }
        });
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
        Swal.fire({
            title: '¿Estás seguro de que quieres eliminar este producto?',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                var filaProducto = document.getElementById("producto_" + id);
                
                // Primero, elimina la fila del carrito de la vista
                if (filaProducto) {
                    filaProducto.remove(); // Elimina la fila de la tabla
                }
                
                // Filtra el producto seleccionado para eliminarlo de la lista de productos seleccionados
                productosSeleccionados = productosSeleccionados.filter(function (producto) {
                    return producto.id != id;
                });

                // Actualiza los totales después de eliminar
                actualizarTotales();
                
                $.ajax({
                    url: "borrar_pedido.php", 
                    type: "POST",
                    data: {
                        id: id
                    },
                    success: function (response) {
                        const resultado = JSON.parse(response);
                        if (resultado.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Éxito',
                                text: 'Producto eliminado de la base de datos.'
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error: ' + resultado.message
                            });
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al intentar eliminar el producto.'
                        });
                    }
                });
            }
        });
    }

    function agregar() {
        const totales = actualizarTotales();  
        const urlParams = new URLSearchParams(window.location.search);
        const idPedido = urlParams.get('id');  

        if (productosSeleccionados.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Advertencia',
                text: 'No has seleccionado ningún producto, pero se enviará el pedido con los productos existentes.'
            });
        }

        Swal.fire({
            title: '¿Estás seguro de enviar el pedido?',
            showCancelButton: true,
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "agregar_pedido.php",
                    type: "POST",
                    data: {
                        productos: JSON.stringify(productosSeleccionados),  // Serializa a JSON
                        subtotal: totales.subtotal, 
                        total: totales.total,       
                        id: idPedido  
                    },
                    success: function (response) {
                        console.log("Respuesta del servidor:", response);  // Para depurar
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: '¡Pedido enviado con éxito!'
                        }).then(() => {
                            window.location.href = "../nuevaCaja.php";  
                        });
                    },
                    error: function (xhr, status, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un problema al enviar el pedido. Inténtalo de nuevo.'
                        });
                    }
                });
            }
        });
    }
</script>

    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../../js/tablas.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
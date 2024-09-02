<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Añadir Producto</title>
</head>
<body>
    <link rel="stylesheet" href="../css/style.css">
    <!-- Bootstrap-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous" />
    <!-- DataTable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css" />
    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer"
    />

</head>
<body>
   <div class="menu">
       <ion-icon name="menu-outline"></ion-icon>
       <ion-icon name="close-outline"></ion-icon>
   </div>

   <div class="barra-lateral">
       <div>
           <div class="nombre-pagina">
               <ion-icon name="ice-cream-outline"></ion-icon>
               <span>Fruit service</span>
           </div>
       </div>

       <nav class="navegacion">
           <ul>
               <li>
                   <a  href="../nuevaCaja.php">
                       <ion-icon name="home-outline"></ion-icon>
                       <span>Inicio</span>
                   </a>
               </li>
               <li>
                   <a href="#">
                       <ion-icon name="construct-outline"></ion-icon>
                       <span>Configuracion</span>
                   </a>
               </li>
               <li class="nav-item dropdown">
                   <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                       <ion-icon name="fast-food-outline"></ion-icon>
                       <span>Productos</span>
                   </a>
                   <ul class="dropdown-menu">
                     <li><a class="dropdown-item" href="eliminar.php"><ion-icon name="trash-outline"></ion-icon>Eliminar</a></li>
                     <li><a class="dropdown-item" href="Editar.php"><ion-icon name="pencil-outline"></ion-icon>Editar</a></li>
                   </ul>
               </li>
                   
   
               <li>
                   <a href="../Reportes.php">
                       <ion-icon name="alert-circle-outline"></ion-icon>
                       <span>Reportes</span>
                   </a>
               </li>
               <li>
                   <a href="../../Configuracion/Salir.php">
                       <ion-icon name="power-outline"></ion-icon>
                       <span>Salir</span>
                   </a>
               </li>
               
           </ul>
       </nav>

       <div>
           <div class="linea"></div>

           <div class="modo-oscuro">
               <div class="info">
                   <ion-icon name="moon-outline"></ion-icon>
                   <span>Dark Mode</span>
               </div>
               <div class="switch">
                   <div class="base">
                       <div class="circulo">
                           
                       </div>
                   </div>
               </div>
           </div>
   
           <div class="usuario">
               <img src="../imagenes/logoN.png" alt="">
               <div class="info-usuario">
                   <div class="nombre-email">
                       <span class="nombre">Soporte</span>
                       <span class="email">Fruitservice@gmail.com</span>
                   </div>
                   <ion-icon name="ellipsis-vertical-outline"></ion-icon>
               </div>
           </div>
       </div>

   </div>


   <main class="contenido">
       <section  >
           <div class="Usuario">
           <?php
                  
                  if(isset($_SESSION['nombre'])) {
                    $usuario = $_SESSION['nombre'];
                  echo '<img src="../imagenes/usuario.png" style="width: 40px; margin: 5px; margin-right: 7px;">',$usuario;
                    
                }
                else {
                    echo "No hay datos de sesión disponibles.";
                }
                  
                ?>
               <br>
               <div>

               <form action="Agrega.php" enctype="multipart/form-data" method="post" >

                <table id="datatable_users" class="table table-striped" style="text-align: center;">
                    <thead>
                        <tr>
                            <th class="centered">Nombre del producto</th>
                        </tr>
             
                        <tbody id="tableBody_users">
                        <tr>
                            <td><input type="text" style="width: 150px; margin: 5px; margin-right: 7px;" name="Nombre_producto" required></td>
                        </tr>
                        </tbody>
                    </thead>

                    <thead>
                        <tr>
                            <th class="centered">Descripción</th>
                        </tr>
                        <tbody id="tableBody_users">
                            <tr>
                                <td><input  type="text" style="width: 150px; margin: 5px; margin-right: 7px;" name="Descripcion" required></td>
                            </tr>
                            </tbody>
                    </thead>

                    <thead>
                        <tr>
                            <th class="centered">Precio</th>
                        </tr>
                        <tbody id="tableBody_users">
                            <tr>
                                <td><input style="width: 150px; margin: 5px; margin-right: 7px;" name="Precio" type="number" required></td>
                            </tr>
                            </tbody>
                    </thead>
                    
                </table>

                <br>

                <center>
                    <button  class="btn btn-outline-success">
                    <svg xmlns="http://www.w3.org/2000/svg" height="16" fill="currentColor" class="bi bi-door-closed-fill" viewBox="0 0 1 16"></svg>
                  
                    <span>Añadir producto
                    </span></button>
                </center>

               </div>
           </div>
           
           
       </section>   

      <br>
      <br>

      <div class="d-flex justify-content-center">
        <table id="datatable_users">
            <thead>
                <tr>
                    <th>Imagen del producto</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Imagen:</td>
                    <td>
                        <img style="width: 150px;" id="preview1" class="preview-img" src="../imagenes/crema-removebg-preview.png" alt="Previsualización de la Imagen 1"><br><br><br>
                        <div class="input-container">
                            <label class="custom-file-upload">Subir archivo<input type="file" name="imagen" ></label>
                            <?php 
			                /*  echo isset($_GET{"aviso"})? "<br> <center> <p>el Producto se agrego correctamente</p> </center>": " "; */


			                ?>
                        
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        </form>
      </div>
      <script src="js/añadir_pd.js"></script>


       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
       <!-- jQuery -->

       <!-- DataTable -->
       <!-- 
       <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
       <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --> 
       <!-- Custom JS -->
       <script src="js/main.js"></script>
   </main>


   <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
   <script src="../js/script.js"></script>
   
</body>
</html>
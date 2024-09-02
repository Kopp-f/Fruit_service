<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruitservice</title>
    <link rel="stylesheet" href="css/style.css">
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
                    <a  href="cajas.php">
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
                      <li><a class="dropdown-item" href="Productos/eliminar.php"><ion-icon name="trash-outline"></ion-icon>Eliminar</a></li>
                      <li><a class="dropdown-item" href="Productos/agregar_producto.php"><ion-icon name="duplicate-outline"></ion-icon>Crear</a></li>
                      <li><a class="dropdown-item" href="Productos/Editar.php"><ion-icon name="pencil-outline"></ion-icon>Editar</a></li>
                    </ul>
                </li>
                <li>
                    <a href="../Configuracion/Salir.php">
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
                    <span>Drak Mode</span>
                </div>
                <div class="switch">
                    <div class="base">
                        <div class="circulo">
                            
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="usuario">
                <img src="imagenes/logoN.png" alt="">
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
                  echo '<img src="imagenes/usuario.png" style="width: 40px; margin: 5px; margin-right: 7px;">',$usuario;
                    
                }
                else {
                    echo "No hay datos de sesión disponibles.";
                }
                  
                ?>
               
            </div>
        </section>

        <h1>Reportes</h1>
        <br>

        <form action="EnviarEmail.php" method="post" enctype="multipart/form-data">
    <div class="col_one_third col_last c-azul">
        <label for="nacimiento">Fecha del Reporte<small></small></label>
        <input type="date" id="nacimiento" name="nacimiento" class="sm-form-control">
    </div>
    <br>
    <div class="form-group">
        <label for="from_email">Tu Email 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            </svg>
        </label>
        <input class="form-control" type="email" id="from_email" name="from_email" required>
    </div>
    <br>
    <div class="form-group">
        <label for="to_email">Destinatario 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
            </svg>
        </label>
        <input class="form-control" type="text" id="to_email" name="to_email" required>
    </div>
    <br>
    <div class="form-group">
        <label for="subject">Asunto 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
            </svg>
        </label>
        <input class="form-control" type="text" id="subject" name="subject" required>
    </div>
    <br>
    <div class="form-group">
    <label for="message">Mensaje
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
            <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z"/>
        </svg>
    </label>
    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
</div>
<br>
     <div class="form-group">
                <label for="exampleFormControlFile1">Evidencia de Reporte <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-check-fill" viewBox="0 0 16 16">
                    <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1m1.354 4.354-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708.708"/>
                  </svg></label>
                  <label type="file" class="form-control-file" id="attachment" name="attachment" >Cargar Evidencia<input type="file" class="form-control-file" id="exampleFormControlFile1"></label>
            </div>
       
        
       
    <br>
    <button type="submit" class="btn btn-primary mb-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-capslock-fill" viewBox="0 2 16 16">
            <path d="M7.27 1.047a1 1 0 0 1 1.46 0l6.345 6.77c.6.638.146 1.683-.73 1.683H11.5v1a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1v-1H1.654C.78 9.5.326 8.455.924 7.816zM4.5 13.5a1 1 0 0 1 1-1h5a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1h-5a1 1 0 0 1-1-1z"/>
        </svg> Enviar
    </button>
    <br> 
    <p>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-exclamation-fill" viewBox="0 0 16 16">
            <path d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414zM0 4.697v7.104l5.803-3.558zM6.761 8.83l-6.57 4.026A2 2 0 0 0 2 14h6.256A4.5 4.5 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586zM16 4.697v4.974A4.5 4.5 0 0 0 12.5 8a4.5 4.5 0 0 0-1.965.45l-.338-.207z"/>
            <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.5-5v1.5a.5.5 0 0 1-1 0V11a.5.5 0 0 1 1 0m0 3a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
        </svg>  
    </p>
</form>

        <script src="js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    </main>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
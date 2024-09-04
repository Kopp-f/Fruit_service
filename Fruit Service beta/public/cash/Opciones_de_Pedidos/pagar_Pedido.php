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
    <br>
       <center><h1>Facturación</h1></center> 
       

        <div class="container my-4">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <table id="datatable_users" class="table table-striped" style="text-align: center;">
                        <caption>
                            Cajas registradas
                        </caption>
                        <thead>
                            <tr>
                                <th class="centered">Cantidad</th>
                                <th class="centered">producto</th>
                                <th class="centered">Total</th>
                            </tr>
                        </thead>

                        <tbody id="tableBody_users">
                            <tr>
                                <td> 1</td>
                                <td>Helado</td>
                                <td>1000</td>
                            </tr>
                            <tr>
                                <td> 1</td>
                                <td>Salpicon Pequeño</td>
                                <td>1300</td>
                            </tr>

                        </tbody>
                    </table>

                    <form class="conteiner">
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                            </div> Efectivo
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                            </div> Transferencia
                       
                        </div>
                    </form>


                    <button class="btn btn-sm btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer-fill" viewBox="0 0 16 16">
                    <path d="M5 1a2 2 0 0 0-2 2v1h10V3a2 2 0 0 0-2-2zm6 8H5a1 1 0 0 0-1 1v3a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-3a1 1 0 0 0-1-1"/>
                    <path d="M0 7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2h-1v-2a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v2H2a2 2 0 0 1-2-2zm2.5 1a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1"/>
                    </svg></button>
                <button onclick="window.location.href='../nuevaCaja.php'" class="btn btn-sm btn-danger"><i class="fa-solid fa-trash-can"></i></button>
                <button onclick="window.location.href='../nuevaCaja.php'" class="btn btn-sm" style=" background-color: green;color:white "><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-send-fill" viewBox="0 0 16 16">
                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
                  </svg></button>
                </div>  
                
               
            </div>
        </div>

      
        <!-- jQuery -->

        <!-- DataTable -->
<!-- 
        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script> --> 
        <!-- Custom JS -->
        <script src="js/main.js"></script>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
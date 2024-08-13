<?php

use Controladores\InicioControlador;
use Libreria\Enrutador;

//require_once "../libreria/Enrutador.php";


Enrutador::get("/", [InicioControlador::class, "inicio"]); //primera ruta ourl
// Enrutador::get("/", function(){
//     echo "ruta inico";
// });
Enrutador:: get("/producto", function () { //tercera ruta o url
    return "Ruta get de productos";
});

Enrutador:: get("/productos/:miVar", function ($var) { //cuarta ruta o url
    return "Ruta get de productos con variable : $var";
    });
    
var_dump(Enrutador::obtenerRuta());

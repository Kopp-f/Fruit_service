<?php
// Este script cierra la sesión actual del usuario.
// Utiliza `session_destroy()` para eliminar todos los datos de la sesión y luego redirige al usuario a la página de inicio (index.php).
session_start();

session_destroy();
header("Location: ../public/index.php");
exit();


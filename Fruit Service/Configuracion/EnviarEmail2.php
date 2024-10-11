<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Cargar el autoloader de Composer (si estás utilizando Composer)
// require 'vendor/autoload.php'; // Descomentar si estás utilizando Composer

require '../libreria/PHPMailer/Exception.php';
require '../libreria/PHPMailer/PHPMailer.php';
require '../libreria/PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validar y sanear los datos de entrada
    $fromEmail = filter_var($_POST['from_email'], FILTER_SANITIZE_EMAIL);
    $toEmail = 'andress040406@gmail.com'; // Correo del destinatario definido

    $subject = htmlspecialchars($_POST['subject']);
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Crear una instancia; pasar true habilita las excepciones
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Deshabilitar salida de depuración detallada para producción
        $mail->isSMTP(); // Enviar usando SMTP
        $mail->Host = 'smtp.gmail.com'; // Establecer el servidor SMTP para enviar a través de
        $mail->SMTPAuth = true; // Habilitar autenticación SMTP
        $mail->Username = 'andress040406@gmail.com'; // Nombre de usuario SMTP
        $mail->Password = 'mjdkjrwwzijnxeqx'; // Contraseña SMTP
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Habilitar encriptación TLS implícita
        $mail->Port = 465; // Puerto TCP para conectar

        // Destinatarios
        $mail->setFrom($fromEmail, 'Soporte Fruit Service');
        if (filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            $mail->addAddress($toEmail); // Añadir el correo fijo del destinatario
        } else {
            throw new Exception("Correo del destinatario inválido: $toEmail"); // Lanzar excepción si el correo es inválido
        }

        // Archivos adjuntos
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']); // Añadir el archivo adjunto
            } else {
                throw new Exception("Subida de archivo inválida"); // Lanzar excepción si la subida es inválida
            }
        }

        // Contenido
        $mail->isHTML(true); // Establecer el formato del correo como HTML
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message); // Cuerpo alternativo del correo

        $mail->send();

        // Mensaje de éxito
        echo '<script>alert("Reporte enviado correctamente");</script>'; // Alerta de éxito

        // Redirección
        if (isset($_SERVER['HTTP_REFERER'])) {
            header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
            exit();
        } else {
            header("Location: ../public/app/Reportes.php"); // Redirigir a la página de reportes
            exit();
        }

    } catch (Exception $e) {
        echo '<script>alert("No se pudo enviar el mensaje. Error de envío ' . $mail->ErrorInfo . '"); window.location.href = "../public/app/Reportes.php";</script>'; // Mensaje de error
    }
}


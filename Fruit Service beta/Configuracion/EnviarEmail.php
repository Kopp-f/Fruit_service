<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader (if you are using Composer)
// require 'vendor/autoload.php'; // Uncomment if you are using Composer

require '../libreria/PHPMailer/Exception.php';
require '../libreria/PHPMailer/PHPMailer.php';
require '../libreria/PHPMailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize input data
    $fromEmail = filter_var($_POST['from_email'], FILTER_SANITIZE_EMAIL);
    $toEmails = array_map('trim', explode(',', $_POST['to_email'])); // Sanitize each email
    $subject = htmlspecialchars($_POST['subject']);
    $message = isset($_POST['message']) ? htmlspecialchars($_POST['message']) : '';

    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                        // Disable verbose debug output for production
        $mail->isSMTP();                                           // Send using SMTP
        $mail->Host = 'smtp.gmail.com';                      // Set the SMTP server to send through
        $mail->SMTPAuth = true;                                  // Enable SMTP authentication
        $mail->Username = 'andress040406@gmail.com';             // SMTP username
        $mail->Password = 'yszavncvyewunjse';                    // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;           // Enable implicit TLS encryption
        $mail->Port = 465;                                   // TCP port to connect to

        // Recipients
        $mail->setFrom($fromEmail, 'Soporte Fruit Service');
        foreach ($toEmails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mail->addAddress($email);                       // Add each recipient
            } else {
                throw new Exception("Invalid recipient email: $email");
            }
        }

        // Attachments
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            if (is_uploaded_file($_FILES['attachment']['tmp_name'])) {
                $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
            } else {
                throw new Exception("Invalid file upload");
            }
        }

        // Content
        $mail->isHTML(true);                                       // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = strip_tags($message);

        $mail->send();

       
        if (isset($_SERVER['HTTP_REFERER'])) {

            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        } else {
           
            header("Location: ../public/caja.php");
            exit();
        }

    } catch (Exception $e) {
        echo '<script>alert("No se pudo enviar el mensaje. Error de envío ' . $mail->ErrorInfo . '"); window.location.href = "../public/cajas.php";</script>';
    }
}

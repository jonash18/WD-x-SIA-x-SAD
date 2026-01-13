<?php
require __DIR__ . '/vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$name  = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';

$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'jonashvalenciagta@gmail.com';
    $mail->Password   = 'gfml buxo kvzk otxb'; // Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('jonashvalenciagta@gmail.com', 'Document System');
    $mail->addAddress($email, $name);

    $mail->Subject = "Document Accepted";
    $mail->Body    = "Hello $name,\n\nYour document has been accepted.\n\nThank you!";

    $mail->send();
} catch (Exception $e) {
    error_log("Mailer Error: {$mail->ErrorInfo}");
}

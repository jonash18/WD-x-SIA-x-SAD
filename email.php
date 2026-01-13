<?php
require __DIR__ . '/vendor/autoload.php'; // Composer autoload

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // or your mail server
            $mail->SMTPAuth   = true;
            $mail->Username   = 'jonashvalenciagta@gmail.com'; // customersupport email
            $mail->Password   = 'gfml buxo kvzk otxb';   // Gmail App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            $mail->setFrom('jonashvalenciagta@gmail.com', 'Document System');
            $mail->addAddress($email , $name);

            $mail->Subject = "Document Accepted - $website";
            $mail->Body    = "Hello $name,\n\nYour document for category '$category' has been accepted.\n\nDetails:\n$body\n\nThank you!";

            $mail->send();
        } catch (Exception $e) {
            error_log("Mailer Error: {$mail->ErrorInfo}");
        }


?>
